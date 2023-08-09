<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
* @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Resource>
*/
class ResourceFactory extends Factory {
  /**
  * Define the model's default state.
  *
  * @return array<string, mixed>
  */
  public function definition(): array {
    return [
      'project_id' => Project::factory(),
      'title' => $title = Str::upper(fake()->uuid()),
      'slug' => Str::slug($title),
      'label' => explode('-', $title)[0],
      'text_color' => fake()->hexColor(),
      'background_color' => fake()->hexColor(),
      'url' => fake()->url(),
      'description' => fake()->text()
    ];
  }
}
