$('#issueForm #project_id').on('change', function() {
  const getSelectOptions = $(this).closest('form').data('project-select-options');

  if ($(this).val() !== '') {
    $.get(getSelectOptions.replace(':project_id', $(this).val()), function (result) {
      $('#issueForm #estimate_option_id, #issueForm #status_option_id').each(function () {
        const select = $(this);
        const selectedValue = select.val();

        select.empty().append('<option value="">None Selected</option>');

        if (select.attr('id') === 'estimate_option_id') {
          result['estimate-options'].forEach(function (estimateOption) {
            select.append(`<option value="${estimateOption.id}">${estimateOption.label}</option>`);
          });

          select.val(selectedValue);
        } else if (select.attr('id') === 'status_option_id') {
          let initialStatus = '';

          result['status-options'].forEach(function (statusOption) {
            select.append(`<option value="${statusOption.id}">${statusOption.label}</option>`);

            if (statusOption.initial_status_option) {
              initialStatus = statusOption.id;
            }
          });

          select.val(selectedValue || initialStatus);
        }
      });
    });
  } else {
    $('#issueForm #estimate_option_id, #issueForm #status_option_id').empty().append('<option value="">None Selected</option>');
  }
});

$('.delete-issue').on('click', function() {
  if (confirm('Are you sure you want to delete this Issue?')) {
    return $(this).closest('form').trigger('submit');
  }
});
