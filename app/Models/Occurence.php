<?php

namespace App\Models;

use App\Traits\Models\AttributeDisplay;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Occurence extends Model {
  use AttributeDisplay;
  use HasFactory;
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

  public function event(): BelongsTo {
    return $this->belongsTo(Event::class);
  }

  public function sprint(): BelongsTo {
    return $this->belongsTo(Sprint::class);
  }
}
