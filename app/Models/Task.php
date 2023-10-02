<?php

namespace App\Models;

use Carbon\Carbon;
use App\Traits\Models\Presenter;
use App\Traits\Models\DateFormats;
use App\Traits\Models\AttributeDisplay;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model {
  use AttributeDisplay;
  use DateFormats;
  use HasFactory;
  use Presenter;
  use SoftDeletes;

  protected $guarded = [];

  public $formFields = [
    'description' => [
      'container-class' => 'col-12',
      'label' => 'Description',
      'type' => 'textarea'
    ],
    'end_datetime' => [
      'container-class' => 'col-12 col-sm-6 col-md-4',
      'label' => 'End',
      'step' => 300, // 5 Minutes
      'type' => 'datetime'
    ],
    'issue_id' => [
      'container-class' => 'col-12',
      'label' => 'Issue',
      'type' => 'select'
    ],
    'logged' => [
      'container-class' => 'col-12 col-sm-6 col-md-4',
      'custom_editor' => 'boolean',
      'label' => 'Logged',
      'type' => 'custom'
    ],
    'start_datetime' => [
      'container-class' => 'col-12 col-sm-6 col-md-4',
      'label' => 'Start',
      'step' => 300, // 5 Minutes
      'type' => 'datetime'
    ]
  ];

  public function presentForScheduler(Task $task) {
    $backgroundColor = $task->issue->statusOption->background_color;

    return array_merge($task->only(['id', 'logged']), [
      'backgroundColor' => $backgroundColor,
      'borderColor' => $backgroundColor, // Darken this?
      'end' => Carbon::parse($task->end_datetime)->format('c'),
      'left' => $task->left,
      'right' => $task->right,
      'start' => Carbon::parse($task->start_datetime)->format('c'),
      'textColor' => $task->issue->statusOption->text_color,
      'title' => $task->issue->title,
      'type' => 'task',
      'viewHtml' => [
        'timeGrid' => view('components.scheduler.tasks.time-grid', ['task' => $task])->render(),
        'dayGrid' => view('components.scheduler.tasks.day-grid', ['task' => $task])->render(),
        'list' => view('components.scheduler.tasks.list', ['task' => $task])->render()
      ]
    ]);
  }

  public function left(): Attribute {
    return Attribute::make(
      get: function (): bool {
        return (bool)$this->issue->statusOption->previousStatusOption;
      }
    );
  }

  public function right(): Attribute {
    return Attribute::make(
      get: function (): bool {
        return (bool)$this->issue->statusOption->nextStatusOption;
      }
    );
  }

  public function issue(): BelongsTo {
    return $this->belongsTo(Issue::class);
  }
}
