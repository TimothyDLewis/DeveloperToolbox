<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
* @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EventType>
*/
class EventTypeFactory extends Factory {
  /**
  * Define the model's default state.
  *
  * @return array<string, mixed>
  */
  public function definition(): array {
    return [
      'title' => $title = Str::upper(fake()->uuid()),
      'slug' => Str::slug($title),
      'text_color' => fake()->hexColor(),
      'background_color' => fake()->hexColor(),
      'affects_productivity' => false,
      'description' => fake()->text()
    ];
  }
}
