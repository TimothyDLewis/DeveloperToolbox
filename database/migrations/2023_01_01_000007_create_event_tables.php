<?php

use App\Models\Event;
use App\Models\Sprint;
use App\Models\EventType;
use App\Enums\EventRecurrence;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
  /**
  * Run the migrations.
  */
  public function up(): void {
    Schema::create('event_types', function (Blueprint $table) {
      $table->id();

      $table->string('title');
      $table->string('slug')->unique();
      $table->string('text_color');
      $table->string('background_color');
      $table->boolean('affects_productivity');
      $table->text('description')->nullable();

      $table->softDeletes();
      $table->timestamps();
    });

    Schema::create('events', function (Blueprint $table) {
      $table->id();
      $table->foreignIdFor(EventType::class)->constrained();

      $table->string('title');
      $table->string('slug')->unique();
      $table->enum('recurrence', Event::recurrences())->default(EventRecurrence::NoRecurrence->value);
      $table->json('recurrence_days')->nullable();
      $table->time('recurrence_start_time')->nullable();
      $table->time('recurrence_end_time')->nullable();
      $table->text('description')->nullable();

      $table->softDeletes();
      $table->timestamps();
    });

    Schema::create('occurences', function (Blueprint $table) {
      $table->id();
      $table->foreignIdFor(Event::class)->constrained();
      $table->foreignIdFor(Sprint::class)->constrained()->nullable();

      $table->dateTime('start_datetime');
      $table->dateTime('end_datetime');
      $table->integer('duration')->storedAs('TIMESTAMPDIFF(MINUTE, start_datetime, end_datetime)')->nullable();

      $table->softDeletes();
      $table->timestamps();
    });
  }

  /**
  * Reverse the migrations.
  */
  public function down(): void {
    Schema::dropIfExists('occurences');
    Schema::dropIfExists('events');
    Schema::dropIfExists('event_types');
  }
};
