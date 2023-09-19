<?php

namespace App\Http\Requests\Events;

use App\Rules\CarbonChecks;
use Illuminate\Support\Str;
use App\Traits\SessionFlash;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class UpdateEventRequest extends FormRequest {
  use SessionFlash;

  protected function prepareForValidation() {
    $recurrenceDaysEnabled = $this->recurrence === 'sprint_weekly' ? collect($this->recurrence_days ?? [])->filter(function ($recurrenceDay) {
      return $recurrenceDay['enabled'] ?? false;
    })->toArray() : null;

    $this->merge([
      'affects_productivity' => isset($this->affects_productivity) ? (int)$this->affects_productivity : 0,
      'recurrence_days_enabled' => $recurrenceDaysEnabled,
      'slug' => Str::slug($this->title)
    ]);

    $recurrenceDays = [];
    foreach (config('constants.days') as $day) {
      $recurrenceDay = $this->recurrence_days[$day] ?? [
        'enabled' => '0',
        'recurrence_end_time' => '',
        'recurrence_start_time' => ''
      ];

      $recurrenceDay['enabled'] = isset($recurrenceDay['enabled']) ? $recurrenceDay['enabled'] : '0';

      $recurrenceDays[$day] = $recurrenceDay;
    }

    $this->merge(['recurrence_days' => $recurrenceDays]);
  }

  public function rules(): array {
    $rules = [
      'affects_productivity' => ['required'],
      'allows_weekends' => ['required'],
      'description' => ['nullable'],
      'event_type_id' => ['required', 'exists:event_types,id'],
      'recurrence' => ['required'],
      'recurrence_end_time' => ['nullable', 'required_unless:recurrence,no_recurrence,sprint_weekly', new CarbonChecks($this->recurrence_end_time, $this->recurrence_start_time, 'after', 'Recurrence End', 'Recurrence Start')],
      'recurrence_start_time' => ['nullable', 'required_unless:recurrence,no_recurrence,sprint_weekly', new CarbonChecks($this->recurrence_start_time, $this->recurrence_end_time, 'before', 'Recurrence Start', 'Recurrence End')],
      'recurrence_days' => ['required_if:recurrence,sprint_weekly', 'array'],
      'recurrence_days_enabled' => $this->recurrence === 'sprint_weekly' ? ['array', 'min:1'] : ['nullable'],
      'slug' => ['required', Rule::unique('events', 'slug')->ignore($this->event->id)],
      'title' => ['required'],
    ];

    foreach ($this->recurrence_days as $index => $recurrenceDay) {
      $key = "recurrence_days.{$index}";

      $rules["{$key}.enabled"] = ['nullable'];
      $rules["{$key}.recurrence_end_time"] = ['nullable', "required_if:{$key}.enabled,1", new CarbonChecks($recurrenceDay['recurrence_end_time'], $recurrenceDay['recurrence_start_time'], 'after', 'Recurrence End', 'Recurrence Start')];
      $rules["{$key}.recurrence_start_time"] = ['nullable', "required_if:{$key}.enabled,1", new CarbonChecks($recurrenceDay['recurrence_start_time'], $recurrenceDay['recurrence_end_time'], 'before', 'Recurrence Start', 'Recurrence End')];
    }

    return $rules;
  }

  public function messages(): array {
    return [
      'recurrence_days_enabled.min' => 'At least one Day must be Enabled.',
      'recurrence_days.*.recurrence_end_time.required_if' => 'The Recurrence End field is required.',
      'recurrence_days.*.recurrence_start_time.required_if' => 'The Recurrence Start field is required.',
      'recurrence_end_time.required_unless' => 'The :attribute field is required.',
      'recurrence_start_time.required_unless' => 'The :attribute field is required.',
      'slug.unique' => 'The Title has already been taken.'
    ];
  }

  public function attributes(): array {
    return [
      'affects_productivity' => 'Affects Productivity',
      'allows_weekends' => 'Allow Weekends',
      'description' => 'Description',
      'event_type_id' => 'Event Type',
      'recurrence_days' => 'Recurrence Days',
      'recurrence_end_time' => 'Recurrence End',
      'recurrence_start_time' => 'Recurrence Start',
      'recurrence' => 'Recurrence',
      'slug' => 'Slug',
      'title' => 'title',
    ];
  }

  protected function failedValidation(Validator $validator): void {
    $this->sessionDanger('<strong>Unable to Update Event</strong><br/><br/>Please check the errors below.');

    throw (new ValidationException($validator))
    ->errorBag($this->errorBag)
    ->redirectTo($this->getRedirectUrl());
  }
}
