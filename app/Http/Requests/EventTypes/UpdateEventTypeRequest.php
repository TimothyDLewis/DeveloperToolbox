<?php

namespace App\Http\Requests\EventTypes;

use Illuminate\Support\Str;
use App\Traits\SessionFlash;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class UpdateEventTypeRequest extends FormRequest {
  use SessionFlash;

  protected function prepareForValidation() {
    $this->merge([
      'affects_productivity' => isset($this->affects_productivity) ? $this->affects_productivity : '0',
      'slug' => Str::slug($this->title),
    ]);
  }

  public function rules(): array {
    return [
      'affects_productivity' => ['required'],
      'background_color' => ['required'],
      'description' => ['nullable'],
      'slug' => ['required', Rule::unique('event_types', 'slug')->ignore($this->event_type->id)],
      'text_color' => ['required'],
      'title' => ['required'],
    ];
  }

  public function messages(): array {
    return [
      'slug.unique' => 'The Title has already been taken.'
    ];
  }

  public function attributes(): array {
    return [
      'affects_productivity' => 'Affects Productivity',
      'background_color' => 'Background Color',
      'slug' => 'Slug',
      'text_color' => 'Text Color',
      'title' => 'Title'
    ];
  }

  protected function failedValidation(Validator $validator): void {
    $this->sessionDanger('<strong>Unable to Update Event Type</strong><br/><br/>Please check the errors below.');

    throw (new ValidationException($validator))
    ->errorBag($this->errorBag)
    ->redirectTo($this->getRedirectUrl());
  }
}
