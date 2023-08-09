<?php

namespace App\Classes;

use Carbon\Carbon;

class DateRange {
  public Carbon $startDateTime;
  public Carbon $endDateTime;

  public function __construct(Carbon $startDateTime, Carbon $endDateTime) {
    $this->startDateTime = $startDateTime;
    $this->endDateTime = $endDateTime;
  }
}
