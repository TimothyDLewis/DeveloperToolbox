<?php

namespace App\Helpers;

class ThemeHelper {
  public function themeClass(string $dark, string $light) {
    return ${config('app.color_theme')};
  }
}
