<?php

namespace App\Http\Requests\Occurences;

use App\Rules\CarbonTimes;
use App\Traits\SessionFlash;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class StoreOccurenceRequest extends FormRequest {
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
      $startTimeRules[] = new CarbonTimes($this->start_datetime, $this->end_datetime, 'before', 'Start', 'End', true);
      $endTimeRules[] = new CarbonTimes($this->end_datetime, $this->start_datetime, 'after', 'End', 'Start', true);
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
    $this->sessionDanger('<strong>Unable to Create Occurence</strong><br/><br/>Please check the errors below.');

    throw (new ValidationException($validator))
    ->errorBag($this->errorBag)
    ->redirectTo($this->getRedirectUrl());
  }
}
