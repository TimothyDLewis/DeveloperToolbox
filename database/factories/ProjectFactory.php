<?php

namespace Database\Factories;

use App\Models\Status;
use App\Models\Estimate;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
* @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
*/
class ProjectFactory extends Factory {
  /**
  * Define the model's default state.
  *
  * @return array<string, mixed>
  */
  public function definition(): array {
    return [
      'estimate_id' => Estimate::factory(),
      'status_id' => Status::factory(),
      'title' => $title = Str::upper(fake()->uuid()),
      'slug' => Str::slug($title),
      'code' => explode('-', $title)[0],
      'source_code_management_url' => fake()->url(),
      'description' => fake()->text()
    ];
  }
}
