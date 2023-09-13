<?php

namespace App\Rules;

use Closure;
use Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Validation\ValidationRule;

class DoesntOverlap implements ValidationRule {
  private ?int $id;
  private string $model;

  public function __construct(string $model, int $id = null) {
    $this->model = $model;
    $this->id = $id;
  }

  public function validate(string $attribute, mixed $value, Closure $fail): void {
    try {
      $attributeDate = Carbon::parse($value);

      $overlap = ($this->model)::overlapsDate($attributeDate)->when($this->id, function (Builder $query) {
        return $query->where('id', '!=', $this->id);
      })->exists();

      if ($overlap) {
        $fail('The :attribute field overlaps an existing record.');
      }
    } catch (Exception $ex) {
      Log::error($ex);
      $fail('The :attribute field is invalid for determing an overlap.');
    }
  }
}
