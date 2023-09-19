<?php

use App\Models\Estimate;
use App\Traits\Migrations\Touched;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
  use Touched;

  public function up(): void {
    Schema::create('estimates', function (Blueprint $table) {
      $table->id();

      $table->string('title');
      $table->string('slug')->unique();
      $table->text('description')->nullable();

      $table->timestamps();
      $this->touched($table);
      $table->softDeletes();
    });

    Schema::create('estimate_options', function (Blueprint $table) {
      $table->id();
      $table->foreignIdFor(Estimate::class)->constrained();

      $table->string('label');
      $table->string('slug')->unique();
      $table->integer('value');
      $table->integer('sort_order');

      $table->timestamps();
      $this->touched($table);
      $table->softDeletes();
    });
  }

  public function down(): void {
    Schema::dropIfExists('estimate_options');
    Schema::dropIfExists('estimates');
  }
};
