<?php

namespace Database\Factories;

use Carbon\Carbon;
use App\Classes\DateRange;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
* @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sprint>
*/
class SprintFactory extends Factory {
  protected ?Carbon $startDate = null;
  protected ?Carbon $endDate = null;

  /**
  * Define the model's default state.
  *
  * @return array<string, mixed>
  */
  public function definition(): array {
    $dateRange = $this->dateRange();

    return [
      'title' => $title = Str::upper(fake()->uuid()),
      'slug' => Str::slug($title),
      'start_date' => $dateRange->startDateTime,
      'end_date' => $dateRange->endDateTime,
      'description' => fake()->text()
    ];
  }

  private function dateRange(): DateRange {
    if (is_null($this->startDate) || is_null($this->endDate)) {
      $this->startDate = Carbon::now()->startOfWeek();
      $this->endDate = Carbon::now()->endOfWeek();
    }

    $dateRange = new DateRange($this->startDate, $this->endDate);

    $this->startDate = $this->startDate->copy()->addWeeks(1);
    $this->endDate = $this->endDate->copy()->addWeeks(1);

    return $dateRange;
  }
}
