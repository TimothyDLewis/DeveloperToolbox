<?php

namespace App\Http\Controllers;

use App\Traits\SessionFlash;
use App\Traits\Controllers\Breadcrumbs;
use App\Traits\Controllers\TouchesModels;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController {
  use AuthorizesRequests;
  use Breadcrumbs;
  use SessionFlash;
  use TouchesModels;
  use ValidatesRequests;
}
