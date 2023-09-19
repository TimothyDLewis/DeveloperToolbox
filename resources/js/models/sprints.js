$('.delete-sprint').on('click', function() {
  if (confirm('Are you sure you want to delete this Sprint?')) {
    return $(this).closest('form').trigger('submit');
  }
});

$('.regenerate-sprint').on('click', function() {
  if (confirm("Are you sure you want to regenerate all of this Sprint's Occurrences?")) {
    return $(this).closest('form').trigger('submit');
  }
});
