<?php

use App\Models\Issue;
use App\Models\Sprint;
use App\Traits\Migrations\Touched;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
  use Touched;


  public function up(): void {
    Schema::create('sprints', function (Blueprint $table) {
      $table->id();

      $table->string('title');
      $table->string('slug')->unique();
      $table->date('start_date');
      $table->date('end_date');
      $table->text('description')->nullable();

      $table->timestamps();
      $this->touched($table);
      $table->softDeletes();
    });

    Schema::create('issue_sprint', function (Blueprint $table) {
      $table->foreignIdFor(Issue::class)->constrained();
      $table->foreignIdFor(Sprint::class)->constrained();
    });
  }

  public function down(): void {
    Schema::dropIfExists('issue_sprint');
    Schema::dropIfExists('sprints');
  }
};
