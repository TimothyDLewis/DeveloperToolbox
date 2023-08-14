<?php

namespace App\Http\Requests\Estimates;

use Illuminate\Support\Str;
use App\Traits\SessionFlash;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class StoreEstimateRequest extends FormRequest {
  use SessionFlash;

  protected function prepareForValidation() {
    $this->merge(['slug' => Str::slug($this->title)]);

    $estimateOptions = [];
    foreach ($this->estimate_options as $index => $estimateOption) {
      $estimateOption['slug'] = Str::slug("{$estimateOption['label']}-{$this->title}");
      $estimateOption['sort_order'] = $index + 1;

      $estimateOptions[] = $estimateOption;
    }

    $this->merge(['estimate_options' => $estimateOptions]);
  }

  public function rules(): array {
    return [
      'title' => ['required'],
      'slug' => ['required', 'unique:estimates,slug'],
      'description' => ['nullable'],
      'estimate_options' => ['array', 'min:1'],
      'estimate_options.*.label' => ['required', 'distinct'],
      'estimate_options.*.value' => ['required', 'numeric'],
      'estimate_options.*.slug' => ['required', 'unique:estimate_options,slug'],
      'estimate_options.*.sort_order' => ['nullable']
    ];
  }

  public function messages(): array {
    return [
      'slug.unique' => 'The Title has already been taken.',
      'estimate_options.*.slug.unique' => 'The Label has already been taken.'
    ];
  }

  public function attributes(): array {
    return [
      'title' => 'Title',
      'slug' => 'Slug',
      'estimate_options.*.label' => 'Label',
      'estimate_options.*.value' => 'Value',
      'estimate_options.*.slug' => 'Title'
    ];
  }

  protected function failedValidation(Validator $validator): void {
    $this->sessionDanger('<strong>Unable to Create Estimate</strong><br/><br/>Please check the errors below.');

    throw (new ValidationException($validator))
    ->errorBag($this->errorBag)
    ->redirectTo($this->getRedirectUrl());
  }
}
