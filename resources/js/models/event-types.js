$('body').on('click', '#eventTypeForm .colorSwatch', function () {
  $(this).closest('.input-group').find('.colorInput').val($(this).data('color'));
});

$('.delete-event-type').on('click', function() {
  if (confirm('Are you sure you want to delete this Event Type?')) {
    return $(this).closest('form').trigger('submit');
  }
});
