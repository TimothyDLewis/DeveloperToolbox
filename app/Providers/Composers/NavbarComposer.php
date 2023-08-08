<?php

namespace App\Providers\Composers;

use Illuminate\View\View;

class NavbarComposer {
  protected $navbarLinks = [];

  public function __construct() {
    $this->navbarLinks = collect([
      (object)[
        'label' => 'Dashboard',
        'href' => url('/'),
        'isActive' => request()->is('/')
      ]
    ]);
  }

  public function compose(View $view): void {
    $view->with(['navbarLinks' => $this->navbarLinks]);
  }
}
