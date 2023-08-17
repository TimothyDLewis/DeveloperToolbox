<?php

namespace App\Http\Requests\Projects;

use Illuminate\Support\Str;
use App\Traits\SessionFlash;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class UpdateProjectRequest extends FormRequest {
  use SessionFlash;

  protected function prepareForValidation() {
    $this->merge(['slug' => Str::slug($this->title)]);
  }

  public function rules(): array {
    return [
      'code' => ['required', Rule::unique('projects', 'code')->ignore($this->project->id)],
      'description' => ['nullable'],
      'slug' => ['required', Rule::unique('projects', 'slug')->ignore($this->project->id)],
      'source_code_management_url' => ['nullable', 'url'],
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
      'slug' => 'Slug',
      'source_code_management_url' => 'Source Code Management (SCM) URL',
      'title' => 'Title'
    ];
  }

  protected function failedValidation(Validator $validator): void {
    $this->sessionDanger('<strong>Unable to Create Project</strong><br/><br/>Please check the errors below.');

    throw (new ValidationException($validator))
    ->errorBag($this->errorBag)
    ->redirectTo($this->getRedirectUrl());
  }
}
