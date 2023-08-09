<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Support\Str;
use App\Models\StatusOption;
use App\Models\EstimateOption;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
* @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Issue>
*/
class IssueFactory extends Factory {
  /**
  * Define the model's default state.
  *
  * @return array<string, mixed>
  */
  public function definition(): array {
    return [
      'project_id' => Project::factory(),
      'estimate_option_id' => EstimateOption::factory(),
      'status_option_id' => StatusOption::factory(),
      'title' => $title = Str::upper(fake()->uuid()),
      'slug' => Str::slug($title),
      'code' => explode('-', $title)[0],
      'url' => fake()->url(),
      'description' => fake()->text()
    ];
  }
}
