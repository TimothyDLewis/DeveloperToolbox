<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Estimate extends Model {
  use HasFactory;
  use SoftDeletes;

  public function estimateOptions(): HasMany {
    return $this->hasMany(EstimateOption::class);
  }

  public function projects(): HasMany {
    return $this->hasMany(Project::class);
  }
}
