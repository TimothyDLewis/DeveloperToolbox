<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Status;
use App\Models\StatusOption;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\RedirectResponse;
use App\Traits\Controllers\Breadcrumbs;
use App\Http\Requests\Statuses\StoreStatusRequest;
use App\Http\Requests\Statuses\UpdateStatusRequest;

class StatusController extends Controller {
  use Breadcrumbs;

  public function index(): View {
    return view('statuses.index', $this->withBreadcrumbs(includes: ['statuses' => Status::withCount(['statusOptions', 'projects'])->orderBy('slug')->paginate(10)]));
  }

  public function create(): View {
    $statusOptions = collect();

    foreach(old('status_options', []) as $statusOptionValues) {
      $statusOptions->push(new StatusOption($statusOptionValues));
    }

    if ($statusOptions->isEmpty()) {
      $statusOptions->push(new StatusOption(['initial_status_option' => '1']));
    }

    return view('statuses.create', $this->withBreadcrumbs(
      path: 'create',
      includes: [
        'status' => new Status(),
        'statusOptions' => $statusOptions
      ]
    ));
  }

  public function store(StoreStatusRequest $request): RedirectResponse {
    try {
      DB::transaction(function () use ($request) {
        $status = Status::create(collect($request->validated())->except('status_options')->toArray());

        $statusOptions = collect();
        foreach ($request->validated()['status_options'] as $index => $statusOptionData) {
          $statusOptions[$index] = StatusOption::create(collect($statusOptionData)->except(['previous_status', 'next_status'])->merge(['status_id' => $status->id])->toArray());
        }

        foreach ($statusOptions as $index => $statusOption) {
          $statusOptionData = $request->validated()['status_options'][$index];

          $statusOption->update([
            'previous_status_option_id' => $statusOptionData['previous_status'] === null ? null : $statusOptions[$statusOptionData['previous_status']]->id,
            'next_status_option_id' => $statusOptionData['next_status'] === null ? null : $statusOptions[$statusOptionData['next_status']]->id,
          ]);
        }
      });

      $this->sessionSuccess('<strong>Status and Status Option(s) Created</strong>');

      return redirect()->route('statuses.index');
    } catch (Exception $ex) {
      Log::error($ex);
      $this->sessionDanger("<strong>Unable to Create Status</strong><br/><br/>Check logs for complete details.");

      return redirect()->back()->withInput();
    }
  }

  public function show(Status $status): View {
    $status->load(['statusOptions' => function ($query) {
      return $query->with(['previousStatusOption', 'nextStatusOption'])->orderBy('sort_order');
    }, 'projects' => function ($query) {
      return $query->with(['status', 'status']);
    }]);

    return view('statuses.show', $this->withBreadcrumbs(
      path: 'show',
      additional: ['status' => $status],
      includes: [
        'status' => $status
      ]
    ));
  }

  public function edit(Status $status): View {
    $statusOptions = collect();

    foreach(old('status_options', []) as $statusOptionValues) {
      $statusOptions->push(new StatusOption($statusOptionValues));
    }

    if ($statusOptions->isEmpty()) {
      $status->load(['statusOptions' => function ($query) {
        return $query->with(['previousStatusOption', 'nextStatusOption'])->orderBy('sort_order');
      }]);

      foreach($status->statusOptions as $statusOption) {
        $statusOption->previous_status = $statusOption->previousStatusOption ? $statusOption->previousStatusOption->sort_order - 1 : null;
        $statusOption->next_status = $statusOption->nextStatusOption ? $statusOption->nextStatusOption->sort_order - 1 : null;

        $statusOptions->push($statusOption);
      }
    }

    return view('statuses.edit', $this->withBreadcrumbs(
      path: 'edit',
      additional: ['status' => $status],
      includes: [
        'status' => $status,
        'statusOptions' => $statusOptions
      ]
    ));
  }

  public function update(UpdateStatusRequest $request, Status $status): RedirectResponse {
    try {
      DB::transaction(function () use ($status, $request) {
        $status->update(collect($request->validated())->except('status_options')->toArray());

        $status->load('statusOptions');
        $statusIdsToDelete = $status->statusOptions->pluck('id');

        foreach ($request->validated()['status_options'] as $statusOptionData) {
          $status->statusOptions->first(function ($statusOption) use ($statusOptionData) {
            return $statusOption->id == $statusOptionData['id'];
          })->update($statusOptionData);

          $statusIdsToDelete = $statusIdsToDelete->reject(function ($statusOptionId) use ($statusOptionData) {
            return $statusOptionId == $statusOptionData['id'];
          });
        }

        if (!$statusIdsToDelete->isEmpty()) {
          $status->statusOptions()->whereIn('id', $statusIdsToDelete)->delete();
        }
      });

      $this->sessionSuccess('<strong>Status and Status Option(s) Updated</strong>');

      return redirect()->route('statuses.show', $status);
    } catch (Exception $ex) {
      Log::error($ex);
      $this->sessionDanger("<strong>Unable to Update Status</strong><br/><br/>Check logs for complete details.");

      return redirect()->back()->withInput();
    }
  }

  public function destroy(Status $status): RedirectResponse {
    try {
      $status->delete();

      $this->sessionSuccess('<strong>Status Deleted</strong>');

      return redirect()->route('statuses.index');
    } catch (Exception $ex) {
      Log::error($ex);
      $this->sessionDanger("<strong>Unable to Delete Status</strong><br/><br/>Check logs for complete details.");

      return redirect()->back();
    }
  }

  private function constructBreadcrumbs(string $path = null, array $additional = []): Collection {
    $breadcrumbs = collect([(object)['label' => 'Statuses', 'path' => route('statuses.index')]]);

    if ($path == 'create') {
      $breadcrumbs->push((object)['label' => 'Create Status', 'path' => route('statuses.create')]);
    } elseif ($path == 'edit') {
      $breadcrumbs->push((object)['label' => 'Edit Status', 'path' => route('statuses.edit', $additional['status'])]);
    }

    $breadcrumbs->last()->active = true;

    return $breadcrumbs;
  }
}
