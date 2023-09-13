<?php

namespace App\Rules;

use Closure;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\ValidationRule;

class CarbonChecks implements ValidationRule {
  private ?Carbon $firstTime;
  private ?Carbon $secondTime;
  private string $firstTimeAttribute;
  private string $secondTimeAttribute;
  private string $validationMethod;

  public function __construct(?string $firstTime, ?string $secondTime, string $validationMethod, string $firstTimeAttribute, string $secondTimeAttribute, bool $qualifiedDates = false) {
    $this->firstTime = $firstTime ? Carbon::parse($qualifiedDates ? $firstTime : "2000-01-01 {$firstTime}") : $firstTime;
    $this->firstTimeAttribute = $firstTimeAttribute;
    $this->secondTime = $secondTime ? Carbon::parse($qualifiedDates ? $secondTime : "2000-01-01 {$secondTime}") : $secondTime;
    $this->secondTimeAttribute = $secondTimeAttribute;
    $this->validationMethod = $validationMethod;
  }

  public function validate(string $_attribute, mixed $_value, Closure $fail): void {
    if ($this->firstTime && (int)$this->firstTime->format('i') % 5 != 0) {
      $fail("The {$this->firstTimeAttribute} field must be an increment of 5 minutes.");
    }

    if ($this->firstTime && $this->secondTime) {
      if ($this->validationMethod === 'before' && !$this->firstTime->isBefore($this->secondTime)) {
        $fail("The {$this->firstTimeAttribute} field must be before the {$this->secondTimeAttribute} field.");
      }

      if ($this->validationMethod === 'after' && !$this->firstTime->isAfter($this->secondTime)) {
        $fail("The {$this->firstTimeAttribute} field must be after the {$this->secondTimeAttribute} field.");
      }
    }
  }
}
