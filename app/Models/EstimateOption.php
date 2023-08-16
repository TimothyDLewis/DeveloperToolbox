<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EstimateOption extends Model {
  use HasFactory;
  use SoftDeletes;

  protected $guarded = [];

  public $formFields = [
    'id' => [
      'label' => 'ID',
      'type' => 'hidden'
    ],
    'label' => [
      'container' => [
        'class' => 'col-12'
      ],
      'derivative' => 'slug',
      'label' => 'Label',
      'type' => 'text'
    ],
    'value' => [
      'container' => [
        'class' => 'col-12'
      ],
      'label' => 'Value',
      'type' => 'text'
    ],
  ];

  public function estimate(): BelongsTo {
    return $this->belongsTo(Estimate::class);
  }

  public function issues(): HasMany {
    return $this->hasMany(Issue::class);
  }
}
