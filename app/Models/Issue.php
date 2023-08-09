<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Issue extends Model {
  use HasFactory;
  use SoftDeletes;

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
