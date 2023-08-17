<?php

namespace App\Models;

use App\Traits\Models\TimestampDisplay;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model {
  use HasFactory;
  use SoftDeletes;
  use TimestampDisplay;

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
    'estimate_id' => [
      'container-class' => 'col-12 col-sm-6',
      'label' => 'Estimate',
      'type' => 'select'
    ],
    'source_code_management_url' => [
      'container-class' => 'col-12 col-sm-6',
      'label' => 'Source Code Management (SCM) URL',
      'type' => 'text'
    ],
    'status_id' => [
      'container-class' => 'col-12 col-sm-6',
      'label' => 'Status',
      'type' => 'select'
    ],
    'title' => [
      'container-class' => 'col-12',
      'label' => 'Title',
      'type' => 'text'
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

  public function scmUrlDisplay(): Attribute {
    return Attribute::make(
      get: function(): string {
        return $this->scm_url ? "<a href=\"" . $this->scm_url . "\" target=\"_blank\"></a>" : '<i class="text-secondary">No URL provided...</i>';
      }
    );
  }
}
