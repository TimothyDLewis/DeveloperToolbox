<?php

namespace App\Models;

use Exception;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Enums\EventRecurrence;
use App\Traits\Models\ForSelect;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use App\Traits\Models\AttributeDisplay;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model {
  use AttributeDisplay;
  use ForSelect;
  use HasFactory;
  use SoftDeletes;

  protected $casts = ['recurrence_days' => 'json'];

  protected $guarded = [];

  public $formFields = [
    'affects_productivity' => [
      'container-class' => 'col-12 col-sm-6',
      'custom_editor' => 'boolean',
      'label' => 'Affects Productivity',
      'type' => 'custom'
    ],
    'description' => [
      'container-class' => 'col-12',
      'label' => 'Description',
      'type' => 'textarea'
    ],
    'event_type_id' => [
      'container-class' => 'col-12 col-sm-6',
      'label' => 'Event Type',
      'type' => 'select'
    ],
    'recurrence' => [
      'container-class' => 'col-12 col-sm-6 col-md-4',
      'label' => 'Recurrence',
      'type' => 'enum-select'
    ],
    'recurrence_end_time' => [
      'container-class' => 'col-12 col-sm-6 col-md-4',
      'label' => 'Recurrence End',
      'step' => 300, // 5 Minutes
      'type' => 'time'
    ],
    'recurrence_start_time' => [
      'container-class' => 'col-12 col-sm-6 col-md-4',
      'label' => 'Recurrence Start',
      'step' => 300, // 5 Minutes
      'type' => 'time'
    ],
    'title' => [
      'container-class' => 'col-12',
      'derivative' => 'slug',
      'label' => 'Title',
      'type' => 'text'
    ]
  ];

  public static function recurrences(): array {
    return array_column(EventRecurrence::cases(), 'value');
  }

  public static function recurrencesForSelect(): Collection {
    return collect(EventRecurrence::cases())->map(function ($recurrence) {
      return (object)[
        'label' => Str::title(Str::replace('_', ' ', $recurrence->value)),
        'value' => $recurrence->value
      ];
    });
  }

  public function generateYearlyOccurence(?int $year = null, ?Sprint $sprint = null, bool $save = false): ?Occurence {
    if (!$this->yearly_eval_logic) {
      return null;
    }

    try {
      if (is_null($year)) {
        $year = (int)date('Y');
      }

      $occurence = Carbon::parse(eval($this->yearly_eval_logic));

      if ($occurence->isSaturday()) {
        $occurence = $occurence->subDays(1);
      } elseif ($occurence->isSunday()) {
        $occurence = $occurence->addDays(1);
      }

      // Shift Boxing Day if Christmas is on Friday (move to Monday) or Sunday (move to Tuesday)
      if ($this->slug == 'boxing-day') {
        $christmas = Carbon::parse(eval(Event::where('slug', 'christmas')->first()->yearly_eval_logic));
        if ($christmas->isFriday()) {
          $occurence = $occurence->addDays(3);
        } elseif ($christmas->isSunday()) {
          $occurence = $occurence->addDays(1);
        }
      }

      $occurenceDateTime = $occurence->startOfDay();

      $occurenceData = [
        'all_day' => true,
        'end_datetime' => $occurenceDateTime,
        'event_id' => $this->id,
        'start_datetime' => $occurenceDateTime
      ];

      if ($sprint) {
        $occurenceData['sprint_id'] = $sprint->id;
      }

      if ($save) {
        return Occurence::create($occurenceData);
      }

      return new Occurence($occurenceData);
    } catch (Exception $ex) {
      Log::error($ex);

      return null;
    }
  }

  public function canEdit(): bool {
    return (bool)!$this->yearly_eval_logic;
  }

  public function eventType(): BelongsTo {
    return $this->belongsTo(EventType::class);
  }

  public function occurences(): HasMany {
    return $this->hasMany(Occurence::class);
  }
}
