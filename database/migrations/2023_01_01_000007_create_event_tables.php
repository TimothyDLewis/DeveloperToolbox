<?php

use App\Models\Event;
use App\Models\Sprint;
use App\Models\EventType;
use App\Enums\EventRecurrence;
use App\Traits\Migrations\Touched;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
  use Touched;

  public function up(): void {
    $workDayDuration = config('app.work_day_duration');

    Schema::create('event_types', function (Blueprint $table) {
      $table->id();

      $table->string('title');
      $table->string('slug')->unique();
      $table->string('text_color');
      $table->string('background_color');
      $table->boolean('affects_productivity')->default(false);
      $table->text('description')->nullable();

      $table->timestamps();
      $this->touched($table);
      $table->softDeletes();
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
      $table->boolean('allows_weekends')->default(false);
      $table->boolean('affects_productivity')->default(false);
      $table->text('description')->nullable();
      $table->text('yearly_eval_logic')->nullable();

      $table->timestamps();
      $this->touched($table);
      $table->softDeletes();
    });

    Schema::create('occurrences', function (Blueprint $table) use ($workDayDuration) {
      $table->id();
      $table->foreignIdFor(Event::class)->constrained();
      $table->foreignIdFor(Sprint::class)->nullable()->constrained();

      $table->dateTime('start_datetime');
      $table->dateTime('end_datetime');
      $table->boolean('all_day')->default(false);
      $table->integer('duration')->storedAs("CASE WHEN all_day THEN {$workDayDuration} ELSE TIMESTAMPDIFF(MINUTE, start_datetime, end_datetime) END")->nullable();

      $table->timestamps();
      $this->touched($table);
      $table->softDeletes();
    });
  }

  public function down(): void {
    Schema::dropIfExists('occurrences');
    Schema::dropIfExists('events');
    Schema::dropIfExists('event_types');
  }
};
