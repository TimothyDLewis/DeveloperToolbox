<?php

use App\Models\Status;
use App\Models\Estimate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
  /**
  * Run the migrations.
  */
  public function up(): void {
    Schema::create('projects', function (Blueprint $table) {
      $table->id();
      $table->foreignIdFor(Estimate::class)->constrained();
      $table->foreignIdFor(Status::class)->constrained();

      $table->string('title');
      $table->string('slug')->unique();
      $table->string('code');
      $table->string('source_code_management_url')->nullable();
      $table->text('description')->nullable();

      $table->timestamps();
      $table->softDeletes();
    });
  }

  /**
  * Reverse the migrations.
  */
  public function down(): void {
    Schema::dropIfExists('projects');
  }
};
