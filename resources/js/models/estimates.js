const reindexEstimateOptions = () => {
  $('#estimateForm .estimateOption').each(function(index, estimateOptionElement) {
    const estimateOption = $(estimateOptionElement);

    estimateOption.find('input, select').each(function(_idx, inputSelectElement) {
      const inputSelect = $(inputSelectElement);
      const nameParts = inputSelect.attr('name').replaceAll(']', '', ).split('[');

      inputSelect.attr('id', inputSelect.attr('id').split('_')[0] + `_${index}`);
      inputSelect.attr('name', `${nameParts[0]}[${index}][${nameParts[2]}]`);
    });

    estimateOption.find('.moveRowUp').prop('disabled', index === 0);
    estimateOption.find('.moveRowDown').prop('disabled', index === $('.estimateOption').length - 1);

    estimateOption.find('.estimateOptionSortOrder').text(index + 1);
  });
};

$('#estimateForm #addRow').on('click', function() {
  const element = $('.estimateOption').first();
  const clonedElement = element.clone();

  $(clonedElement).find('.invalid-feedback').remove();

  $(clonedElement).find('input, select').each(function(_idx, formElement) {
    $(formElement).removeClass('is-invalid');
    $(formElement).val('');
  });

  $('#estimateForm #estimateOptions').find('tbody').append(clonedElement);

  reindexEstimateOptions();

  $('#estimateForm .removeRow').prop('disabled', false);

  clonedElement.find('input:visible').first().trigger('focus');
});

$('body').on('click', '#estimateForm .moveRowUp', function() {
  const element = $(this).closest('.estimateOption');

  element.prev('.estimateOption').insertAfter(element);

  reindexEstimateOptions();
});

$('body').on('click', '#estimateForm .moveRowDown', function() {
  const element = $(this).closest('.estimateOption');

  element.next('.estimateOption').insertBefore(element);

  reindexEstimateOptions();
});

$('body').on('click', '#estimateForm .removeRow', function() {
  const element = $(this).closest('.estimateOption');
  element.remove();

  reindexEstimateOptions();

  if ($('#estimateForm .estimateOption').length === 1) {
    $('#estimateForm .removeRow').prop('disabled', true);
  }
});

$('.delete-estimate').on('click', function() {
  if (confirm('Are you sure you want to delete this Estimate?')) {
    return $(this).closest('form').trigger('submit');
  }
});
