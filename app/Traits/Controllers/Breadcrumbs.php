<?php

namespace App\Traits\Controllers;

use Exception;
use Illuminate\Support\Facades\Log;

trait Breadcrumbs {
  protected $breadCrumbs;

  public function withBreadcrumbs(?string $path = null, array $additional = [], array $includes = []): array {
    try {
      return array_merge($includes, ['breadcrumbs' => $this->constructBreadcrumbs($path, $additional)]);
    } catch (Exception $ex) {
      Log::error($ex);

      return $includes;
    }
  }
}
