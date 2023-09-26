<?php

use App\Models\Status;
use App\Models\Estimate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\AdditionalTimestamps;

return new class extends Migration {
  use AdditionalTimestamps;

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
      $this->additionalTimestamps($table);
      $table->softDeletes();
    });
  }

  public function down(): void {
    Schema::dropIfExists('projects');
  }
};
