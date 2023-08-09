<?php

namespace App\Enums;

enum EventRecurrence: string {
  case NoRecurrence = 'no_recurrence';
  case SprintDaily = 'sprint_daily';
  case SprintWeekly = 'sprint_weekly';
  case SprintStart = 'sprint_start';
  case MidSprint = 'mid_sprint';
  case SprintEnd = 'sprint_end';
}
