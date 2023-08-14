<?php

namespace App\Providers;

use App\Helpers\FormHelper;
use App\Helpers\ThemeHelper;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Providers\Composers\NavbarComposer;
use App\Providers\Composers\SidebarComposer;

class ViewServiceProvider extends ServiceProvider {
  public function register(): void {

  }

  public function boot(): void {
    View::share('theme', new ThemeHelper());
    View::share('forms', new FormHelper());
    View::composer('components.navigation.organization.sidebar', SidebarComposer::class);
    View::composer('components.navigation.navbar', NavbarComposer::class);
  }
}
