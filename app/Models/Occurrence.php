<?php

namespace App\Models;

use Carbon\Carbon;
use App\Traits\Models\Presenter;
use App\Traits\Models\DateFormats;
use App\Traits\Models\AttributeDisplay;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Occurrence extends Model {
  use AttributeDisplay;
  use DateFormats;
  use HasFactory;
  use Presenter;
  use SoftDeletes;

  protected $guarded = [];

  public $formFields = [
    'all_day' => [
      'container-class' => 'col-12 col-sm-6 col-md-4',
      'custom_editor' => 'boolean',
      'label' => 'All Day',
      'type' => 'custom'
    ],
    'event_id' => [
      'container-class' => 'col-12',
      'label' => 'Event',
      'type' => 'select'
    ],
    'end_datetime' => [
      'container-class' => 'col-12 col-sm-6 col-md-4',
      'label' => 'End',
      'step' => 300, // 5 Minutes
      'type' => 'datetime'
    ],
    'start_datetime' => [
      'container-class' => 'col-12 col-sm-6 col-md-4',
      'label' => 'Start',
      'step' => 300, // 5 Minutes
      'type' => 'datetime'
    ]
  ];

  public function presentForScheduler(Occurrence $occurrence) {
    $backgroundColor = $occurrence->event->eventType->background_color;

    return array_merge($occurrence->only(['id']), [
      'allDay' => $occurrence->all_day,
      'backgroundColor' => $backgroundColor,
      'borderColor' => $backgroundColor, // Darken this?
      'end' => Carbon::parse($occurrence->end_datetime)->format('Y-m-d H:i:s'),
      'start' => Carbon::parse($occurrence->start_datetime)->format('Y-m-d H:i:s'),
      'textColor' => $occurrence->event->eventType->text_color,
      'title' => $occurrence->event->title,
      'type' => 'occurrence',
      'viewHtml' => [
        'timeGrid' => view('components.scheduler.occurrences.time-grid', ['occurrence' => $occurrence])->render(),
        'dayGrid' => view('components.scheduler.occurrences.day-grid', ['occurrence' => $occurrence])->render(),
        'list' => view('components.scheduler.occurrences.list', ['occurrence' => $occurrence])->render()
      ]
    ]);
  }

  public function event(): BelongsTo {
    return $this->belongsTo(Event::class);
  }

  public function sprint(): BelongsTo {
    return $this->belongsTo(Sprint::class);
  }
}
