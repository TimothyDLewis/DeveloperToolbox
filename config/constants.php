<?php

$workDayDuration = (int)(env('WORK_DAY_DURATION', 450));
$workDayHalfDuration = ceil(($workDayDuration / 2) / 5) * 5;

return [

  /*
  |--------------------------------------------------------------------------
  | Days
  |--------------------------------------------------------------------------
  |
  | Used to construct JSON for Sprint Weekly recurrence option.
  |
  */

  'days' => ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'],

  /*
  |--------------------------------------------------------------------------
  | Durations
  |--------------------------------------------------------------------------
  |
  | Used to construct JSON for Sprint Weekly recurrence option.
  |
  */

  'durations' => [
    5 => '5 Minutes',
    15 => '15 Minutes',
    30 => '30 Minutes',
    60 => '1 Hour',
    90 => '1.5 Hours',
    120 => '2 Hours',
    180 => '3 Hours',
    240 => '4 Hours',
    360 => '6 Hours',
    $workDayHalfDuration => "Half Work Day ({$workDayHalfDuration} Minutes)",
    $workDayDuration => "Full Work Day ({$workDayDuration} Minutes)",
  ]
];
