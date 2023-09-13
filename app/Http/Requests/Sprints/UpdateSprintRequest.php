<?php

namespace App\Http\Requests\Sprints;

use App\Models\Sprint;
use Illuminate\Support\Str;
use App\Rules\CarbonChecks;
use App\Rules\DoesntOverlap;
use App\Traits\SessionFlash;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class UpdateSprintRequest extends FormRequest {
  use SessionFlash;

  protected function prepareForValidation() {
    $this->merge(['slug' => Str::slug($this->title)]);
  }

  public function rules(): array {
    return [
      'description' => ['nullable'],
      'end_date' => ['required', new CarbonChecks($this->end_date, $this->start_date, 'after', 'End', 'Start', true), new DoesntOverlap(Sprint::class, $this->sprint->id)],
      'slug' => ['required', Rule::unique('issues', 'slug')->ignore($this->sprint->id)],
      'start_date' => ['required', new CarbonChecks($this->start_date, $this->end_date, 'before', 'Start', 'End', true), new DoesntOverlap(Sprint::class, $this->sprint->id)],
      'title' => ['required']
    ];
  }

  public function attributes(): array {
    return [
      'description' => 'Description',
      'end_date' => 'End',
      'slug' => 'Slug',
      'start_date' => 'Start',
      'title' => 'Title'
    ];
  }

  protected function failedValidation(Validator $validator): void {
    $this->sessionDanger('<strong>Unable to Update Sprint</strong><br/><br/>Please check the errors below.');

    throw (new ValidationException($validator))
    ->errorBag($this->errorBag)
    ->redirectTo($this->getRedirectUrl());
  }
}
