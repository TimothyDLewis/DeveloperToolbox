<?php

namespace Database\Factories;

use App\Models\Status;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
* @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StatusOption>
*/
class StatusOptionFactory extends Factory {
  private string $letter = 'A';
  private int $sortOrder = 1;

  /**
  * Define the model's default state.
  *
  * @return array<string, mixed>
  */
  public function definition(): array {
    $letter = $this->letter();
    $sortOrder = $this->sortOrder();

    return [
      'status_id' => Status::factory(),
      'previous_status_option_id' => null,
      'next_status_option_id' => null,
      'label' => $label = Str::upper($letter . '-' . fake()->uuid()),
      'slug' => Str::slug($label),
      'text_color' => fake()->hexColor(),
      'background_color' => fake()->hexColor(),
      'sort_order' => $sortOrder
    ];
  }

  private function letter(): string {
    return $this->letter++;
  }

  private function sortOrder(): int {
    return $this->sortOrder++;
  }
}
