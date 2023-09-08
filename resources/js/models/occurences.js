$('#occurenceForm #all_day').on('change', function () {
  const container = $(this).closest('.col-12');

  const endInput = $('#occurenceForm #end_datetime');
  const endContainer = endInput.closest('.col-12');

  const startInput = $('#occurenceForm #start_datetime');
  const startContainer = startInput.closest('.col-12');
  const startValue = startInput.val().substring(0, 10);



  if ($(this).is(':checked')) {
    startContainer.toggleClass('col-sm-5 col-sm-10');

    endContainer.toggleClass('hidden', true);
    endInput.val('');

    startInput.attr('type', 'date').removeAttr('step').val(startValue);
  } else {
    startContainer.toggleClass('col-sm-10 col-sm-5');

    endInput.val('');
    endContainer.toggleClass('hidden', false);

    startInput.val('');
    startInput.attr('type', 'datetime-local').attr('step', 300);

    if (startValue.length === 10) {
      startInput.val(`${startValue}T00:00`);
    }
  }
});

$('.delete-occurence').on('click', function() {
  if (confirm('Are you sure you want to delete this Occurence?')) {
    return $(this).closest('form').trigger('submit');
  }
});
