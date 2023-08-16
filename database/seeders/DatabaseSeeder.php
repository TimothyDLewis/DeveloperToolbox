<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder {
  /**
  * Seed the application's database.
  */
  public function run(): void {
    Schema::disableForeignKeyConstraints();

    $seeders = [DefaultSeeder::class];

    /*
    |--------------------------------------------------------------------------
    | Development Seeder
    |--------------------------------------------------------------------------
    |
    | By default, a single Status and Estimate are created for Projects that
    | don't explicitly require Statuses or Estimates. If you'd like to create
    | any other Models, simply create a `DevelopmentSeeder.php` class
    | in the current directory.
    |
    */

    if (class_exists(DevelopmentSeeder::class)) {
      $seeders[] = DevelopmentSeeder::class;
    }

    $this->call($seeders);

    Schema::enableForeignKeyConstraints();
  }
}
