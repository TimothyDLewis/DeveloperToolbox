<?php

namespace App\Models;

use App\Traits\Models\ForSelect;
use App\Traits\Models\AttributeDisplay;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StatusOption extends Model {
  use AttributeDisplay;
  use ForSelect;
  use HasFactory;
  use SoftDeletes;

  protected $guarded = [];

  public $formFields = [
    'background_color' => [
      'container-class' => 'col-12',
      'custom_editor' => 'color-picker',
      'label' => 'Background Color',
      'type' => 'custom'
    ],
    'description' => [
      'container-class' => 'col-12',
      'label' => 'Description',
      'type' => 'text'
    ],
    'id' => [
      'label' => 'ID',
      'type' => 'hidden'
    ],
    'initial_status_option' => [
      'container-class' => 'col-12',
      'custom_editor' => 'boolean',
      'label' => 'Initial',
      'type' => 'custom'
    ],
    'label' => [
      'container-class' => 'col-12',
      'derivative' => 'slug',
      'label' => 'Label',
      'type' => 'text'
    ],
    'next_status' => [
      'container-class' => 'col-12',
      'label' => 'Next',
      'type' => 'select'
    ],
    'previous_status' => [
      'container-class' => 'col-12',
      'label' => 'Previous',
      'type' => 'select'
    ],
    'text_color' => [
      'container-class' => 'col-12',
      'custom_editor' => 'color-picker',
      'label' => 'Text Color',
      'type' => 'custom'
    ]
  ];

  public function issues(): HasMany {
    return $this->hasMany(Issue::class);
  }

  public function nextStatusOption(): BelongsTo {
    return $this->belongsTo(self::class);
  }

  public function nextStatusOptions(): HasMany {
    return $this->hasMany(self::class);
  }

  public function previousStatusOption(): BelongsTo {
    return $this->belongsTo(self::class);
  }

  public function previousStatusOptions(): HasMany {
    return $this->hasMany(self::class);
  }

  public function status(): BelongsTo {
    return $this->belongsTo(Status::class);
  }
}
