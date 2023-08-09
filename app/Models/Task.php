<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model {
  use HasFactory;
  use SoftDeletes;

  public function issue(): BelongsTo {
    return $this->belongsTo(Issue::class);
  }
}
