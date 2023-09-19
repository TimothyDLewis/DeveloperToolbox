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
use Illuminate\Database\Eloquent\Builder;
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
    'allows_weekends' => [
      'container-class' => 'col-12 col-sm-6',
      'custom_editor' => 'boolean',
      'label' => 'Allow Weekends',
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

  public function generateYearlyOccurrence(?int $year = null, ?Sprint $sprint = null, bool $save = false): ?Occurrence {
    if (!$this->yearly_eval_logic) {
      return null;
    }

    try {
      if (is_null($year)) {
        $year = (int)date('Y');
      }

      $occurrence = Carbon::parse(eval($this->yearly_eval_logic));

      if ($occurrence->isSaturday()) {
        $occurrence = $occurrence->subDays(1);
      } elseif ($occurrence->isSunday()) {
        $occurrence = $occurrence->addDays(1);
      }

      // Shift Boxing Day if Christmas is on Friday (move to Monday) or Sunday (move to Tuesday)
      if ($this->slug == 'boxing-day') {
        $christmas = Carbon::parse(eval(Event::where('slug', 'christmas')->first()->yearly_eval_logic));
        if ($christmas->isFriday()) {
          $occurrence = $occurrence->addDays(3);
        } elseif ($christmas->isSunday()) {
          $occurrence = $occurrence->addDays(1);
        }
      }

      $occurrenceDateTime = $occurrence->startOfDay();

      $occurrenceData = [
        'all_day' => true,
        'end_datetime' => $occurrenceDateTime,
        'event_id' => $this->id,
        'start_datetime' => $occurrenceDateTime
      ];

      if ($sprint) {
        $occurrenceData['sprint_id'] = $sprint->id;
      }

      if ($save) {
        return Occurrence::create($occurrenceData);
      }

      return new Occurrence($occurrenceData);
    } catch (Exception $ex) {
      Log::error($ex);

      return null;
    }
  }

  public function canEdit(): bool {
    return (bool)!$this->yearly_eval_logic;
  }

  public function scopeRecurs(Builder $query): Builder {
    return $query->where('recurrence', '!=', EventRecurrence::NoRecurrence->value);
  }

  public function eventType(): BelongsTo {
    return $this->belongsTo(EventType::class);
  }

  public function occurrences(): HasMany {
    return $this->hasMany(Occurrence::class);
  }
}
