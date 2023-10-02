<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Status;
use App\Models\Estimate;
use App\Models\EventType;
use App\Enums\EventRecurrence;
use Illuminate\Database\Seeder;

class DefaultSeeder extends Seeder {
  private $eventTypes = [
    ['title' => 'Appointment', 'slug' => 'appointment', 'description' => 'External events (doctors appointment, errands, etc.)', 'background_color' => '#ffc107', 'text_color' => '#f8f9fa', 'affects_productivity' => false],
    ['title' => 'Birthday', 'slug' => 'birthday', 'description' => "All-day events to mark a date as someone's birthday.", 'background_color' => '#8615d1', 'text_color' => '#f8f9fa', 'affects_productivity' => false],
    ['title' => 'Holiday', 'slug' => 'holiday', 'description' => 'Stat holidays (Christmas, Boxing day, etc.)', 'background_color' => '#d98612', 'text_color' => '#f8f9fa', 'affects_productivity' => true],
    ['title' => 'Lieu Time', 'slug' => 'lieu_time', 'description' => 'Events that use "banked" hours.', 'background_color' => '#613914', 'text_color' => '#f8f9fa', 'affects_productivity' => true],
    ['title' => 'Meeting', 'slug' => 'meeting', 'description' => 'Internal events (meetings, SCRUM events, etc.)', 'background_color' => '#0d6efd', 'text_color' => '#f8f9fa', 'affects_productivity' => true],
    ['title' => 'Necessary Leave', 'slug' => 'necessary_leave', 'description' => 'Sick days, beverment days, etc.', 'background_color' => '#dc3545', 'text_color' => '#f8f9fa', 'affects_productivity' => true],
    ['title' => 'Other', 'slug' => 'other', 'description' => 'Events that do not fall under any of the listed Event Types.', 'background_color' => '#757575', 'text_color' => '#f8f9fa', 'affects_productivity' => false],
    ['title' => 'Vacation', 'slug' => 'vacation', 'description' => 'Paid time off, earned vacation time, etc.', 'background_color' => '#198754', 'text_color' => '#f8f9fa', 'affects_productivity' => true]
  ];

  private $events = [
    ['title' => 'New Years Day', 'slug' => 'new-years-day', 'yearly_eval_logic' => 'return strtotime(\'First Monday of January \' . $year);'],
    ['title' => 'Family Day', 'slug' => 'family-day', 'yearly_eval_logic' => 'return strtotime(\'Third Monday of February \' . $year);'],
    ['title' => 'Good Friday', 'slug' => 'good-friday', 'yearly_eval_logic' => 'return date_sub((new DateTime())->setTimestamp(easter_date($year)), date_interval_create_from_date_string(\'2 days\'));'], // Replace before January 1st, 2037
    ['title' => 'Easter Monday', 'slug' => 'easter-monday', 'yearly_eval_logic' => 'return date_add((new DateTime())->setTimestamp(easter_date($year)), date_interval_create_from_date_string(\'1 day\'));'],  // Replace before January 1st, 2037
    ['title' => 'Victoria Day', 'slug' => 'victoria-day', 'yearly_eval_logic' => 'return strtotime(\'Previous Monday May 25th \' . $year);'],
    ['title' => 'Canada Day', 'slug' => 'canada-day', 'yearly_eval_logic' => 'return strtotime(\'July 1st \' . $year);'],
    ['title' => 'Civic Holiday', 'slug' => 'civic-holiday', 'yearly_eval_logic' => 'return strtotime(\'First Monday of August \' . $year);'],
    ['title' => 'Labour Day', 'slug' => 'labour-day', 'yearly_eval_logic' => 'return strtotime(\'First Monday of September \' . $year);'],
    ['title' => 'National Day For Truth And Reconciliation', 'slug' => 'national-day-for-truth-and-reconciliation', 'yearly_eval_logic' => 'return strtotime(\'September 30th \' . $year);', 'affects_productivity' => false], // May or may not affect productivity, depends on Sector
    ['title' => 'Thanksgiving', 'slug' => 'thanksgiving', 'yearly_eval_logic' => 'return strtotime(\'Second Monday of October \' . $year);'],
    ['title' => 'Christmas', 'slug' => 'christmas', 'yearly_eval_logic' => 'return strtotime(\'December 25th \' . $year);'],
    ['title' => 'Boxing Day', 'slug' => 'boxing-day', 'yearly_eval_logic' => 'return strtotime(\'December 26th \' . $year);'],
  ];

  /**
  * Run the database seeds.
  */
  public function run(): void {
    $colorMode = config('app.color_theme');

    $noEstimate = Estimate::create([
      'title' => 'No Estimate',
      'slug' => 'no-estimate',
      'description' => 'A general Estimate system for projects that require no estimation (i.e. personal projects, etc.)'
    ]);

    $noEstimate->estimateOptions()->create([
      'label' => 'None',
      'slug' => "{$noEstimate->slug}-none",
      'value' => 0,
      'sort_order' => 1
    ]);

    $noStatus = Status::create([
      'title' => 'No Status',
      'slug' => 'no-status',
      'description' => 'A general Status system for projects that require no statuses (i.e. personal projects, etc.)'
    ]);

    $noStatus->initialStatusOption()->create([
      'label' => 'None',
      'slug' => "{$noStatus->slug}-none",
      'text_color' => $colorMode === 'dark' ? '#f8f9fa' : '#364a5e',
      'background_color' => $colorMode === 'dark' ? '#364a5e' : '#f8f9fa',
      'description' => 'Issue or task has no associated status.',
      'initial_status_option' => true,
      'sort_order' => 1
    ]);

    foreach($this->eventTypes as $eventTypeData) {
      EventType::create($eventTypeData);
    }

    $holiday = EventType::where('slug', 'holiday')->first();

    foreach($this->events as $eventData) {
      Event::create(array_merge([
        'affects_productivity' => $eventData['affects_productivity'] ?? $holiday->affects_productivity,
        'event_type_id' => $holiday->id,
        'recurrence' => EventRecurrence::NoRecurrence->value
      ], $eventData))->generateYearlyOccurrence(save: true);
    }
  }
}
