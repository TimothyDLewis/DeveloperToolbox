<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Event;
use App\Models\Occurence;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Traits\Controllers\Breadcrumbs;
use App\Http\Requests\Occurences\StoreOccurenceRequest;
use App\Http\Requests\Occurences\UpdateOccurenceRequest;

class OccurenceController extends Controller {
  use Breadcrumbs;

  public function index(): View {
    return view('occurences.index', $this->withBreadcrumbs(includes: ['occurences' => Occurence::orderBy('id', 'DESC')->paginate(30)]));
  }

  public function create(): View {
    return view('occurences.create', $this->withBreadcrumbs(
      path: 'create',
      includes: [
        'events' => Event::orderBy('id')->forSelect()->get(),
        'occurence' => new Occurence()
      ]
    ));
  }

  public function store(StoreOccurenceRequest $request): RedirectResponse {
    try {
      Occurence::create($request->validated());

      $this->sessionSuccess('<strong>Occurence Created</strong>');

      return redirect()->route('occurences.index');
    } catch (Exception $ex) {
      Log::error($ex);
      $this->sessionDanger("<strong>Unable to Create Occurence</strong><br/><br/>Check logs for complete details.");

      return redirect()->back()->withInput();
    }
  }

  public function show(Occurence $occurence): View {
    return view('occurences.show', $this->withBreadcrumbs(
      path: 'show',
      additional: ['occurence' => $occurence],
      includes: ['occurence' => $occurence]
    ));
  }

  public function edit(Occurence $occurence): View {
    if ($occurence->start_datetime && $occurence->all_day) {
      $occurence->start_datetime = substr($occurence->start_datetime, 0, 10);
    }

    return view('occurences.edit', $this->withBreadcrumbs(
      path: 'edit',
      additional: ['occurence' => $occurence],
      includes: [
        'events' => Event::orderBy('id')->forSelect()->get(),
        'occurence' => $occurence
      ]
    ));
  }

  public function update(UpdateOccurenceRequest $request, Occurence $occurence): RedirectResponse {
    try {
      $occurence->update($request->validated());
      $this->sessionSuccess('<strong>Occurence Updated</strong>');

      return redirect()->route('occurences.show', $occurence);
    } catch (Exception $ex) {
      Log::error($ex);
      $this->sessionDanger("<strong>Unable to Update Occurence</strong><br/><br/>Check logs for complete details.");

      return redirect()->back()->withInput();
    }
  }

  public function destroy(Occurence $occurence): RedirectResponse {
    try {
      $occurence->delete();

      $this->sessionSuccess('<strong>Occurence Deleted</strong>');

      return redirect()->route('occurences.index');
    } catch (Exception $ex) {
      Log::error($ex);
      $this->sessionDanger("<strong>Unable to Delete Occurence</strong><br/><br/>Check logs for complete details.");

      return redirect()->back();
    }
  }

  private function constructBreadcrumbs(string $path = null, array $additional = []): Collection {
    $breadcrumbs = collect([(object)['label' => 'Occurences', 'path' => route('occurences.index')]]);

    if ($path === 'create') {
      $breadcrumbs->push((object)['label' => 'Create Occurence', 'path' => route('occurences.create')]);
    } elseif ($path === 'show' || $path === 'edit') {
      $breadcrumbs->push((object)['label' => 'View Occurence', 'path' => route('occurences.show', $additional['occurence'])]);
      if ($path == 'edit') {
        $breadcrumbs->push((object)['label' => 'Edit Occurence', 'path' => route('occurences.edit', $additional['occurence'])]);
      }
    }

    $breadcrumbs->last()->active = true;

    return $breadcrumbs;
  }
}
