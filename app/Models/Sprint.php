<?php

namespace App\Models;

use Carbon\Carbon;
use App\Traits\Models\AttributeDisplay;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Sprint extends Model {
  use AttributeDisplay;
  use HasFactory;
  use SoftDeletes;

  protected $guarded = [];

  protected $hidden = ['issues', 'created_at', 'updated_at', 'deleted_at'];
  protected $appends = ['fullcalendar_start_date', 'fullcalendar_end_date'];

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

  public function fullcalendarEndDate(): Attribute {
    return Attribute::make(
      get: function (): string {
        return $this->end_date . ' 23:59:59';
      }
    );
  }

  public function fullcalendarStartDate(): Attribute {
    return Attribute::make(
      get: function (): string {
        return $this->start_date . ' 00:00:00';
      }
    );
  }

  public function midpointDate(): Attribute {
    return Attribute::make(
      get: function() {
        return Carbon::createFromTimestamp((Carbon::parse($this->start_date)->startOfDay()->format('U') + Carbon::parse($this->end_date)->endOfDay()->format('U')) / 2)->startofDay();
      }
    );
  }

  protected static function booted(): void {
    static::created(function (Sprint $sprint): void {
      $sprint->generateEventOccurences();
    });
  }

  public function generateEventOccurences(bool $deleteExisting = false): void {
    if ($deleteExisting) {
      $this->occurrences()->forceDelete();
    }

    $recurringEvents = Event::recurs()->get()->groupBy('recurrence');

    $sprintStartDate = Carbon::parse($this->start_date)->startOfDay();
    $sprintStartWeekday = $sprintStartDate->isWeekend() ? $sprintStartDate->copy()->addDays($sprintStartDate->isSaturday() ? 2 : 1)->startOfDay() : $sprintStartDate->copy();

    $sprintMidDate = $this->midpoint_date;
    $sprintMidWeekdate = $sprintMidDate->copy();
    if ($sprintMidDate->isSaturday()) {
      $sprintMidWeekdate = $sprintMidWeekdate->subDays(1);
    } else if ($sprintMidDate->isSunday()) {
      $sprintMidWeekdate = $sprintMidWeekdate->addDays(1);
    }

    $sprintEndDate = Carbon::parse($this->end_date)->startOfDay();
    $sprintEndWeekday = $sprintEndDate->isWeekend() ? $sprintEndDate->copy()->subDays($sprintEndDate->isSaturday() ? 1 : 2)->startOfDay() : $sprintEndDate->copy();

    $iterationDate = $sprintStartDate->copy();
    while ($iterationDate <= $sprintEndDate) {
      foreach($recurringEvents['sprint_start'] ?? [] as $sprintStartEvent) {
        if (($sprintStartEvent->allows_weekends && $iterationDate->isSameDay($sprintStartDate)) || (!$sprintStartEvent->allows_weekends && $iterationDate->isSameDay($sprintStartWeekday))) {
          $this->generateOccurrence($iterationDate, $sprintStartEvent);
        }
      }

      foreach($recurringEvents['mid_sprint'] ?? [] as $sprintMidSprintEvent) {
        if (($sprintMidSprintEvent->allows_weekends && $iterationDate->isSameDay($sprintMidDate)) || (!$sprintMidSprintEvent->allows_weekends && $iterationDate->isSameDay($sprintMidWeekdate))) {
          $this->generateOccurrence($iterationDate, $sprintMidSprintEvent);
        }
      }

      foreach($recurringEvents['sprint_end'] ?? [] as $sprintEndEvent) {
        if (($sprintEndEvent->allows_weekends && $iterationDate->isSameDay($sprintEndDate)) || (!$sprintEndEvent->allows_weekends && $iterationDate->isSameDay($sprintEndWeekday))) {
          $this->generateOccurrence($iterationDate, $sprintEndEvent);
        }
      }

      foreach($recurringEvents['sprint_daily'] ?? [] as $sprintDailyEvent) {
        if ($iterationDate->isWeekend() && !$sprintDailyEvent->allows_weekends) {
          continue;
        }

        $this->generateOccurrence($iterationDate, $sprintDailyEvent);
      }

      foreach($recurringEvents['sprint_weekly'] ?? [] as $weeklyEvent) {
        $recurrenceData = $weeklyEvent->recurrence_days[strtolower($iterationDate->format('l'))] ?? null;

        if ($recurrenceData && $recurrenceData['enabled']) {
          $this->generateOccurrence($iterationDate, $weeklyEvent, $recurrenceData['recurrence_start_time'], $recurrenceData['recurrence_end_time']);
        }
      }

      $iterationDate->addDays(1);
    }
  }

  private function generateOccurrence(Carbon $date, Event $event, $recurrenceStart = null, $recurrenceEnd = null): void {
    $startTime = Carbon::parse($recurrenceStart ?? $event->recurrence_start_time);
    $endTime = Carbon::parse($recurrenceEnd ?? $event->recurrence_end_time);

    $startDate = $date->copy()->hour($startTime->format('H'))
    ->minute($startTime->format('i'))
    ->second(0);

    $endDate = $date->copy()->hour($endTime->format('H'))
    ->minute($endTime->format('i'))
    ->second(0);

    $event->occurrences()->create([
      'sprint_id' => $this->id,
      'start_datetime' => $startDate,
      'end_datetime' => $endDate
    ]);
  }

  public function scopeAfter(Builder $query, Carbon $dateTime) {
    return $query->whereRaw('start_date >= ?', [$dateTime])->inAscendingOrder();
  }

  public function scopeBefore(Builder $query, Carbon $dateTime) {
    return $query->whereRaw('end_date < ?', [$dateTime])->inDescendingOrder();
  }

  public function scopeInAscendingOrder(Builder $query) {
    return $query->orderBy('start_date', 'ASC');
  }

  public function scopeInDescendingOrder(Builder $query) {
    return $query->orderBy('end_date', 'DESC');
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
