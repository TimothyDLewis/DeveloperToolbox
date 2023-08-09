<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
  public function up() {
    Schema::dropIfExists('personal_access_tokens');
  }
};
