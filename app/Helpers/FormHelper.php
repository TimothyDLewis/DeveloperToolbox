<?php

namespace App\Helpers;

use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;

class FormHelper {
  protected Model $model;

  public function setModel(Model $model) {
    $this->model = $model;
  }

  public function renderRepeatableFormField(string $fieldKey, string $prefix, int $index, array $overrides = []): View {
    $field = $this->model->formFields[$fieldKey];

    return $this->renderFormField($fieldKey, [
      'errorKey' => $overrides['errorKey'] ?? "{$prefix}.{$index}.{$fieldKey}",
      'derivativeKey' => $overrides['derivativeKey'] ?? $field['derivative'] ?? null ? "{$prefix}.{$index}.{$field['derivative']}" : $fieldKey,
      'id' => $overrides['id'] ?? "{$fieldKey}_{$index}",
      'name' => $overrides['name'] ?? "{$prefix}[{$index}][$fieldKey]",
      'repeatable' => true
    ]);
  }

  public function renderFormField(string $fieldKey, array $overrides = []): View {
    if (!isset($this->model->formFields) || !is_array($this->model->formFields) || empty($this->model->formFields)) {
      throw new Exception('Undefined or misconfigured property `formFields` on ' . get_class($this->model) . '. Must be a non-empty array.');
    }

    $field = $this->model->formFields[$fieldKey];

    $viewData = [
      'errorKey' => $overrides['errorKey'] ?? $fieldKey,
      'derivativeKey' => $overrides['derivativeKey'] ?? $field['derivative'] ?? $fieldKey,
      'field' => $field,
      'fieldKey' => $fieldKey,
      'id' => $overrides['id'] ?? $fieldKey,
      'model' => $this->model,
      'name' => $overrides['name'] ?? $fieldKey,
      'repeatable' => $overrides['repeatable'] ?? false
    ];

    switch ($field['type']) {
      case 'hidden':
        return view('components.forms.hidden', $viewData);
      case 'text':
        return view('components.forms.inputs.text', $viewData);
      case 'textarea':
        return view('components.forms.textarea', $viewData);
    }
  }

  public function renderSubmitButton(string $label = 'Submit'): View {
    return view('components.forms.submit', ['label' => $label]);
  }

  public function renderCancelButton(string $redirectUrl, string $label = 'Cancel'): View {
    return view('components.forms.cancel', [
      'redirectUrl' => $redirectUrl,
      'label' => $label
    ]);
  }
}
