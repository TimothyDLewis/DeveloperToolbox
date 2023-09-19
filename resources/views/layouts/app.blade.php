<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} @yield('title')</title>
    <link rel="icon" href="{{ url('css/favicon.png') }}">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" />
    @vite('resources/sass/app.scss')
  </head>
  <body data-bs-theme="{{ config('app.color_theme') }}">
    @include('components.navigation.navbar')
    @include('components.navigation.breadcrumbs')

    @if(request()->is('organization/*'))
      <div class="d-flex flex-nowrap">
        @include('components.navigation.organization.sidebar')
        <div class="container-fluid">
          @yield('body')
        </div>
      </div>
    @else
      @yield('body')
    @endif

    @vite('resources/js/app.js')

    @yield('scripts')
  </body>
</html>
