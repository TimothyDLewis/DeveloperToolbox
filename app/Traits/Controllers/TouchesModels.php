<?php

namespace App\Traits\Controllers;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

trait TouchesModels {
  public function touchModel(Model $model): void {
    $model->timestamps = false;

    $model->update(['touched_at' => Carbon::now()]);
  }
}
