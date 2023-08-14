<?php

namespace App\Providers\Composers;

use Illuminate\View\View;

class SidebarComposer {
  private $sidebarPrefix = 'organization';
  protected $sidebarLinks = [];

  public function __construct() {
    $this->sidebarLinks = collect([
      (object)[
        'label' => 'Estimates',
        'href' => route('estimates.index'),
        'icon' => '<i class="fa-regular fa-list-check me-2"></i>',
        'isActive' => request()->is("{$this->sidebarPrefix}/estimates") || request()->is("{$this->sidebarPrefix}/estimates/*")
      ],
      (object)[
        'label' => 'Statuses',
        'href' => '#',
        'icon' => '<i class="fa-regular fa-bars-progress me-2"></i>',
        'isActive' => false
      ],
      (object)[
        'label' => 'Projects',
        'href' => route('projects.index'),
        'icon' => '<i class="fa-regular fa-clipboard-list me-2"></i>',
        'isActive' => request()->is("{$this->sidebarPrefix}/projects") || request()->is("{$this->sidebarPrefix}/projects/*")
      ],
      (object)[
        'label' => 'Resources',
        'href' => '#',
        'icon' => '<i class="fa-regular fa-bookmark me-2"></i>',
        'isActive' => false
      ],
      (object)[
        'label' => 'Issues',
        'href' => '#',
        'icon' => '<i class="fa-regular fa-cubes me-2"></i>',
        'isActive' => false
      ],
      (object)[
        'label' => 'Events',
        'href' => '#',
        'icon' => '<i class="fa-regular fa-calendar-plus me-2"></i>',
        'isActive' => false
      ],
      (object)[
        'label' => 'Sprints',
        'href' => '#',
        'icon' => '<i class="fa-regular fa-arrows-split-up-and-left fa-rotate-180 me-2"></i>',
        'isActive' => false
      ],
      (object)[
        'label' => 'Reports',
        'href' => '#',
        'icon' => '<i class="fa-regular fa-file-lines me-2"></i>',
        'isActive' => false
      ],
    ]);
  }

  public function compose(View $view): void {
    $view->with(['sidebarLinks' => $this->sidebarLinks]);
  }
}
