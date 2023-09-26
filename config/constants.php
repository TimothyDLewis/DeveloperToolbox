<?php

$workDayDuration = (object)[
  'minutes' => $workDayDurationMinutes = (int)(env('WORK_DAY_DURATION', 450)),
  'duration' => str_pad('0', 2, floor($workDayDurationMinutes / 60)) . ':' . $workDayDurationMinutes % 60 . ':00'
];

$workDayHalfDuration = (object)[
  'minutes' => $workDayHalfDurationMinutes = (int)ceil(($workDayDuration->minutes / 2) / 5) * 5,
  'duration' => str_pad('0', 2, floor($workDayHalfDurationMinutes / 60)) . ':' . $workDayHalfDurationMinutes % 60 . ':00'
];

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
    5 => [
      'label' => '5 Minutes',
      'duration' => '00:05:00'
    ],
    15 => [
      'label' => '15 Minutes',
      'duration' => '00:15:00'
    ],
    30 => [
      'label' => '30 Minutes',
      'duration' => '00:30:00'
    ],
    60 => [
      'label' => '1 Hour (60 Minutes)',
      'duration' => '01:00:00'
    ],
    90 => [
      'label' => '1.5 Hours (90 Minutes)',
      'duration' => '01:30:00'
    ],
    120 => [
      'label' => '2 Hours (120 Minutes)',
      'duration' => '02:00:00'
    ],
    180 => [
      'label' => '3 Hours (180 Minutes)',
      'duration' => '03:00:00'
    ],
    240 => [
      'label' => '4 Hours (240 Minutes)',
      'duration' => '04:00:00'
    ],
    360 => [
      'label' => '6 Hours (360 Minutes)',
      'duration' => '06:00:00'
    ],
    $workDayHalfDuration->minutes => [
      'label' => "Half Work Day ({$workDayHalfDuration->minutes} Minutes)",
      'duration' => $workDayHalfDuration->duration
    ],
    $workDayDuration->minutes => [
      'label' => "Full Work Day ({$workDayDuration->minutes} Minutes)",
      'duration' => $workDayDuration->duration
    ],
  ]
];
