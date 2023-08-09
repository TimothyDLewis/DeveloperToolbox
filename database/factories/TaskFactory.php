<?php

namespace Database\Factories;

use Carbon\Carbon;
use App\Models\Issue;
use App\Classes\DateRange;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
* @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
*/
class TaskFactory extends Factory {
  protected ?Carbon $startDateTime = null;
  protected ?Carbon $endDateTime = null;

  /**
  * Define the model's default state.
  *
  * @return array<string, mixed>
  */
  public function definition(): array {
    $dateRange = $this->dateRange();

    return [
      'issue_id' => Issue::factory(),
      'start_datetime' => $dateRange->startDateTime,
      'end_datetime' => $dateRange->endDateTime,
      'logged' => false,
      'logged_duration' => 0,
      'description' => fake()->text(),
    ];
  }

  private function dateRange(): DateRange {
    if (is_null($this->startDateTime) || is_null($this->endDateTime)) {
      $this->startDateTime = Carbon::now()->hour(9)->minute(0)->second(0);
      $this->endDateTime = Carbon::now()->hour(9)->minute(30)->second(0);
    }

    $dateRange = new DateRange($this->startDateTime, $this->endDateTime);

    $this->startDateTime = $this->startDateTime->copy()->addHours(1);
    $this->endDateTime = $this->endDateTime->copy()->addHours(1);

    return $dateRange;
  }
}
