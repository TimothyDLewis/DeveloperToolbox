<span class="d-block text-secondary touched">
  {!! $model->touched_at ? Carbon::parse($model->touched_at)->format('Y-m-d\<\b\r\/\\\>H:i:s') : '<i class="fa-solid fa-minus me-1"></i><i class="fa-solid fa-minus me-1"></i><i class="fa-solid fa-minus"></i>' !!}
</span>
