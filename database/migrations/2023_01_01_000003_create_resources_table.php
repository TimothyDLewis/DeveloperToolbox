<?php

use App\Models\Project;
use App\Traits\Migrations\Touched;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
  use Touched;

  public function up(): void {
    Schema::create('resources', function (Blueprint $table) {
      $table->id();
      $table->foreignIdFor(Project::class)->nullable()->constrained();

      $table->string('title');
      $table->string('slug')->unique();
      $table->string('label');
      $table->string('text_color')->default('white');
      $table->string('background_color');
      $table->string('url');
      $table->boolean('bookmarked')->default(false);
      $table->text('description')->nullable();

      $table->timestamps();
      $this->touched($table);
      $table->softDeletes();
    });
  }

  public function down(): void {
    Schema::dropIfExists('resources');
  }
};
