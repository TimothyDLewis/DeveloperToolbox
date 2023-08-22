<?php

namespace App\Http\Requests\Issues;

use Illuminate\Support\Str;
use App\Traits\SessionFlash;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class StoreIssueRequest extends FormRequest {
  use SessionFlash;

  protected function prepareForValidation() {
    $this->merge(['slug' => Str::slug($this->title)]);
  }

  public function rules(): array {
    return [
      'code' => ['required', 'unique:projects,code'],
      'description' => ['nullable'],
      'estimate_option_id' => ['required', 'exists:estimate_options,id'],
      'external_url' => ['nullable', 'url'],
      'project_id' => ['required', 'exists:projects,id'],
      'slug' => ['required', 'unique:projects,slug'],
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
      'project_id' => 'Project',
      'slug' => 'Slug',
      'status_option_id' => 'Status Option',
      'title' => 'Title'
    ];
  }

  protected function failedValidation(Validator $validator): void {
    $this->sessionDanger('<strong>Unable to Create Issue</strong><br/><br/>Please check the errors below.');

    throw (new ValidationException($validator))
    ->errorBag($this->errorBag)
    ->redirectTo($this->getRedirectUrl());
  }
}
