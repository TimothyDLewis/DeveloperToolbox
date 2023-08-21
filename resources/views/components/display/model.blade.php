@if($model->{$modelField})
  <a href="{{ route($route, $model->{$modelField}) }}">{{ $model->{$modelField}->{$displayField ?? 'title'} }}</a>
@else
  <i class="text-secondary">No {{ $modelField }} selected...</i>
@endif
