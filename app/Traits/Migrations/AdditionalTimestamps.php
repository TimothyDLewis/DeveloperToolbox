<?php

namespace App\Traits\Migrations;

use Illuminate\Database\Schema\Blueprint;

trait AdditionalTimestamps {
  public function additionalTimestamps(Blueprint $table) {
    $table->timestamp('archived_at')->nullable();
    $table->timestamp('touched_at')->nullable();
  }
}
