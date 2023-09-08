<?php

namespace App\Http\Requests\Tasks;

use App\Rules\CarbonTimes;
use App\Traits\SessionFlash;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class StoreTaskRequest extends FormRequest {
  use SessionFlash;

  public function rules(): array {
    return [
      'description' => ['nullable'],
      'end_datetime' => ['required', new CarbonTimes($this->end_datetime, $this->start_datetime, 'after', 'End', 'Start', true)],
      'issue_id' => ['required', 'exists:issues,id'],
      'logged' => ['required'],
      'start_datetime' => ['required', new CarbonTimes($this->start_datetime, $this->end_datetime, 'before', 'Start', 'End', true)]
    ];
  }

  public function attributes(): array {
    return [
      'description' => 'Description',
      'end_datetime' => 'End',
      'issue_id' => 'Issue',
      'logged' => 'Logged',
      'start_datetime' => 'Start'
    ];
  }

  protected function failedValidation(Validator $validator): void {
    $this->sessionDanger('<strong>Unable to Create Task</strong><br/><br/>Please check the errors below.');

    throw (new ValidationException($validator))
    ->errorBag($this->errorBag)
    ->redirectTo($this->getRedirectUrl());
  }
}
