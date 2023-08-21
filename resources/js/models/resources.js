$('body').on('click', '#resourceForm .colorSwatch', function () {
  $(this).closest('.input-group').find('.colorInput').val($(this).data('color'));
});

$('.toggle-bookmarked').on('click', function () {
  $(this).toggleClass('text-warning', 'text-secondary');
  // -TODO- Hookup back-end change and update Quick Links (once displayed)
});

$('.delete-resource').on('click', function() {
  if (confirm('Are you sure you want to delete this Resource?')) {
    return $(this).closest('form').trigger('submit');
  }
});
