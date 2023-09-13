<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Event;
use App\Models\EventType;
use App\Enums\EventRecurrence;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Traits\Controllers\Breadcrumbs;
use App\Http\Requests\Events\StoreEventRequest;
use App\Http\Requests\Events\UpdateEventRequest;

class EventController extends Controller {
  use Breadcrumbs;

  public function index(): View {
    return view('events.index', $this->withBreadcrumbs(includes: ['events' => Event::with(['eventType'])->withCount(['occurences'])->orderBy('id', 'DESC')->paginate(30)]));
  }

  public function create(): View {
    $event = new Event(['recurrence' => EventRecurrence::from(old('recurrence', EventRecurrence::NoRecurrence->value))]);

    return view('events.create', $this->withBreadcrumbs(
      path: 'create',
      includes: [
        'days' => $this->constructDays($event),
        'event' => $event,
        'eventRecurrences' => Event::recurrencesForSelect(),
        'eventTypes' => EventType::orderBy('id')->forSelect()->get()
      ]
    ));
  }

  public function store(StoreEventRequest $request): RedirectResponse {
    try {
      Event::create($this->constructEventAttributes($request));

      $this->sessionSuccess('<strong>Event Created</strong>');

      return redirect()->route('events.index');
    } catch (Exception $ex) {
      Log::error($ex);
      $this->sessionDanger("<strong>Unable to Create Event</strong><br/><br/>Check logs for complete details.");

      return redirect()->back()->withInput();
    }
  }

  public function show(Event $event): View {
    $event->load(['occurences'])->loadCount(['occurences']);

    return view('events.show', $this->withBreadcrumbs(
      path: 'show',
      additional: ['event' => $event],
      includes: ['event' => $event]
    ));
  }

  public function edit(Event $event): RedirectResponse | View {
    if (!$event->canEdit()) {
      return $this->preventEdit();
    }

    $event->recurrence = EventRecurrence::from(old('recurrence', $event->recurrence));

    return view('events.edit', $this->withBreadcrumbs(
      path: 'edit',
      additional: ['event' => $event],
      includes: [
        'days' => $this->constructDays($event),
        'event' => $event,
        'eventRecurrences' => Event::recurrencesForSelect(),
        'eventTypes' => EventType::orderBy('id')->forSelect()->get()
      ]
    ));
  }

  public function update(UpdateEventRequest $request, Event $event): RedirectResponse {
    if (!$event->canEdit()) {
      return $this->preventEdit();
    }

    try {
      $event->update($this->constructEventAttributes($request));
      $this->sessionSuccess('<strong>Event Updated</strong>');

      return redirect()->route('events.show', $event);
    } catch (Exception $ex) {
      Log::error($ex);
      $this->sessionDanger("<strong>Unable to Update Event</strong><br/><br/>Check logs for complete details.");

      return redirect()->back()->withInput();
    }
  }

  public function destroy(Event $event): RedirectResponse {
    try {
      $event->delete();

      $this->sessionSuccess('<strong>Event Deleted</strong>');

      return redirect()->route('events.index');
    } catch (Exception $ex) {
      Log::error($ex);
      $this->sessionDanger("<strong>Unable to Delete Event</strong><br/><br/>Check logs for complete details.");

      return redirect()->back();
    }
  }

  private function constructBreadcrumbs(string $path = null, array $additional = []): Collection {
    $breadcrumbs = collect([(object)['label' => 'Events', 'path' => route('events.index')]]);

    if ($path === 'create') {
      $breadcrumbs->push((object)['label' => 'Create Event', 'path' => route('events.create')]);
    } elseif ($path === 'show' || $path === 'edit') {
      $breadcrumbs->push((object)['label' => 'View Event', 'path' => route('events.show', $additional['event'])]);
      if ($path == 'edit') {
        $breadcrumbs->push((object)['label' => 'Edit Event', 'path' => route('events.edit', $additional['event'])]);
      }
    }

    $breadcrumbs->last()->active = true;

    return $breadcrumbs;
  }

  private function constructDays(Event $event): Collection {
    $formFields = [
      'enabled' => [
        'custom_editor' => 'boolean',
        'label' => 'Enabled',
        'type' => 'custom'
      ],
      'recurrence_end_time' => [
        'label' => 'Recurrence End',
        'step' => 300, // 5 Minutes
        'type' => 'time'
      ],
      'recurrence_start_time' => [
        'label' => 'Recurrence Start',
        'step' => 300, // 5 Minutes
        'type' => 'time'
      ]
    ];

    $days = collect();
    foreach(config('constants.days') as $day) {
      $recurrenceDay = old("recurrence_days.{$day}", $event->recurrence_days[$day] ?? null) ?? [
        'enabled' => 0,
        'recurrence_end_time' => '',
        'recurrence_start_time' => ''
      ];

      $days->push((object)[
        'key' => $day,
        'label' => ucfirst($day),
        'formFields' => $formFields,
        'enabled' => old("recurrence_days.{$day}.enabled", isset($recurrenceDay['enabled']) ? (int)$recurrenceDay['enabled'] : 0),
        'recurrence_end_time' => old("recurrence_days.{$day}.recurrence_end_time", $recurrenceDay['recurrence_end_time']),
        'recurrence_start_time' => old("recurrence_days.{$day}.recurrence_start_time", $recurrenceDay['recurrence_start_time'])
      ]);
    };

    return $days;
  }

  private function constructEventAttributes($request): array {
    $attributes = collect($request->validated())->except('recurrence_days_enabled');
    $attributes['recurrence_days'] = collect($attributes['recurrence_days'])->reject(function ($recurrenceDay) {
      return !$recurrenceDay['enabled'];
    })->toArray();

    if (empty($attributes['recurrence_days'])) {
      $attributes['recurrence_days'] = null;
    }

    return $attributes->toArray();
  }

  private function preventEdit(): RedirectResponse {
    $this->sessionWarning("<strong>Unable to Edit Event</strong><br/><br/>Event is System Generated and cannot be directly edited.");

    return redirect()->back();
  }
}
