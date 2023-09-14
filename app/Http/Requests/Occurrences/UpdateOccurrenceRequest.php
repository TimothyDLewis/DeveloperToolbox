<?php

namespace App\Http\Requests\Occurrences;

use App\Rules\CarbonChecks;
use App\Traits\SessionFlash;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class UpdateOccurrenceRequest extends FormRequest {
  use SessionFlash;

  protected function prepareForValidation() {
    if ($this->all_day) {
      $this->merge(['end_datetime' => $this->start_datetime]);
    }
  }

  public function rules(): array {
    $startTimeRules = ['required'];
    $endTimeRules = ['required'];

    if (!$this->all_day) {
      $startTimeRules[] = new CarbonChecks($this->start_datetime, $this->end_datetime, 'before', 'Start', 'End', true);
      $endTimeRules[] = new CarbonChecks($this->end_datetime, $this->start_datetime, 'after', 'End', 'Start', true);
    }

    return [
      'all_day' => ['required'],
      'event_id' => ['required', 'exists:events,id'],
      'start_datetime' => $startTimeRules,
      'end_datetime' => $endTimeRules
    ];
  }

  public function attributes(): array {
    return [
      'all_day' => 'All Day',
      'event_id' => 'Event',
      'start_datetime' => 'Start',
      'end_datetime' => 'End'
    ];
  }

  protected function failedValidation(Validator $validator): void {
    $this->sessionDanger('<strong>Unable to Update Occurrence</strong><br/><br/>Please check the errors below.');

    $this->merge(['all_day' => isset($this->all_day) ? (int)$this->all_day : 0]);

    throw (new ValidationException($validator))
    ->errorBag($this->errorBag)
    ->redirectTo($this->getRedirectUrl());
  }
}
