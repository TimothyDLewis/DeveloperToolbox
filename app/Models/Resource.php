<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Resource extends Model {
  use HasFactory;
  use SoftDeletes;

  public function project(): BelongsTo {
    return $this->belongsTo(Project::class);
  }
}
