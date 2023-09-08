<?php

namespace App\Http\Requests\Statuses;

use Illuminate\Support\Str;
use App\Traits\SessionFlash;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class StoreStatusRequest extends FormRequest {
  use SessionFlash;

  protected function prepareForValidation() {
    $this->merge(['slug' => Str::slug($this->title)]);

    $statusOptions = [];
    foreach ($this->status_options as $index => $statusOption) {
      $statusOption['slug'] = Str::slug("{$statusOption['label']}-{$this->title}");
      $statusOption['sort_order'] = $index + 1;

      $statusOptions[] = $statusOption;
    }

    $this->merge(['status_options' => $statusOptions]);
  }

  public function rules(): array {
    $rules = [
      'title' => ['required'],
      'slug' => ['required', 'unique:statuses,slug'],
      'description' => ['nullable'],
      'status_options' => ['array', 'min:1'],
      'status_options.*.label' => ['required', 'distinct'],
      'status_options.*.slug' => ['required', 'unique:status_options,slug'],
      'status_options.*.description' => ['nullable', 'string', 'in:on'],
      'status_options.*.initial_status_option' => ['required'],
      'status_options.*.text_color' => ['required'],
      'status_options.*.background_color' => ['required'],
      'status_options.*.sort_order' => ['nullable']
    ];

    foreach($this->status_options as $index => $_statusOption) {
      $rules["status_options.{$index}.previous_status"] = ['nullable', 'numeric', "different:status_options.{$index}.next_status"];
      $rules["status_options.{$index}.next_status"] = ['nullable', 'numeric', "different:status_options.{$index}.previous_status"];
    }

    return $rules;
  }

  public function messages(): array {
    $messages = [
      'slug.unique' => 'The Title has already been taken.',
      'status_options.*.slug.unique' => 'The Label has already been taken.'
    ];

    foreach($this->status_options as $index => $_statusOption) {
      $messages["status_options.{$index}.previous_status.different"] = 'The Previous field and Next field must be different.';
      $messages["status_options.{$index}.next_status.different"] = 'The Next field and Previous field must be different.';
    }

    return $messages;
  }

  public function attributes(): array {
    return [
      'title' => 'Title',
      'slug' => 'Slug',
      'status_options.*.label' => 'Label',
      'status_options.*.value' => 'Value',
      'status_options.*.slug' => 'Title',
      'status_options.*.previous_status' => 'Previous',
      'status_options.*.next_status' => 'Next'
    ];
  }

  protected function failedValidation(Validator $validator): void {
    $this->sessionDanger('<strong>Unable to Create Status</strong><br/><br/>Please check the errors below.');

    throw (new ValidationException($validator))
    ->errorBag($this->errorBag)
    ->redirectTo($this->getRedirectUrl());
  }
}
