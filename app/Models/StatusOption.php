<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StatusOption extends Model {
  use HasFactory;
  use SoftDeletes;

  public function issues(): HasMany {
    return $this->hasMany(Issue::class);
  }

  public function nextStatusOption(): BelongsTo {
    return $this->belongsTo(self::class);
  }

  public function nextStatusOptions(): HasMany {
    return $this->hasMany(self::class);
  }

  public function previousStatusOption(): BelongsTo {
    return $this->belongsTo(self::class);
  }

  public function previousStatusOptions(): HasMany {
    return $this->hasMany(self::class);
  }

  public function status(): BelongsTo {
    return $this->belongsTo(Status::class);
  }
}
