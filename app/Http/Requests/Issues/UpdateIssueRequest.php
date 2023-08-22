<?php

namespace App\Http\Requests\Issues;

use Illuminate\Support\Str;
use App\Traits\SessionFlash;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UpdateIssueRequest extends FormRequest {
  use SessionFlash;

  protected function prepareForValidation() {
    $this->merge(['slug' => Str::slug($this->title)]);
  }

  public function rules(): array {
    return [
      'code' => ['required', Rule::unique('issues', 'code')->ignore($this->issue->id)],
      'description' => ['nullable'],
      'estimate_option_id' => ['required', 'exists:estimate_options,id'],
      'external_url' => ['nullable', 'url'],
      'slug' => ['required', Rule::unique('issues', 'slug')->ignore($this->issue->id)],
      'status_option_id' => ['required', 'exists:status_options,id'],
      'title' => ['required']
    ];
  }

  public function messages(): array {
    return [
      'slug.unique' => 'The Title has already been taken.'
    ];
  }

  public function attributes(): array {
    return [
      'code' => 'Code',
      'estimate_option_id' => 'Estimate Option',
      'external_url' => 'External URL',
      'slug' => 'Slug',
      'status_option_id' => 'Status Option',
      'title' => 'Title'
    ];
  }

  protected function failedValidation(Validator $validator): void {
    $this->sessionDanger('<strong>Unable to Update Issue</strong><br/><br/>Please check the errors below.');

    throw (new ValidationException($validator))
    ->errorBag($this->errorBag)
    ->redirectTo($this->getRedirectUrl());
  }
}
