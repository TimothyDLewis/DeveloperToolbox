<?php

use App\Models\Issue;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
  public function up(): void {
    Schema::create('tasks', function (Blueprint $table) {
      $table->id();
      $table->foreignIdFor(Issue::class)->constrained();

      $table->dateTime('start_datetime');
      $table->dateTime('end_datetime');
      $table->integer('duration')->storedAs('TIMESTAMPDIFF(MINUTE, start_datetime, end_datetime)')->nullable();
      $table->boolean('logged')->default(false);
      $table->text('description')->nullable();

      $table->timestamps();
      $table->softDeletes();
    });
  }

  public function down(): void {
    Schema::dropIfExists('tasks');
  }
};
