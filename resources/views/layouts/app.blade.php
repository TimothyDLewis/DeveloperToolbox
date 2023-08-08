<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} @yield('title')</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" />
    @vite('resources/sass/app.scss')
  </head>
  <body data-bs-theme="dark">
    @include('components.navigation.navbar')

    @vite('resources/js/app.js')
  </body>
</html>
