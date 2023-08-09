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
