<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Providers\Composers\NavbarComposer;

class ViewServiceProvider extends ServiceProvider {
  public function register(): void {
    //
  }

  public function boot(): void {
    View::composer('components.navigation.navbar', NavbarComposer::class);
  }
}
