$('.delete-task').on('click', function() {
  if (confirm('Are you sure you want to delete this Task?')) {
    return $(this).closest('form').trigger('submit');
  }
});
