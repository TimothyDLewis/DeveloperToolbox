<?php

namespace Database\Factories;

use TypeError;
use Carbon\Carbon;
use App\Models\Event;
use App\Models\EventType;
use App\Classes\DateRange;
use Illuminate\Support\Str;
use App\Enums\EventRecurrence;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
* @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
*/
class EventFactory extends Factory {
  protected ?Carbon $startTime = null;
  protected ?Carbon $endTime = null;

  /**
  * Define the model's default state.
  *
  * @return array<string, mixed>
  */
  public function definition(): array {
    return [
      'event_type_id' => EventType::factory(),
      'title' => $title = Str::upper(fake()->uuid()),
      'slug' => Str::slug($title),
      'recurrence' => 'no_recurrence',
      'description' => fake()->text()
    ];
  }

  public function recurs(EventRecurrence $recurrence): Factory {
    if ($recurrence === EventRecurrence::NoRecurrence) {
      return $this;
    }

    return $this->state(function (array $_attributes) use ($recurrence) {
      $dateRange = $this->dateRange();

      return [
        'recurrence' => $recurrence,
        'recurrence_start_time' => $dateRange->startDateTime,
        'recurrence_end_time' => $dateRange->endDateTime,
        'recurrence_days' => $recurrence === EventRecurrence::SprintWeekly ? "['Monday', 'Wednesday', 'Friday']" : null
      ];
    });
  }

  private function dateRange(): DateRange {
    if (is_null($this->startTime) || is_null($this->endTime)) {
      $this->startTime = Carbon::now()->hour(9)->minute(0)->second(0);
      $this->endTime = Carbon::now()->hour(11)->minute(0)->second(0);
    }

    $dateRange = new DateRange($this->startTime, $this->endTime);

    $this->startTime = $this->startTime->copy()->addHours(3);
    $this->endTime = $this->endTime->copy()->addHours(3);

    return $dateRange;
  }
}
