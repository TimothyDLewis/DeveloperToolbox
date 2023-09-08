<?php

namespace App\Traits\Models;

use Illuminate\Database\Eloquent\Builder;

trait ForSelect {
  public function scopeForSelect(Builder $query, string $titleColumn = 'title', string $eagerLoadKey = '', array $additional = [], bool $raw = false) {
    $columns = array_merge(['id', "{$titleColumn} as label", 'slug'], $additional);

    if ($eagerLoadKey) {
      $columns[] = $eagerLoadKey;
    }

    if ($raw) {
      foreach($columns as $column) {
        $query = $query->selectRaw($column);
      }

      return $query;
    }

    return $query->select($columns);
  }
}
