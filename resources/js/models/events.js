const toggleTimeInputs = (show) => {
  const timeInputs = $('#eventForm #recurrence_start_time, #eventForm #recurrence_end_time');

  if (show) {
    timeInputs.parent().toggleClass('hidden', false);
  } else {
    timeInputs.parent().toggleClass('hidden', true);
    timeInputs.val('');
  }
}

const toggleRecurrenceDays = (show) => {
  const recurrenceDays = $('#eventForm #recurrenceDays');

  if (show) {
    recurrenceDays.toggleClass('hidden', false);
  } else {
    recurrenceDays.toggleClass('hidden', true);
    recurrenceDays.find('input[type=time]').val('');
    recurrenceDays.find('input[type=checkbox]').prop('checked', false);
    recurrenceDays.find('input[type=hidden]').val(0);
  }
}

$('#eventForm #recurrenceDays input[type=checkbox]').on('change', function () {
  const timeInputs = $(this).closest('tr').find('input[type=time]');

  if (!$(this).prop('checked')) {
    timeInputs.prop('readonly', true).val('');
  } else {
    timeInputs.prop('readonly', false);
  }
})

$('#eventForm #event_type_id').on('change', function() {
  const getEventType = $(this).closest('form').data('event-type');
  const affectsProductivity = $('#eventForm #affects_productivity');

  if ($(this).val() !== '') {
    $.get(getEventType.replace(':event_type_id', $(this).val()), function (result) {
      affectsProductivity.siblings('input[type=hidden]').val(result.eventType.affects_productivity ? 1 : 0);
      affectsProductivity.prop('checked', result.eventType.affects_productivity);
    });
  }
});

$('#eventForm #recurrence').on('change', function () {
  const container = $(this).parent();
  const selectedRecurrence = $(this).val();

  if (selectedRecurrence === 'no_recurrence' || selectedRecurrence === 'sprint_weekly') {
    container.toggleClass('col-sm-6', false).toggleClass('col-md-4', false);

    toggleTimeInputs(false);

    if (selectedRecurrence === 'sprint_weekly') {
      toggleRecurrenceDays(true);
    } else {
      toggleRecurrenceDays(false);
    }
  } else {
    container.toggleClass('col-sm-6', true).toggleClass('col-md-4', true);

    toggleTimeInputs(true);
    toggleRecurrenceDays(false);
  }
});

$('.delete-event').on('click', function() {
  if (confirm('Are you sure you want to delete this Event?')) {
    return $(this).closest('form').trigger('submit');
  }
});
