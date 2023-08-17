$('.delete-project').on('click', function() {
  if (confirm('Are you sure you want to delete this Project?')) {
    return $(this).closest('form').trigger('submit');
  }
});
