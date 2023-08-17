<?php

namespace App\Traits\Models;

use Illuminate\Database\Eloquent\Builder;

trait ForSelect {
  public function scopeForSelect(Builder $query) {
    return $query->select(['id', ($this->titleColumn ?? 'title') . ' as label', 'slug']);
  }
}
