<?php

use App\Models\Estimate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
  /**
  * Run the migrations.
  */
  public function up(): void {
    Schema::create('estimates', function (Blueprint $table) {
      $table->id();

      $table->string('title');
      $table->string('slug')->unique();
      $table->text('description')->nullable();

      $table->timestamps();
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
      $table->softDeletes();
    });
  }

  /**
  * Reverse the migrations.
  */
  public function down(): void {
    Schema::dropIfExists('estimate_options');
    Schema::dropIfExists('estimates');
  }
};
