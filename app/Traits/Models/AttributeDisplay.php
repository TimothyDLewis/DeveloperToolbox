<?php

namespace App\Traits\Models;

use Illuminate\Contracts\View\View;
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

  public function createdAtDisplay(): Attribute {
    return Attribute::make(
      get: function (): string {
        return $this->timestampComponentDisplay('created_at');
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

  public function estimateDisplay(): Attribute {
    return Attribute::make(
      get: function (): string {
        return $this->relatedModelDisplay('estimate', 'estimates.show', 'title');
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

  public function projectDisplay(): Attribute {
    return Attribute::make(
      get: function (): string {
        return $this->relatedModelDisplay('project', 'projects.show', 'title');
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

  public function statusDisplay(): Attribute {
    return Attribute::make(
      get: function (): string {
        return $this->relatedModelDisplay('status', 'statuses.show', 'title');
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

  public function updatedAtDisplay(): Attribute {
    return Attribute::make(
      get: function (): string {
        return $this->timestampComponentDisplay('updated_at');
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

  private function timestampComponentDisplay(string $field): string {
    return '<i class="fa-solid fa-calendar me-2"></i><span class="me-2">' . $this->{$field}->format('F jS, Y') . '</span><i class="fa-solid fa-clock me-2"></i><span class="me-2">' . $this->{$field}->format('g:i A') . '</span>';
  }

  private function urlComponentDisplay(string $field, string $urlField, string $displayField): string {
    return view('components.display.url', ['model' => $this, 'urlField' => $urlField, 'displayField' => $displayField])->render();
  }
}
