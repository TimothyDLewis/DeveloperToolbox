<?php

namespace App\Models;

use Carbon\Carbon;
use App\Traits\Models\AttributeDisplay;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Sprint extends Model {
  use AttributeDisplay;
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
    ],
    'end_date' => [
      'container-class' => 'col-12 col-sm-6',
      'label' => 'End',
      'type' => 'date'
    ],
    'start_date' => [
      'container-class' => 'col-12 col-sm-6',
      'label' => 'Start',
      'type' => 'date'
    ]
  ];

  public function issues(): BelongsToMany {
    return $this->belongsToMany(Issue::class);
  }

  public function occurences(): HasMany {
    return $this->hasMany(Occurence::class);
  }

  public function scopeOverlapsDate(Builder $query, Carbon $dateTime) {
    return $query->whereRaw('? >= start_date AND ? <= end_date', [$dateTime, $dateTime]);
  }
}
