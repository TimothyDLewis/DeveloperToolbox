<?php

namespace App\Models;

use App\Traits\Models\AttributeDisplay;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model {
  use AttributeDisplay;
  use HasFactory;
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

  public function issue(): BelongsTo {
    return $this->belongsTo(Issue::class);
  }
}
