<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Sprint extends Model {
  use HasFactory;
  use SoftDeletes;

  public function issues(): BelongsToMany {
    return $this->belongsToMany(Issue::class);
  }

  public function occurences(): HasMany {
    return $this->hasMany(Occurence::class);
  }
}
