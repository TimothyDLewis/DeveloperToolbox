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
      ],
      (object)[
        'label' => 'Organization',
        'href' => url('/organization'),
        'isActive' => request()->is('organization/*')
      ],
      (object)[
        'label' => 'Scheduler',
        'href' => url('/scheduler'),
        'isActive' => request()->is('scheduler')
      ],
      (object)[
        'label' => 'Expenses',
        'href' => url('/expenses'),
        'isActive' => request()->is('expenses')
      ]
    ]);
  }

  public function compose(View $view): void {
    $view->with(['navbarLinks' => $this->navbarLinks]);
  }
}
