<?php

namespace App\Traits\Models;

use Carbon\Carbon;
use App\Enums\EventRecurrence;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait AttributeDisplay {
  public function backgroundColorDisplay(): Attribute {
    return Attribute::make(
      get: function(): string {
        return $this->hexComponentDisplay('background_color');
      }
    );
  }

  public function bookmarkedDisplay(): Attribute {
    return Attribute::make(
      get: function (): string {
        return '<i class="fa-regular fa-star ' . ($this->bookmarked ? 'text-warning' : 'text-secondary') . ' toggle-bookmarked"></i>';
      }
    );
  }

  public function codeDisplay(): Attribute {
    return Attribute::make(
      get: function (): string {
        return '<span class="badge rounded-pill text-bg-primary">' . $this->code . '</span>';
      }
    );
  }

  public function createdAtDisplay(): Attribute {
    return Attribute::make(
      get: function (): string {
        return $this->dateTimeComponentDisplay('created_at');
      }
    );
  }

  public function descriptionDisplay(): Attribute {
    return Attribute::make(
      get: function (): string {
        return $this->description ?? '<i class="text-secondary">No description provided...</i>';
      }
    );
  }

  public function durationDisplay(): Attribute {
    return Attribute::make(
      get: function (): string {
        return '<span class="badge rounded-pill text-bg-primary">' . $this->duration . '</span>';
      }
    );
  }

  public function endDateDisplay(): Attribute {
    return Attribute::make(
      get: function (): string {
        return $this->dateComponentDisplay('end_date');
      }
    );
  }

  public function endDateAsDateTimeDisplay(): Attribute {
    return Attribute::make(
      get: function (): string {
        return $this->dateComponentDisplay('end_datetime');
      }
    );
  }

  public function endDateTimeDisplay(): Attribute {
    return Attribute::make(
      get: function (): string {
        return $this->dateTimeComponentDisplay('end_datetime');
      }
    );
  }

  public function estimateDisplay(): Attribute {
    return Attribute::make(
      get: function (): string {
        return $this->relatedModelDisplay('estimate', 'estimates.show', 'title');
      }
    );
  }

  public function estimateOptionsCountDisplay(): Attribute {
    return Attribute::make(
      get: function (): string {
        return $this->countDisplay('estimate_options_count');
      }
    );
  }

  public function eventsCountDisplay(): Attribute {
    return Attribute::make(
      get: function (): string {
        return $this->countDisplay('events_count');
      }
    );
  }

  public function eventDisplay(): Attribute {
    return Attribute::make(
      get: function (): string {
        return $this->relatedModelDisplay('event', 'events.show', 'title');
      }
    );
  }

  public function externalUrlDisplay(): Attribute {
    return Attribute::make(
      get: function(): string {
        return $this->urlComponentDisplay($this, 'external_url', 'external_url');
      }
    );
  }

  public function issueDisplay(): Attribute {
    return Attribute::make(
      get: function (): string {
        return $this->relatedModelDisplay('issue', 'issues.show', 'title');
      }
    );
  }

  public function issuesCountDisplay(): Attribute {
    return Attribute::make(
      get: function (): string {
        return $this->countDisplay('issues_count');
      }
    );
  }

  public function labelDisplay(): Attribute {
    return Attribute::make(
      get: function (): string {
        return '<span class="badge ms-1" style="color: '. $this->text_color .'; background-color: ' . $this->background_color . ';">' . strtoupper($this->label) . '</span>';
      }
    );
  }

  public function labelDisplayAlt(): Attribute {
    return Attribute::make(
      get: function (): string {
        return '<span class="badge rounded-pill text-bg-primary">' . strtoupper($this->label) . '</span>';
      }
    );
  }

  public function labelTitleDisplay(): Attribute {
    return Attribute::make(
      get: function (): string {
        return '<span class="badge" style="color: '. $this->text_color .'; background-color: ' . $this->background_color . ';">' . strtoupper($this->title) . '</span>';
      }
    );
  }

  public function labelTitleEventsCountDisplay(): Attribute {
    return Attribute::make(
      get: function (): string {
        return '<span class="badge" style="color: '. $this->text_color .'; background-color: ' . $this->background_color . ';">' . strtoupper($this->title) . ' (' . $this->events_count . ')</span>';
      }
    );
  }

  public function occurrencesCountDisplay(): Attribute {
    return Attribute::make(
      get: function (): string {
        return $this->countDisplay('occurrences_count');
      }
    );
  }

  public function projectsCountDisplay(): Attribute {
    return Attribute::make(
      get: function (): string {
        return $this->countDisplay('projects_count');
      }
    );
  }

  public function projectDisplay(): Attribute {
    return Attribute::make(
      get: function (): string {
        return $this->relatedModelDisplay('project', 'projects.show', 'title');
      }
    );
  }

  public function recurrenceEndTimeDisplay(): Attribute {
    return Attribute::make(
      get: function (): string {
        return $this->timeComponentDisplay('recurrence_end_time');
      }
    );
  }

  public function recurrenceDisplay(): Attribute {
    return Attribute::make(
      get: function(): string {
        if ($this->yearly_eval_logic) {
          return 'Yearly';
        }

        return ucwords(str_replace('_', ' ', EventRecurrence::from($this->recurrence)->value));
      }
    );
  }

  public function recurrenceDisplayClass(): Attribute {
    return Attribute::make(
      get: function(): string {
        switch (is_string($this->recurrence) ? $this->recurrence : $this->recurrence->value) {
          case EventRecurrence::NoRecurrence->value:
          case EventRecurrence::SprintWeekly->value:
            return $this->yearly_eval_logic ? 'col-12 col-sm-6' : 'col-12';
          default:
            return 'col-12';
        }
      }
    );
  }

  public function recurrenceStartTimeDisplay(): Attribute {
    return Attribute::make(
      get: function (): string {
        return $this->timeComponentDisplay('recurrence_start_time');
      }
    );
  }

  public function resourcesCountDisplay(): Attribute {
    return Attribute::make(
      get: function (): string {
        return $this->countDisplay('resources_count');
      }
    );
  }

  public function sourceCodeManagementUrlDisplay(): Attribute {
    return Attribute::make(
      get: function(): string {
        return $this->urlComponentDisplay($this, 'source_code_management_url', 'source_code_management_url');
      }
    );
  }

  public function sprintsCountDisplay(): Attribute {
    return Attribute::make(
      get: function (): string {
        return $this->countDisplay('sprints_count');
      }
    );
  }

  public function sprintDisplay(): Attribute {
    return Attribute::make(
      get: function (): string {
        return $this->relatedModelDisplay('sprint', 'sprints.show', 'title');
      }
    );
  }

  public function startDateTimeAsDateDisplay(): Attribute {
    return Attribute::make(
      get: function (): string {
        return $this->dateComponentDisplay('start_datetime');
      }
    );
  }

  public function startDateDisplay(): Attribute {
    return Attribute::make(
      get: function (): string {
        return $this->dateComponentDisplay('start_date');
      }
    );
  }

  public function startDateTimeDisplay(): Attribute {
    return Attribute::make(
      get: function (): string {
        return $this->dateTimeComponentDisplay('start_datetime');
      }
    );
  }

  public function statusDisplay(): Attribute {
    return Attribute::make(
      get: function (): string {
        return $this->relatedModelDisplay('status', 'statuses.show', 'title');
      }
    );
  }

  public function statusOptionsCountDisplay(): Attribute {
    return Attribute::make(
      get: function (): string {
        return $this->countDisplay('status_options_count');
      }
    );
  }

  public function tasksCountDisplay(): Attribute {
    return Attribute::make(
      get: function (): string {
        return $this->countDisplay('tasks_count');
      }
    );
  }

  public function textColorDisplay(): Attribute {
    return Attribute::make(
      get: function(): string {
        return $this->hexComponentDisplay('text_color');
      }
    );
  }

  public function touchedDisplay(): Attribute {
    return Attribute::make(
      get: function(): string {
        return view('components.display.touched', ['model' => $this])->render();
      }
    );
  }

  public function updatedAtDisplay(): Attribute {
    return Attribute::make(
      get: function (): string {
        return $this->dateTimeComponentDisplay('updated_at');
      }
    );
  }

  public function urlTitleDisplay(): Attribute {
    return Attribute::make(
      get: function(): string {
        return $this->urlComponentDisplay($this, 'url', 'title');
      }
    );
  }

  public function valueDisplay(): Attribute {
    return Attribute::make(
      get: function (): string {
        return $this->countDisplay('value');
      }
    );
  }

  private function relatedModelDisplay(string $modelField, string $route, string $displayField): string {
    return view('components.display.model', [
      'displayField' => $displayField,
      'modelField' => $modelField,
      'model' => $this,
      'route' => $route,
    ])->render();
  }

  private function hexComponentDisplay(string $field): string {
    return view('components.display.hexcode', ['model' => $this, 'field' => $field])->render();
  }

  private function countDisplay(string $field): string {
    return '<span class="badge rounded-pill text-bg-secondary">' . $this->{$field} . '</span>';
  }

  private function dateComponentDisplay(string $field): string {
    return '<i class="fa-solid fa-calendar me-2"></i><span class="me-2">' . (is_string($this->{$field}) ? Carbon::parse($this->{$field}) : $this->{$field})->format('F jS, Y') . '</span>';
  }

  private function timeComponentDisplay(string $field): string {
    $includePrefix = strlen($this->{$field}) !== 19;
    return '<i class="fa-solid fa-clock me-2"></i><span class="me-2">' . (is_string($this->{$field}) ? Carbon::parse(($includePrefix ? '2000-01-01 ' : '') . $this->{$field}) : $this->{$field})->format('g:i A') . '</span>';
  }

  private function dateTimeComponentDisplay(string $field): string {
    return $this->dateComponentDisplay($field) . $this->timeComponentDisplay($field);
  }

  private function urlComponentDisplay(string $field, string $urlField, string $displayField): string {
    return view('components.display.url', ['model' => $this, 'urlField' => $urlField, 'displayField' => $displayField])->render();
  }
}
