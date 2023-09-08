<?php

namespace App\Models;

use App\Traits\Models\ForSelect;
use App\Traits\Models\AttributeDisplay;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Status extends Model {
  use AttributeDisplay;
  use ForSelect;
  use HasFactory;
  use SoftDeletes;

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

  public function initialStatusOption(): HasOne {
    return $this->hasOne(StatusOption::class)->where('initial_status_option', true);
  }

  public function statusOptions(): HasMany {
    return $this->hasMany(StatusOption::class);
  }
}
