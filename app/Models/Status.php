<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Status extends Model {
  use HasFactory;
  use SoftDeletes;

  public function projects(): HasMany {
    return $this->hasMany(Project::class);
  }

  public function statusOptions(): HasMany {
    return $this->hasMany(StatusOption::class);
  }
}
