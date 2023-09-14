<?php

namespace App\Models;

use Carbon\Carbon;
use App\Traits\Models\AttributeDisplay;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Sprint extends Model {
  use AttributeDisplay;
  use HasFactory;
  use SoftDeletes;

  protected $guarded = [];

  public $formFields = [
    'description' => [
      'container-class' => 'col-12',
      'label' => 'Description',
      'type' => 'textarea'
    ],
    'issues' => [
      'type' => 'association'
    ],
    'title' => [
      'container-class' => 'col-12',
      'derivative' => 'slug',
      'label' => 'Title',
      'type' => 'text'
    ],
    'end_date' => [
      'container-class' => 'col-12 col-sm-6',
      'label' => 'End',
      'type' => 'date'
    ],
    'start_date' => [
      'container-class' => 'col-12 col-sm-6',
      'label' => 'Start',
      'type' => 'date'
    ]
  ];

  protected static function booted(): void {
    static::created(function (Sprint $sprint): void {
      $sprint->generateEventOccurences();
    });
  }

  protected function generateEventOccurences(bool $deleteExisting = false): void {
    if ($deleteExisting) {
      $this->occurrences()->forceDelete();
    }

    $recurringEvents = Event::recurs()->get()->groupBy('recurrence');

    $iterationDate = Carbon::parse($this->start_date);
    while ($iterationDate <= $this->end_date) {
      if ($iterationDate->isWeekday()) {
        if ($iterationDate->isSameDay($this->start_date)) {
          $this->generateOccurrences($iterationDate, $recurringEvents['sprint_start'] ?? []);
        }

        if ($iterationDate->isSameDay($this->midpoint_date)) {
          $this->generateOccurrences($iterationDate, $recurringEvents['mid_sprint'] ?? []);
        }

        if ($iterationDate->isSameDay($this->end_date)) {
          $this->generateOccurrences($iterationDate, $recurringEvents['sprint_end'] ?? []);
        }

        $this->generateOccurrences($iterationDate, $recurringEvents['sprint_daily'] ?? []);
      }

      foreach($recurringEvents['sprint_weekly'] ?? [] as $weeklyEvent) {
        $recurrenceData = $weeklyEvent->recurrence_days[strtolower($iterationDate->format('l'))] ?? null;

        if ($recurrenceData && $recurrenceData['enabled']) {
          $this->generateOccurrences($iterationDate, [$weeklyEvent], $recurrenceData['recurrence_start_time'], $recurrenceData['recurrence_end_time']);
        }
      }

      $iterationDate->addDays(1);
    }
  }

  protected function generateOccurrences(Carbon $date, mixed $events, $recurrenceStart = null, $recurrenceEnd = null): void {
    foreach ($events as $event) {
      $startDate = $date->copy()->hour(Carbon::parse($recurrenceStart ?? $event->recurrence_start)->format('H'))
      ->minute(Carbon::parse($recurrenceStart ?? $event->recurrence_start)->format('i'))
      ->second(0);

      $endDate = $date->copy()->hour(Carbon::parse($recurrenceEnd ?? $event->recurrence_end)->format('H'))
      ->minute(Carbon::parse($recurrenceEnd ?? $event->recurrence_end)->format('i'))
      ->second(0);

      $event->occurrences()->create([
        'sprint_id' => $this->id,
        'start_datetime' => $startDate,
        'end_datetime' => $endDate
      ]);
    }
  }

  public function scopeOverlapsDate(Builder $query, Carbon $dateTime): Builder {
    return $query->whereRaw('? >= start_date AND ? <= end_date', [$dateTime, $dateTime]);
  }

  public function issues(): BelongsToMany {
    return $this->belongsToMany(Issue::class);
  }

  public function occurrences(): HasMany {
    return $this->hasMany(Occurrence::class);
  }


}
