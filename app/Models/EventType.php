<?php

namespace App\Models;

use App\Traits\Models\ForSelect;
use App\Traits\Models\AttributeDisplay;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EventType extends Model {
  use AttributeDisplay;
  use ForSelect;
  use HasFactory;
  use SoftDeletes;

  protected $guarded = [];

  public $formFields = [
    'affects_productivity' => [
      'container-class' => 'col-12 col-sm-6 col-md-4',
      'custom_editor' => 'boolean',
      'label' => 'Affects Productivity',
      'type' => 'custom'
    ],
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
    'title' => [
      'container-class' => 'col-12',
      'derivative' => 'slug',
      'label' => 'Title',
      'type' => 'text'
    ],
    'text_color' => [
      'container-class' => 'col-12 col-sm-6 col-md-4',
      'custom_editor' => 'color-picker',
      'label' => 'Text Color',
      'type' => 'custom'
    ]
  ];

  public function events(): HasMany {
    return $this->hasMany(Event::class);
  }
}
