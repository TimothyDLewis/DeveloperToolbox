<?php

namespace App\Traits\Controllers;

use Exception;

trait Breadcrumbs {
  protected $breadCrumbs;

  public function withBreadcrumbs(?string $path = null, array $additional = [], array $includes = []): array {
    try {
      return array_merge($includes, ['breadcrumbs' => $this->constructBreadcrumbs($path, $additional)]);
    } catch (Exception $_ex) {
      return $includes;
    }
  }
}
