<div class="fc-event-main-frame fc-{{ $occurrence->event->event_type_label_class }}">
  <div class="fc-event-time d-flex justify-content-center align-items-center">
    @unless($occurrence->all_day)
      {{ $occurrence->calendar_time_range }}
      <span class="fc-remove fc-remove-occurrence ms-2" data-occurrence-id="{{ $occurrence->id }}">
        <i class="fa-solid fa-xmark"></i>
      </span>
    @endunless
  </div>
  <div class="fc-event-title-container">
    <div class="fc-event-title {{ $occurrence->all_day ? 'd-flex justify-content-start align-items-center' : '' }}">
      @if($occurrence->all_day)
        <span class="fc-remove fc-remove-occurrence me-2" data-occurrence-id="{{ $occurrence->id }}">
          <i class="fa-solid fa-xmark"></i>
        </span>
      @endif
      <a class="fc-url" href="{{ route('events.show', $occurrence->event) }}">{{ $occurrence->event->title }}</a>
    </div>
  </div>
</div>
