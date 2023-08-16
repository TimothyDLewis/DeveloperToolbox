<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Estimate;
use App\Models\EstimateOption;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Traits\Controllers\Breadcrumbs;
use App\Http\Requests\Estimates\StoreEstimateRequest;
use App\Http\Requests\Estimates\UpdateEstimateRequest;

class EstimateController extends Controller {
  use Breadcrumbs;

  public function index(): View {
    return view('estimates.index', $this->withBreadcrumbs(includes: ['estimates' => Estimate::withCount(['estimateOptions', 'projects'])->orderBy('slug')->paginate(10)]));
  }

  public function create(): View {
    $estimateOptions = collect();

    foreach(old('estimate_options', []) as $estimateOptionValues) {
      $estimateOptions->push(new EstimateOption($estimateOptionValues));
    }

    if ($estimateOptions->isEmpty()) {
      $estimateOptions->push(new EstimateOption());
    }

    return view('estimates.create', $this->withBreadcrumbs(
      path: 'create',
      includes: [
        'estimate' => new Estimate(),
        'estimateOptions' => $estimateOptions
      ]
    ));
  }

  public function store(StoreEstimateRequest $request): RedirectResponse {
    try {
      DB::transaction(function () use ($request) {
        $estimate = Estimate::create(collect($request->validated())->except('estimate_options')->toArray());

        foreach ($request->validated()['estimate_options'] as $estimateOptionData) {
          EstimateOption::create(array_merge($estimateOptionData, ['estimate_id' => $estimate->id]));
        }
      });

      $this->sessionSuccess('<strong>Estimate and Estimate Option(s) Created</strong>');

      return redirect()->route('estimates.index');
    } catch (Exception $ex) {
      Log::error($ex);
      $this->sessionDanger("<strong>Unable to Create Estimate</strong><br/><br/>Check logs for complete details.");

      return redirect()->back()->withInput();
    }
  }

  public function show(Estimate $estimate): View {
    $estimate->load(['estimateOptions' => function ($query) {
      return $query->orderBy('sort_order');
    }, 'projects' => function ($query) {
      return $query->with(['estimate', 'status']);
    }]);

    return view('estimates.show', $this->withBreadcrumbs(
      path: 'show',
      additional: ['estimate' => $estimate],
      includes: [
        'estimate' => $estimate
      ]
    ));
  }

  public function edit(Estimate $estimate): View {
    $estimateOptions = collect();

    foreach(old('estimate_options', []) as $estimateOptionValues) {
      $estimateOptions->push(new EstimateOption($estimateOptionValues));
    }

    if ($estimateOptions->isEmpty()) {
      $estimate->load(['estimateOptions' => function ($query) {
        return $query->orderBy('sort_order');
      }]);

      $estimateOptions = $estimate->estimateOptions;
    }

    return view('estimates.edit', $this->withBreadcrumbs(
      path: 'edit',
      additional: ['estimate' => $estimate],
      includes: [
        'estimate' => $estimate,
        'estimateOptions' => $estimateOptions
      ]
    ));
  }

  public function update(UpdateEstimateRequest $request, Estimate $estimate): RedirectResponse {
    try {
      DB::transaction(function () use ($estimate, $request) {
        $estimate->update(collect($request->validated())->except('estimate_options')->toArray());

        $estimate->load('estimateOptions');
        $estimateIdsToDelete = $estimate->estimateOptions->pluck('id');

        foreach ($request->validated()['estimate_options'] as $estimateOptionData) {
          if ($estimateOptionData['id'] ?? null) {
            $estimate->estimateOptions->first(function ($estimateOption) use ($estimateOptionData) {
              return $estimateOption->id == $estimateOptionData['id'];
            })->update($estimateOptionData);

            $estimateIdsToDelete = $estimateIdsToDelete->reject(function ($estimateOptionId) use ($estimateOptionData) {
              return $estimateOptionId == $estimateOptionData['id'];
            });
          } else {
            EstimateOption::create(array_merge($estimateOptionData, ['estimate_id' => $estimate->id]));
          }
        }

        if (!$estimateIdsToDelete->isEmpty()) {
          $estimate->estimateOptions()->whereIn('id', $estimateIdsToDelete)->delete();
        }
      });

      $this->sessionSuccess('<strong>Estimate and Estimate Option(s) Updated</strong>');

      return redirect()->route('estimates.show', $estimate);
    } catch (Exception $ex) {
      Log::error($ex);
      $this->sessionDanger("<strong>Unable to Update Estimate</strong><br/><br/>Check logs for complete details.");

      return redirect()->back()->withInput();
    }
  }

  public function destroy(Estimate $estimate): RedirectResponse {
    try {
      $estimate->delete();

      $this->sessionSuccess('<strong>Estimate Deleted</strong>');

      return redirect()->route('estimates.index');
    } catch (Exception $ex) {
      Log::error($ex);
      $this->sessionDanger("<strong>Unable to Delete Estimate</strong><br/><br/>Check logs for complete details.");

      return redirect()->back();
    }
  }

  private function constructBreadcrumbs(string $path = null, array $additional = []): Collection {
    $breadcrumbs = collect([(object)['label' => 'Estimates', 'path' => route('estimates.index')]]);

    if ($path === 'create') {
      $breadcrumbs->push((object)['label' => 'Create Estimate', 'path' => route('estimates.create')]);
    } elseif ($path === 'show' || $path === 'edit') {
      $breadcrumbs->push((object)['label' => 'View Estimate', 'path' => route('estimates.show', $additional['estimate'])]);
      if ($path == 'edit') {
        $breadcrumbs->push((object)['label' => 'Edit Estimate', 'path' => route('estimates.edit', $additional['estimate'])]);
      }
    }

    $breadcrumbs->last()->active = true;

    return $breadcrumbs;
  }
}
