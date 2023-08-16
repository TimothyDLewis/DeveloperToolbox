<?php

namespace Database\Seeders;

use App\Models\Status;
use App\Models\Estimate;
use Illuminate\Database\Seeder;

class DefaultSeeder extends Seeder {
  /**
  * Run the database seeds.
  */
  public function run(): void {
    $colorMode = config('app.color_theme');

    $noEstimate = Estimate::create([
      'title' => 'Unestimated',
      'slug' => 'unestimated',
      'description' => 'A general Estimate system for projects that require no estimation (i.e. personal projects, etc.)'
    ]);

    $noEstimate->estimateOptions()->create([
      'label' => 'Unestimated',
      'slug' => 'unestimated-unestimated',
      'value' => 0,
      'sort_order' => 1
    ]);

    $noStatus = Status::create([
      'title' => 'No Status',
      'slug' => 'no-status',
      'description' => 'A general Status system for projects that require no statuses (i.e. person projects, etc.)'
    ]);

    $noStatus->statusOptions()->create([
      'label' => 'No Status',
      'slug' => 'no-status-no-status',
      'text_color' => $colorMode === 'dark' ? '#f8f9fa' : '364a5e',
      'background_color' => $colorMode === 'dark' ? '#364a5e' : 'f8f9fa',
      'description' => 'Issue or task has no associated status.',
      'initial_status_option' => true,
      'sort_order' => 1
    ]);
  }
}
