<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
* @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Status>
*/
class StatusFactory extends Factory {
  /**
  * Define the model's default state.
  *
  * @return array<string, mixed>
  */
  public function definition(): array {
    return [
      'title' => $title = Str::upper(fake()->uuid()),
      'slug' => Str::slug($title),
      'description' => fake()->text(),
    ];
  }
}
