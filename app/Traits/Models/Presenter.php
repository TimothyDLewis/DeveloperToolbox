<?php

namespace App\Traits\Models;

use Exception;
use RuntimeException;
use App\Exceptions\Handler;
use Illuminate\Support\Collection;

trait Presenter {
  private function callPresenter(string $callback, ...$args): Collection {
    try {
      $method = "present" . ucfirst($callback);

      return collect($this->{$method}($this, ...$args));
    } catch (Exception $ex) {
      if ($ex instanceOf RuntimeException) {
        throw $ex;
      }

      (new Handler(app()))->report($ex);

      return collect($this->toArray());
    }
  }

  public function present(string $callback, ...$args): Collection {
    return $this->callPresenter($callback, ...$args);
  }
}
