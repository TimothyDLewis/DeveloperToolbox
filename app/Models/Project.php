<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model {
  use HasFactory;
  use SoftDeletes;

  public $formFields = [
    'title' => [
      'container' => [
        'class' => 'col-12'
      ],
      'label' => 'Title',
      'type' => 'text'
    ],
    'code' => [
      'container' => [
        'class' => 'col-12 col-sm-6'
      ],
      'label' => 'Code',
      'type' => 'text'
    ],
    'source_code_management_url' => [
      'container' => [
        'class' => 'col-12 col-sm-6'
      ],
      'label' => 'Source Code Management (SCM) URL',
      'type' => 'text'
    ],
    'description' => [
      'container' => [
        'class' => 'col-12'
      ],
      'label' => 'Description',
      'type' => 'textarea'
    ]
  ];

  public function estimate(): BelongsTo {
    return $this->belongsTo(Estimate::class);
  }

  public function issues(): HasMany {
    return $this->hasMany(Issue::class);
  }

  public function resources(): HasMany {
    return $this->hasMany(Resource::class);
  }

  public function status(): BelongsTo {
    return $this->belongsTo(Status::class);
  }
}
