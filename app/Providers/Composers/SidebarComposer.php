<?php

namespace App\Providers\Composers;

use Illuminate\View\View;

class SidebarComposer {
  private $sidebarPrefix = 'organization';
  protected $sidebarLinks = [];

  public function __construct() {
    $this->sidebarLinks = collect([
      (object)[
        'href' => route('estimates.index'),
        'icon' => '<i class="fa-regular fa-list-check me-2"></i>',
        'isActive' => request()->is("{$this->sidebarPrefix}/estimates") || request()->is("{$this->sidebarPrefix}/estimates/*"),
        'isDropdown' => false,
        'label' => 'Estimates',
      ],
      (object)[
        'href' => route('statuses.index'),
        'icon' => '<i class="fa-regular fa-bars-progress me-2"></i>',
        'isActive' => request()->is("{$this->sidebarPrefix}/statuses") || request()->is("{$this->sidebarPrefix}/statuses/*"),
        'isDropdown' => false,
        'label' => 'Statuses',
      ],
      (object)[
        'href' => route('projects.index'),
        'icon' => '<i class="fa-regular fa-clipboard-list me-2"></i>',
        'isActive' => request()->is("{$this->sidebarPrefix}/projects") || request()->is("{$this->sidebarPrefix}/projects/*"),
        'isDropdown' => false,
        'label' => 'Projects',
      ],
      (object)[
        'href' => route('resources.index'),
        'icon' => '<i class="fa-regular fa-bookmark me-2"></i>',
        'isActive' => request()->is("{$this->sidebarPrefix}/resources") || request()->is("{$this->sidebarPrefix}/resources/*"),
        'isDropdown' => false,
        'label' => 'Resources',
      ],
      (object)[
        'href' => route('issues.index'),
        'icon' => '<i class="fa-regular fa-cubes me-2"></i>',
        'isActive' => request()->is("{$this->sidebarPrefix}/issues") || request()->is("{$this->sidebarPrefix}/issues/*"),
        'isDropdown' => false,
        'label' => 'Issues',
      ],
      (object)[
        'children' => [
          (object)[
            'href' => route('event-types.index'),
            'icon' => '<i class="fa-regular fa-book me-2"></i>',
            'isActive' => $isEventTypesActive = request()->is("{$this->sidebarPrefix}/event-types") || request()->is("{$this->sidebarPrefix}/event-types/*"),
            'label' => 'Event Types',
          ],
          (object)[
            'href' => route('events.index'),
            'icon' => '<i class="fa-regular fa-calendar-plus me-2"></i>',
            'isActive' => $isEventsActive = request()->is("{$this->sidebarPrefix}/events") || request()->is("{$this->sidebarPrefix}/events/*"),
            'label' => 'Events',
          ],
          (object)[
            'href' => route('occurrences.index'),
            'icon' => '<i class="fa-regular fa-calendar-days me-2"></i>',
            'isActive' => $isOccurrencesActive = request()->is("{$this->sidebarPrefix}/occurrences") || request()->is("{$this->sidebarPrefix}/occurrences/*"),
            'label' => 'Occurrences',
          ],
          (object)[
            'href' => route('tasks.index'),
            'icon' => '<i class="fa-regular fa-layer-group me-2"></i>',
            'isActive' => $isTasksActive = request()->is("{$this->sidebarPrefix}/tasks") || request()->is("{$this->sidebarPrefix}/tasks/*"),
            'label' => 'Tasks',
          ]
        ],
        'dropdownId' => 'sidebar-events-dropdown',
        'isDropdown' => true,
        'isOpen' => $isEventTypesActive || $isEventsActive || $isOccurrencesActive || $isTasksActive,
        'label' => 'Scheduler',
      ],
      (object)[
        'href' => route('sprints.index'),
        'icon' => '<i class="fa-regular fa-arrows-split-up-and-left fa-rotate-180 me-2"></i>',
        'isActive' => request()->is("{$this->sidebarPrefix}/sprints") || request()->is("{$this->sidebarPrefix}/sprints/*"),
        'isDropdown' => false,
        'label' => 'Sprints',
      ],
      (object)[
        'href' => '#',
        'icon' => '<i class="fa-regular fa-file-lines me-2"></i>',
        'isActive' => false,
        'isDropdown' => false,
        'label' => 'Reports',
      ],
    ]);
  }

  public function compose(View $view): void {
    $view->with(['sidebarLinks' => $this->sidebarLinks]);
  }
}
