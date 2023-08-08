<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/info', function () {
  if (app()->isProduction()) {
    abort(404);
  }

  phpinfo();
});

Route::get('/test', function () {
  if (app()->isProduction()) {
    abort(404);
  }

  // Test away! "With great power, something, something, dark side."
});

Route::get('/', function () {
  return view('welcome');
});
