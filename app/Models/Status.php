<?php

namespace App\Models;

use App\Traits\Models\ForSelect;
use App\Traits\Models\TimestampDisplay;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Status extends Model {
  use ForSelect;
  use HasFactory;
  use SoftDeletes;
  use TimestampDisplay;

  protected $guarded = [];

  public $formFields = [
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
    ]
  ];

  public function projects(): HasMany {
    return $this->hasMany(Project::class);
  }

  public function statusOptions(): HasMany {
    return $this->hasMany(StatusOption::class);
  }
}
