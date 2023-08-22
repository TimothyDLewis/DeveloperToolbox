<?php

use App\Models\Project;
use App\Models\StatusOption;
use App\Models\EstimateOption;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
  /**
  * Run the migrations.
  */
  public function up(): void {
    Schema::create('issues', function (Blueprint $table) {
      $table->id();
      $table->foreignIdFor(Project::class)->constrained();
      $table->foreignIdFor(EstimateOption::class)->constrained();
      $table->foreignIdFor(StatusOption::class)->constrained();

      $table->string('title');
      $table->string('slug')->unique();
      $table->string('code');
      $table->string('external_url')->nullable();
      $table->text('description')->nullable();

      $table->timestamps();
      $table->softDeletes();
    });
  }

  /**
  * Reverse the migrations.
  */
  public function down(): void {
    Schema::dropIfExists('issues');
  }
};
