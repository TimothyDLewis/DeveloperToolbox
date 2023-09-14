<?php

namespace App\Helpers;

use stdClass;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;

class FormHelper {
  protected Model|stdClass $model;

  public function setModel(Model|stdClass $model) {
    $this->model = $model;
  }

  private function getField(string $fieldKey) {
    if (!isset($this->model->formFields) || !is_array($this->model->formFields) || empty($this->model->formFields)) {
      throw new Exception('Undefined or misconfigured property `formFields` on ' . get_class($this->model) . '. Must be a non-empty array.');
    }

    return $this->model->formFields[$fieldKey];
  }

  public function renderRepeatableFormHeader(string $fieldKey, string $class = '', int $colspan = 1) {
    $field = $this->getField($fieldKey);

    return "<th colspan=\"{$colspan}\" class=\"{$class}\">{$field['label']}</th>";
  }

  public function renderRepeatableFormField(string $fieldKey, string $prefix, int|string $index, array $overrides = []): View {
    $field = $this->getField($fieldKey);

    return $this->renderFormField($fieldKey, [
      'containerClass' => $overrides['containerClass'] ?? $field['container-class'] ?? 'col-12',
      'default' => $overrides['default'] ?? '',
      'derivativeKey' => $overrides['derivativeKey'] ?? ($field['derivative'] ?? null ? "{$prefix}.{$index}." . ($field['derivative'] ?? '') : ''),
      'errorKey' => $overrides['errorKey'] ?? "{$prefix}.{$index}.{$fieldKey}",
      'id' => $overrides['id'] ?? "{$fieldKey}_{$index}",
      'inputClass' => $overrides['inputClass'] ?? '',
      'name' => $overrides['name'] ?? "{$prefix}[{$index}][$fieldKey]",
      'options' => $overrides['options'] ?? [],
      'placeholder' => $overrides['placeholder'] ?? '',
      'readonly' => $overrides['readonly'] ?? false,
      'repeatable' => true,
      'type' => $overrides['type'] ?? $field['type'],
      'step' => $overrides['step'] ?? $field['step'] ?? 60,
    ]);
  }

  public function renderFormField(string $fieldKey, array $overrides = []): View {
    $field = $this->getField($fieldKey);

    $viewData = [
      'containerClass' => $overrides['containerClass'] ?? $field['container-class'] ?? 'col-12',
      'default' => $overrides['default'] ?? $field['default'] ?? '',
      'derivativeKey' => $overrides['derivativeKey'] ?? $field['derivative'] ?? '',
      'errorKey' => $overrides['errorKey'] ?? $fieldKey,
      'field' => $field,
      'fieldKey' => $fieldKey,
      'id' => $overrides['id'] ?? $fieldKey,
      'inputClass' => $overrides['inputClass'] ?? '',
      'model' => $this->model,
      'name' => $overrides['name'] ?? $fieldKey,
      'options' => $overrides['options'] ?? [],
      'placeholder' => $overrides['placeholder'] ?? '',
      'readonly' => $overrides['readonly'] ?? false,
      'repeatable' => $overrides['repeatable'] ?? false,
      'type' => $overrides['type'] ?? $field['type'],
      'step' => $overrides['step'] ?? $field['step'] ?? 60,
    ];

    switch ($viewData['type']) {
      case 'association':
        return view('components.forms.association', $viewData);
      case 'custom':
        return view("components.forms.custom.{$field['custom_editor']}", $viewData);
      case 'date':
        return view('components.forms.inputs.date', $viewData);
      case 'datetime':
        return view('components.forms.inputs.datetime', $viewData);
      case 'enum-select':
        return view('components.forms.selects.enum-select', $viewData);
      case 'hidden':
        return view('components.forms.hidden', $viewData);
      case 'select':
        return view('components.forms.selects.select', $viewData);
      case 'time':
        return view('components.forms.inputs.time', $viewData);
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
