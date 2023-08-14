<?php

namespace App\Traits\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait TimestampDisplay {
  public function createdDisplay(): Attribute {
    return Attribute::make(
      get: function (): string {
        return '<i class="fa-solid fa-calendar me-2"></i><span class="me-2">' . $this->created_at->format('F jS, Y') . '</span><i class="fa-solid fa-clock me-2"></i><span class="me-2">' . $this->created_at->format('g:i A') . '</span>';
      }
    );
  }

  public function updatedDisplay(): Attribute {
    return Attribute::make(
      get: function (): string {
        return '<i class="fa-solid fa-calendar me-2"></i><span class="me-2">' . $this->updated_at->format('F jS, Y') . '</span><i class="fa-solid fa-clock me-2"></i><span class="me-2">' . $this->updated_at->format('g:i A') . '</span>';
      }
    );
  }
}
