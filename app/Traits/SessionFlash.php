<?php

namespace App\Traits;

trait SessionFlash {
  protected function sessionInfo(string $message) {
    $this->sessionFlash('info', $message, 'fa-solid fa-circle-info');
  }

  protected function sessionSuccess(string $message) {
    $this->sessionFlash('success', $message, 'fa-solid fa-circle-check');
  }

  protected function sessionWarning(string $message) {
    $this->sessionFlash('warning', $message, 'fa-solid fa-triangle-exclamation');
  }

  protected function sessionDanger(string $message) {
    $this->sessionFlash('danger', $message, 'fa-solid fa-circle-exclamation');
  }

  public function sessionFlash(string $cssClass, string $message, string $icon = null) {
    $sessionFlash = (object)[
      'cssClass' => $cssClass,
      'message' => $message,
      'icon' => $icon
    ];

    session()->flash('sessionFlash', $sessionFlash);
  }
}
