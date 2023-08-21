<?php

namespace App\Http\Requests\Resources;

use Illuminate\Support\Str;
use App\Traits\SessionFlash;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class UpdateResourceRequest extends FormRequest {
  use SessionFlash;

  protected function prepareForValidation() {
    $this->merge(['slug' => Str::slug($this->input('project_id') . '-' . $this->title)]);
  }

  public function rules(): array {
    return [
      'background_color' => ['required'],
      'description' => ['nullable'],
      'label' => ['required'],
      'project_id' => ['nullable', 'exists:projects,id'],
      'slug' => ['required', Rule::unique('resources', 'slug')->ignore($this->resource->id)],
      'text_color' => ['required'],
      'title' => ['required'],
      'url' => ['required', 'url']
    ];
  }

  public function messages(): array {
    return [
      'slug.unique' => 'The Title has already been taken.'
    ];
  }

  public function attributes(): array {
    return [
      'background_color' => 'Background Color',
      'label' => 'Label',
      'project_id' => 'Project',
      'slug' => 'Slug',
      'text_color' => 'Text Color',
      'title' => 'Title',
      'url' => 'URL'
    ];
  }

  protected function failedValidation(Validator $validator): void {
    $this->sessionDanger('<strong>Unable to Update Resource</strong><br/><br/>Please check the errors below.');

    throw (new ValidationException($validator))
    ->errorBag($this->errorBag)
    ->redirectTo($this->getRedirectUrl());
  }
}
