<?php

use App\Models\Project;
use App\Models\StatusOption;
use App\Models\EstimateOption;
use App\Traits\Migrations\Touched;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
  use Touched;

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
      $this->touched($table);
      $table->softDeletes();
    });
  }

  public function down(): void {
    Schema::dropIfExists('issues');
  }
};
