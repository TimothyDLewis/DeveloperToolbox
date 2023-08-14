<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Models\TimestampDisplay;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Estimate extends Model {
  use HasFactory;
  use SoftDeletes;
  use TimestampDisplay;

  protected $guarded = [];

  public $formFields = [
    'title' => [
      'container' => [
        'class' => 'col-12'
      ],
      'derivative' => 'slug',
      'label' => 'Title',
      'name' => 'title',
      'type' => 'text'
    ],
    'description' => [
      'container' => [
        'class' => 'col-12'
      ],
      'label' => 'Description',
      'name' => 'description',
      'type' => 'textarea'
    ]
  ];

  public function estimateOptions(): HasMany {
    return $this->hasMany(EstimateOption::class);
  }

  public function projects(): HasMany {
    return $this->hasMany(Project::class);
  }
}
