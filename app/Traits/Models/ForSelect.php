<?php

namespace App\Traits\Models;

use Illuminate\Database\Eloquent\Builder;

trait ForSelect {
  public function scopeForSelect(Builder $query, string $titleColumn = 'title', string $eagerLoadKey = '') {
    $columns = ['id', "{$titleColumn} as label", 'slug'];

    if ($eagerLoadKey) {
      $columns[] = $eagerLoadKey;
    }

    return $query->select($columns);
  }
}
