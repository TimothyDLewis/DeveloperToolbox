<?php

use App\Models\Issue;
use App\Models\Sprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
  /**
  * Run the migrations.
  */
  public function up(): void {
    Schema::create('sprints', function (Blueprint $table) {
      $table->id();

      $table->string('title');
      $table->string('slug')->unique();
      $table->date('start_date');
      $table->date('end_date');
      $table->text('description')->nullable();

      $table->timestamps();
      $table->softDeletes();
    });

    Schema::create('issue_sprint', function (Blueprint $table) {
      $table->foreignIdFor(Issue::class)->constrained();
      $table->foreignIdFor(Sprint::class)->constrained();
    });
  }

  /**
  * Reverse the migrations.
  */
  public function down(): void {
    Schema::dropIfExists('issue_sprint');
    Schema::dropIfExists('sprints');
  }
};
