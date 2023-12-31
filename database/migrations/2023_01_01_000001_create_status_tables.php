<?php

use App\Models\Status;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\AdditionalTimestamps;

return new class extends Migration {
  use AdditionalTimestamps;

  public function up(): void {
    Schema::create('statuses', function (Blueprint $table) {
      $table->id();

      $table->string('title');
      $table->string('slug')->unique();
      $table->text('description')->nullable();

      $table->timestamps();
      $this->additionalTimestamps($table);
      $table->softDeletes();
    });

    Schema::create('status_options', function (Blueprint $table) {
      $table->id();
      $table->foreignIdFor(Status::class)->constrained();

      $table->string('label');
      $table->string('slug')->unique();
      $table->string('text_color')->default('white');
      $table->string('background_color');
      $table->text('description')->nullable();
      $table->integer('sort_order');
      $table->boolean('initial_status_option')->default(false);
      $table->boolean('completed_status_option')->default(false);

      $table->timestamps();
      $this->additionalTimestamps($table);
      $table->softDeletes();
    });

    Schema::table('status_options', function (Blueprint $table) {
      $table->foreignId('previous_status_option_id')->after('status_id')->nullable()->constrained('status_options');
      $table->foreignId('next_status_option_id')->after('previous_status_option_id')->nullable()->constrained('status_options');
    });
  }

  public function down(): void {
    Schema::dropIfExists('status_options');
    Schema::dropIfExists('statuses');
  }
};
