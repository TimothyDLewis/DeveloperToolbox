<?php

namespace App\Helpers;

class ThemeHelper {
  public function themeVar(string $dark, string $light) {
    return ${config('app.color_theme')};
  }

  public function swatches() {
    return [
      'primary' => '#0d6efd',
      'success' => '#198754',
      'danger' => '#dc3545',
      'warning' => '#ffc107',
      'info' => '#0dcaf0',
      'light' => '#f8f9fa',
      'dark' => '#212529'
    ];
  }
}
