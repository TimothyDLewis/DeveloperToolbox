<?php

namespace App\Models;

use App\Traits\Models\AttributeDisplay;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Resource extends Model {
  use AttributeDisplay;
  use HasFactory;
  use SoftDeletes;

  protected $guarded = [];

  public $formFields = [
    'background_color' => [
      'container-class' => 'col-12 col-sm-6 col-md-4',
      'custom_editor' => 'color-picker',
      'label' => 'Background Color',
      'type' => 'custom'
    ],
    'description' => [
      'container-class' => 'col-12',
      'label' => 'Description',
      'type' => 'textarea'
    ],
    'label' => [
      'container-class' => 'col-12 col-sm-6 col-md-4',
      'derivative' => 'slug',
      'label' => 'Label',
      'type' => 'text'
    ],
    'project_id' => [
      'container-class' => 'col-12 col-sm-6',
      'label' => 'Project',
      'type' => 'select'
    ],
    'title' => [
      'containerClass' => 'col-12',
      'derivative' => 'slug',
      'label' => 'Title',
      'type' => 'text'
    ],
    'text_color' => [
      'container-class' => 'col-12 col-sm-6 col-md-4',
      'custom_editor' => 'color-picker',
      'label' => 'Text Color',
      'type' => 'custom'
    ],
    'url' => [
      'container-class' => 'col-12 col-sm-6',
      'label' => 'URL',
      'type' => 'text'
    ]
  ];

  public function project(): BelongsTo {
    return $this->belongsTo(Project::class);
  }
}
