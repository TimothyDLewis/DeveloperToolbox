<?php

namespace App\Traits\Migrations;

use Illuminate\Database\Schema\Blueprint;

trait Touched {
  public function touched(Blueprint $table) {
    $table->timestamp('touched_at')->nullable();
  }
}
