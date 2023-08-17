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

  private function getField(string $fieldKey) {
    if (!isset($this->model->formFields) || !is_array($this->model->formFields) || empty($this->model->formFields)) {
      throw new Exception('Undefined or misconfigured property `formFields` on ' . get_class($this->model) . '. Must be a non-empty array.');
    }

    return $this->model->formFields[$fieldKey];
  }

  public function renderRepeatableFormHeader(string $fieldKey, string $class = '') {
    $field = $this->getField($fieldKey);

    return "<th class=\"{$class}\">{$field['label']}</th>";
  }

  public function renderRepeatableFormField(string $fieldKey, string $prefix, int $index, array $overrides = []): View {
    $field = $this->getField($fieldKey);

    return $this->renderFormField($fieldKey, [
      'containerClass' => $overrides['containerClass'] ?? $field['container-class'] ?? 'col-12',
      'default' => $overrides['default'] ?? '',
      'derivativeKey' => $overrides['derivativeKey'] ?? $field['derivative'] ?? null ? "{$prefix}.{$index}.{$field['derivative']}" : $fieldKey,
      'errorKey' => $overrides['errorKey'] ?? "{$prefix}.{$index}.{$fieldKey}",
      'id' => $overrides['id'] ?? "{$fieldKey}_{$index}",
      'name' => $overrides['name'] ?? "{$prefix}[{$index}][$fieldKey]",
      'options' => $overrides['options'] ?? [],
      'placeholder' => $overrides['placeholder'] ?? '',
      'repeatable' => true
    ]);
  }

  public function renderFormField(string $fieldKey, array $overrides = []): View {
    $field = $this->getField($fieldKey);

    $viewData = [
      'containerClass' => $overrides['containerClass'] ?? $field['container-class'] ?? 'col-12',
      'default' => $overrides['default'] ?? $field['default'] ?? '',
      'derivativeKey' => $overrides['derivativeKey'] ?? $field['derivative'] ?? $fieldKey,
      'errorKey' => $overrides['errorKey'] ?? $fieldKey,
      'field' => $field,
      'fieldKey' => $fieldKey,
      'id' => $overrides['id'] ?? $fieldKey,
      'model' => $this->model,
      'name' => $overrides['name'] ?? $fieldKey,
      'options' => $overrides['options'] ?? [],
      'placeholder' => $overrides['placeholder'] ?? '',
      'repeatable' => $overrides['repeatable'] ?? false
    ];

    switch ($field['type']) {
      case 'custom':
        return view("components.forms.custom.{$field['custom_editor']}", $viewData);
      case 'hidden':
        return view('components.forms.hidden', $viewData);
      case 'select':
        return view('components.forms.select', $viewData);
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
