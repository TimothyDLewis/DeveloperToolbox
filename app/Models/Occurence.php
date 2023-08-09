<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Occurence extends Model {
  use HasFactory;
  use SoftDeletes;

  public function event(): BelongsTo {
    return $this->belongsTo(Event::class);
  }

  public function sprint(): BelongsTo {
    return $this->belongsTo(Sprint::class);
  }
}
