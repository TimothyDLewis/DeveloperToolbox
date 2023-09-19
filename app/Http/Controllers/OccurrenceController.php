<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Event;
use App\Models\Occurrence;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Occurrences\StoreOccurrenceRequest;
use App\Http\Requests\Occurrences\UpdateOccurrenceRequest;

class OccurrenceController extends Controller {
  public function index(): View {
    return view('occurrences.index', $this->withBreadcrumbs(includes: ['occurrences' => Occurrence::orderBy('id', 'DESC')->paginate(30)]));
  }

  public function create(): View {
    return view('occurrences.create', $this->withBreadcrumbs(
      path: 'create',
      includes: [
        'events' => Event::orderBy('id')->forSelect()->get(),
        'occurrence' => new Occurrence()
      ]
    ));
  }

  public function store(StoreOccurrenceRequest $request): RedirectResponse {
    try {
      Occurrence::create($request->validated());

      $this->sessionSuccess('<strong>Occurrence Created</strong>');

      return redirect()->route('occurrences.index');
    } catch (Exception $ex) {
      Log::error($ex);
      $this->sessionDanger("<strong>Unable to Create Occurrence</strong><br/><br/>Check logs for complete details.");

      return redirect()->back()->withInput();
    }
  }

  public function show(Occurrence $occurrence): View {
    return view('occurrences.show', $this->withBreadcrumbs(
      path: 'show',
      additional: ['occurrence' => $occurrence],
      includes: ['occurrence' => $occurrence]
    ));
  }

  public function edit(Occurrence $occurrence): View {
    if ($occurrence->start_datetime && $occurrence->all_day) {
      $occurrence->start_datetime = substr($occurrence->start_datetime, 0, 10);
    }

    return view('occurrences.edit', $this->withBreadcrumbs(
      path: 'edit',
      additional: ['occurrence' => $occurrence],
      includes: [
        'events' => Event::orderBy('id')->forSelect()->get(),
        'occurrence' => $occurrence
      ]
    ));
  }

  public function update(UpdateOccurrenceRequest $request, Occurrence $occurrence): RedirectResponse {
    try {
      $occurrence->update($request->validated());
      $this->sessionSuccess('<strong>Occurrence Updated</strong>');

      return redirect()->route('occurrences.show', $occurrence);
    } catch (Exception $ex) {
      Log::error($ex);
      $this->sessionDanger("<strong>Unable to Update Occurrence</strong><br/><br/>Check logs for complete details.");

      return redirect()->back()->withInput();
    }
  }

  public function destroy(Occurrence $occurrence): RedirectResponse {
    try {
      $occurrence->delete();

      $this->sessionSuccess('<strong>Occurrence Deleted</strong>');

      return redirect()->route('occurrences.index');
    } catch (Exception $ex) {
      Log::error($ex);
      $this->sessionDanger("<strong>Unable to Delete Occurrence</strong><br/><br/>Check logs for complete details.");

      return redirect()->back();
    }
  }

  protected function constructBreadcrumbs(string $path = null, array $additional = []): Collection {
    $breadcrumbs = collect([(object)['label' => 'Occurrences', 'path' => route('occurrences.index')]]);

    if ($path === 'create') {
      $breadcrumbs->push((object)['label' => 'Create Occurrence', 'path' => route('occurrences.create')]);
    } elseif ($path === 'show' || $path === 'edit') {
      $breadcrumbs->push((object)['label' => 'View Occurrence', 'path' => route('occurrences.show', $additional['occurrence'])]);
      if ($path == 'edit') {
        $breadcrumbs->push((object)['label' => 'Edit Occurrence', 'path' => route('occurrences.edit', $additional['occurrence'])]);
      }
    }

    $breadcrumbs->last()->active = true;

    return $breadcrumbs;
  }
}
