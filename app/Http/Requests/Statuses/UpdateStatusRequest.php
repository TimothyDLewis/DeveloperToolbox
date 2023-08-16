<?php

namespace App\Http\Requests\Statuses;

use Illuminate\Support\Str;
use App\Traits\SessionFlash;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class UpdateStatusRequest extends FormRequest {
  use SessionFlash;

  protected function prepareForValidation() {
    $this->merge(['slug' => Str::slug($this->title)]);

    $statusOptions = [];
    foreach ($this->status_options as $index => $statusOption) {
      $statusOption['slug'] = Str::slug("{$statusOption['label']}-{$this->title}");
      $statusOption['sort_order'] = $index + 1;
      $statusOption['initial_status_option'] = isset($statusOption['initial_status_option']) ? $statusOption['initial_status_option'] : '0';

      $statusOptions[] = $statusOption;
    }

    $this->merge(['status_options' => $statusOptions]);
  }

  public function rules(): array {
    $rules = [
      'title' => ['required'],
      'slug' => ['required', Rule::unique('statuses', 'slug')->ignore($this->status->id)],
      'description' => ['nullable'],
      'status_options' => ['array', 'min:1'],
      'status_options.*.id' => ['required'],
      'status_options.*.label' => ['required', 'distinct'],
      'status_options.*.slug' => ['required', 'unique:status_options,slug'],
      'status_options.*.description' => ['nullable'],
      'status_options.*.initial_status_option' => ['required'],
      'status_options.*.text_color' => ['required'],
      'status_options.*.background_color' => ['required'],
      'status_options.*.sort_order' => ['nullable']
    ];

    foreach($this->status_options as $index => $statusOption) {
      if ($statusOption['id'] ?? null) {
        $rules["status_options.{$index}.slug"] = ['required', Rule::unique('status_options', 'slug')->ignore($statusOption['id'], 'id')];
      } else {
        $rules["status_options.{$index}.slug"] = ['required', 'unique:status_options,slug'];
      }
    }

    return $rules;
  }

  public function messages(): array {
    return [
      'slug.unique' => 'The Title has already been taken.',
      'status_options.*.slug.unique' => 'The Label has already been taken.'
    ];
  }

  public function attributes(): array {
    return [
      'title' => 'Title',
      'slug' => 'Slug',
      'status_options.*.label' => 'Label',
      'status_options.*.value' => 'Value',
      'status_options.*.slug' => 'Label'
    ];
  }

  protected function failedValidation(Validator $validator): void {
    $this->sessionDanger('<strong>Unable to Update Status</strong><br/><br/>Please check the errors below.');

    throw (new ValidationException($validator))
    ->errorBag($this->errorBag)
    ->redirectTo($this->getRedirectUrl());
  }
}
