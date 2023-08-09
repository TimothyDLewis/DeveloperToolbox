<?php

namespace App\Models;

use App\Enums\EventRecurrence;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model {
  use HasFactory;
  use SoftDeletes;

  protected $casts = [
    'recurrence' => EventRecurrence::class
  ];

  public static function recurrences(): array {
    return array_column(EventRecurrence::cases(), 'value');
  }

  public function eventType(): BelongsTo {
    return $this->belongsTo(EventType::class);
  }

  public function occurences(): HasMany {
    return $this->hasMany(Occurence::class);
  }
}
