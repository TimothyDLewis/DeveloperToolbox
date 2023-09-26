<?php

namespace App\Traits\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait DateFormats {
  public function formatDateTime(string $field, string $format): ?string {
    return $this->{$field} ? Carbon::parse($this->{$field})->format($format) : null;
  }

  public function formattedStartDate(): Attribute {
    return Attribute::make(
      get: function (): ?string {
        return $this->start_datetime ? Carbon::parse($this->start_datetime)->format('F jS, Y') : null;
      }
    );
  }

  public function formattedStartTime(): Attribute {
    return Attribute::make(
      get: function (): ?string {
        return $this->start_datetime ? Carbon::parse($this->start_datetime)->format('g:i A') : null;
      }
    );
  }

  public function formattedCalendarStartTime(): Attribute {
    return Attribute::make(
      get: function (): ?string {
        return $this->start_datetime ? Carbon::parse($this->start_datetime)->format('g:i') : null;
      }
    );
  }

  public function formattedEndDate(): Attribute {
    return Attribute::make(
      get: function (): ?string {
        return $this->end_datetime ? Carbon::parse($this->end_datetime)->format('F jS, Y') : null;
      }
    );
  }

  public function formattedEndTime(): Attribute {
    return Attribute::make(
      get: function (): ?string {
        return $this->end_datetime ? Carbon::parse($this->end_datetime)->format('g:i A') : null;
      }
    );
  }

  public function formattedCalendarEndTime(): Attribute {
    return Attribute::make(
      get: function (): ?string {
        return $this->end_datetime ? Carbon::parse($this->end_datetime)->format('g:i') : null;
      }
    );
  }

  public function calendarStart(): Attribute {
    return Attribute::make(
      get: function (): ?string {
        return $this->start_datetime ? Carbon::parse($this->start_datetime)->startOfDay()->format('Y-m-d H:i:s') : null;
      }
    );
  }

  public function calendarEnd(): Attribute {
    return Attribute::make(
      get: function (): ?string {
        return $this->end_datetime ? Carbon::parse($this->end_datetime)->clone()->addDays(1)->startOfDay()->format('Y-m-d H:i:s') : null;
      }
    );
  }

  public function dateRange(): Attribute {
    return Attribute::make(
      get: function (): ?string {
        return "{$this->formatted_start_date} to {$this->formatted_end_date}";
      }
    );
  }

  public function timeRange(): Attribute {
    return Attribute::make(
      get: function (): ?string {
        return "{$this->formatted_start_time} - {$this->formatted_end_time}";
      }
    );
  }

  public function calendarTimeRange(): Attribute {
    return Attribute::make(
      get: function (): ?string {
        return "{$this->formatted_calendar_start_time} - {$this->formatted_calendar_end_time}";
      }
    );
  }
}
