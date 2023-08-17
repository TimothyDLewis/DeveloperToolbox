<?php

namespace App\Http\Requests\Projects;

use Illuminate\Support\Str;
use App\Traits\SessionFlash;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class StoreProjectRequest extends FormRequest {
  use SessionFlash;

  protected function prepareForValidation() {
    $this->merge(['slug' => Str::slug($this->title)]);
  }

  public function rules(): array {
    return [
      'code' => ['required', 'unique:projects,code'],
      'description' => ['nullable'],
      'estimate_id' => ['required', 'exists:estimates,id'],
      'slug' => ['required', 'unique:projects,slug'],
      'source_code_management_url' => ['nullable', 'url'],
      'status_id' => ['required', 'exists:statuses,id'],
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
      'estimate_id' => 'Estimate',
      'slug' => 'Slug',
      'source_code_management_url' => 'Source Code Management (SCM) URL',
      'status_id' => 'Status',
      'title' => 'Title'
    ];
  }

  protected function failedValidation(Validator $validator): void {
    $this->sessionDanger('<strong>Unable to Update Project</strong><br/><br/>Please check the errors below.');

    throw (new ValidationException($validator))
    ->errorBag($this->errorBag)
    ->redirectTo($this->getRedirectUrl());
  }
}
