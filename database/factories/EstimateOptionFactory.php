<?php

namespace Database\Factories;

use App\Models\Estimate;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
* @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EstimateOption>
*/
class EstimateOptionFactory extends Factory {
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
      'estimate_id' => Estimate::factory(),
      'label' => $label = Str::upper($letter . '-' . fake()->uuid()),
      'slug' => Str::slug($label),
      'value' => $this->fibonacci($sortOrder),
      'sort_order' => $sortOrder
    ];
  }

  private function fibonacci($iteration): int {
    if ($iteration === 1) {
      return 0;
    }

    return (int)round(pow((sqrt(5) + 1) / 2, $iteration) / sqrt(5));
  }

  private function letter(): string {
    return $this->letter++;
  }

  private function sortOrder(): int {
    return $this->sortOrder++;
  }
}
