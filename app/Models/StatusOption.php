<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StatusOption extends Model {
  use HasFactory;
  use SoftDeletes;

  protected $guarded = [];

  public $formFields = [
    'background_color' => [
      'container' => [
        'class' => 'col-12'
      ],
      'custom_editor' => 'color-picker',
      'label' => 'Background Color',
      'type' => 'custom'
    ],
    'description' => [
      'container' => [
        'class' => 'col-12'
      ],
      'label' => 'Description',
      'type' => 'text'
    ],
    'id' => [
      'label' => 'ID',
      'type' => 'hidden'
    ],
    // -FEATURE- Maybe change to simple Boolean?
    'initial_status_option' => [
      'container' => [
        'class' => 'col-12'
      ],
      'custom_editor' => 'boolean',
      'label' => 'Initial',
      'type' => 'custom'
    ],
    'label' => [
      'container' => [
        'class' => 'col-12'
      ],
      'derivative' => 'slug',
      'label' => 'Label',
      'type' => 'text'
    ],
    'next_status' => [
      'container' => [
        'class' => 'col-12'
      ],
      'label' => 'Next',
      'type' => 'select',
      'options' => [
        'model' => self::class
      ]
    ],
    'previous_status' => [
      'container' => [
        'class' => 'col-12'
      ],
      'label' => 'Previous',
      'type' => 'select',
      'options' => [
        'model' => self::class
      ]
    ],
    'text_color' => [
      'container' => [
        'class' => 'col-12'
      ],
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

  public function badgeDisplay(): Attribute {
    return Attribute::make(
      get: function (): string {
        return '<span class="badge ms-1" style="color: '. $this->text_color .'; background-color: ' . $this->background_color . ';">' . $this->label . '</span>';
      }
    );
  }
}
