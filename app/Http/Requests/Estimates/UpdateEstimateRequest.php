<?php

namespace App\Http\Requests\Estimates;

use Illuminate\Support\Str;
use App\Traits\SessionFlash;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class UpdateEstimateRequest extends FormRequest {
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
    $rules = [
      'title' => ['required'],
      'slug' => ['required', Rule::unique('estimates', 'slug')->ignore($this->estimate->id)],
      'description' => ['nullable'],
      'estimate_options' => ['array', 'min:1'],
      'estimate_options.*.id' => ['nullable'],
      'estimate_options.*.label' => ['required', 'distinct'],
      'estimate_options.*.value' => ['required', 'numeric'],
      'estimate_options.*.sort_order' => ['nullable']
    ];

    foreach ($this->estimate_options as $index => $estimateOption) {
      if ($estimateOption['id'] ?? null) {
        $rules["estimate_options.{$index}.slug"] = ['required', Rule::unique('estimate_options', 'slug')->ignore($estimateOption['id'], 'id')];
      } else {
        $rules["estimate_options.{$index}.slug"] = ['required', 'unique:estimate_options,slug'];
      }
    }

    return $rules;
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

  protected function failedValidation(Validator $validator) {
    $this->sessionDanger('<strong>Unable to Update Estimate</strong><br/><br/>Please check the errors below.');

    throw (new ValidationException($validator))
    ->errorBag($this->errorBag)
    ->redirectTo($this->getRedirectUrl());
  }
}
