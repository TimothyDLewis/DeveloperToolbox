<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\EventType;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Traits\Controllers\Breadcrumbs;
use App\Http\Requests\EventTypes\StoreEventTypeRequest;
use App\Http\Requests\EventTypes\UpdateEventTypeRequest;

class EventTypeController extends Controller {
  use Breadcrumbs;

  public function index(): View {
    return view('event-types.index', $this->withBreadcrumbs(includes: ['eventTypes' => EventType::withCount(['events'])->orderBy('id')->paginate(30)]));
  }

  public function create(): View {
    return view('event-types.create', $this->withBreadcrumbs(
      path: 'create',
      includes: [
        'eventType' => new EventType()
      ]
    ));
  }

  public function store(StoreEventTypeRequest $request): RedirectResponse {
    try {
      EventType::create($request->validated());

      $this->sessionSuccess('<strong>Event Type Created</strong>');

      return redirect()->route('event-types.index');
    } catch (Exception $ex) {
      Log::error($ex);
      $this->sessionDanger("<strong>Unable to Create Event Type</strong><br/><br/>Check logs for complete details.");

      return redirect()->back()->withInput();
    }
  }

  public function show(Request $request, EventType $eventType): JsonResponse | View {
    $eventType->load(['events']);

    if ($request->ajax()) {
      return response()->json(['eventType' => $eventType], 200);
    }

    return view('event-types.show', $this->withBreadcrumbs(
      path: 'show',
      additional: ['eventType' => $eventType],
      includes: ['eventType' => $eventType]
    ));
  }

  public function edit(EventType $eventType): View {
    return view('event-types.edit', $this->withBreadcrumbs(
      path: 'edit',
      additional: ['eventType' => $eventType],
      includes: ['eventType' => $eventType]
    ));
  }

  public function update(UpdateEventTypeRequest $request, EventType $eventType): RedirectResponse {
    try {
      $eventType->update($request->validated());
      $this->sessionSuccess('<strong>Event Type Updated</strong>');

      return redirect()->route('event-types.show', $eventType);
    } catch (Exception $ex) {
      Log::error($ex);
      $this->sessionDanger("<strong>Unable to Update Event Type</strong><br/><br/>Check logs for complete details.");

      return redirect()->back()->withInput();
    }
  }

  public function destroy(EventType $eventType): RedirectResponse {
    try {
      $eventType->delete();

      $this->sessionSuccess('<strong>EventType Deleted</strong>');

      return redirect()->route('event-types.index');
    } catch (Exception $ex) {
      Log::error($ex);
      $this->sessionDanger("<strong>Unable to Delete EventType</strong><br/><br/>Check logs for complete details.");

      return redirect()->back();
    }
  }

  private function constructBreadcrumbs(string $path = null, array $additional = []): Collection {
    $breadcrumbs = collect([(object)['label' => 'Event Types', 'path' => route('event-types.index')]]);

    if ($path === 'create') {
      $breadcrumbs->push((object)['label' => 'Create Event Type', 'path' => route('event-types.create')]);
    } elseif ($path === 'show' || $path === 'edit') {
      $breadcrumbs->push((object)['label' => 'View Event Type', 'path' => route('event-types.show', $additional['eventType'])]);
      if ($path == 'edit') {
        $breadcrumbs->push((object)['label' => 'Edit Event Type', 'path' => route('event-types.edit', $additional['eventType'])]);
      }
    }

    $breadcrumbs->last()->active = true;

    return $breadcrumbs;
  }
}
