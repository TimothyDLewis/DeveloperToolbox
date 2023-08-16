<?php

namespace App\Models;

use App\Traits\Models\TimestampDisplay;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Status extends Model {
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

  public function projects(): HasMany {
    return $this->hasMany(Project::class);
  }

  public function statusOptions(): HasMany {
    return $this->hasMany(StatusOption::class);
  }
}
