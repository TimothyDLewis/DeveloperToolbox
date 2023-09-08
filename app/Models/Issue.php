<?php

namespace App\Models;

use App\Traits\Models\ForSelect;
use App\Traits\Models\AttributeDisplay;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Issue extends Model {
  use AttributeDisplay;
  use ForSelect;
  use HasFactory;
  use SoftDeletes;

  protected $guarded = [];

  public $formFields = [
    'code' => [
      'container-class' => 'col-12 col-sm-6',
      'label' => 'Code',
      'type' => 'text'
    ],
    'description' => [
      'container-class' => 'col-12',
      'label' => 'Description',
      'type' => 'textarea'
    ],
    'estimate_option_id' => [
      'container-class' => 'col-12 col-sm-6 col-md-4',
      'label' => 'Estimate Option',
      'type' => 'select'
    ],
    'external_url' => [
      'container-class' => 'col-12 col-sm-6',
      'label' => 'External URL',
      'type' => 'text'
    ],
    'project_id' => [
      'container-class' => 'col-12 col-sm-6 col-md-4',
      'label' => 'Project',
      'type' => 'select'
    ],
    'status_option_id' => [
      'container-class' => 'col-12 col-sm-6 col-md-4',
      'label' => 'Status Option',
      'type' => 'select'
    ],
    'title' => [
      'container-class' => 'col-12',
      'derivative' => 'slug',
      'label' => 'Title',
      'type' => 'text'
    ]
  ];

  public function estimateOption(): BelongsTo {
    return $this->belongsTo(EstimateOption::class);
  }

  public function project(): BelongsTo {
    return $this->belongsTo(Project::class);
  }

  public function sprints(): BelongsToMany {
    return $this->belongsToMany(Sprint::class);
  }

  public function statusOption(): BelongsTo {
    return $this->belongsTo(StatusOption::class);
  }

  public function tasks(): HasMany {
    return $this->hasMany(Task::class);
  }
}
