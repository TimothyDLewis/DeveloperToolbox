const reindexStatusOptions = () => {
  $('#statusForm .statusOption').each(function(index, statusOptionElement) {
    const statusOption = $(statusOptionElement);

    statusOption.find('input:visible').first().prop('placeholder', `Status Option #${index+1}`)

    statusOption.find('input, select').each(function(_idx, inputSelectElement) {
      const inputSelect = $(inputSelectElement);

      if (typeof inputSelect.attr('id') === 'string') {
        inputSelect.attr('id', inputSelect.attr('id').split('_')[0] + `_${index}`);
      }

      if (typeof inputSelect.attr('name') === 'string') {
        const nameParts = inputSelect.attr('name').replaceAll(']', '', ).split('[');
        inputSelect.attr('name', `${nameParts[0]}[${index}][${nameParts[2]}]`);
      }
    });

    statusOption.find('.moveRowUp').prop('disabled', index === 0);
    statusOption.find('.moveRowDown').prop('disabled', index === $('.statusOption').length - 1);

    statusOption.find('.statusOptionSortOrder').text(index + 1);
  });
};

const reconstructRelatedStatusOptions = () => {
  const availableOptions = $('#statusForm .statusOption').map(function(index, element) {
    return {
      id: index,
      label: $(element).find('input:visible').first().val() || `Status Option #${index + 1}`
    };
  });

  $('#statusForm .statusOption').each(function(soIndex, statusOptionElement) {
    const statusOption = $(statusOptionElement);
    const localOptions = [...availableOptions];

    localOptions.splice(soIndex, 1);

    statusOption.find('select').each(function() {
      const select = $(this);
      const selectedValue = select.val();

      select.empty().append('<option value="">None Selected</option>');
      localOptions.forEach(function (option) {
        select.append(`<option value="${option.id}">${option.label}</option>`);
      });
      select.val(selectedValue);
    });
  });
};

$('body').on('change', '#statusForm .statusOption .initialStatusOption', function () {
  if ($(this).is(':checked')) {
    $('#statusForm .statusOption .initialStatusOption').not($(this)).each(function () {
      $(this).siblings('input[type=hidden]').val(0);
      $(this).prop('checked', false);
    });
  } else {
    $('#statusForm .statusOption .initialStatusOption').each(function (index) {
      $(this).siblings('input[type=hidden]').val(index === 0 ? 1 : 0);
      $(this).prop('checked', index === 0);
    });
  }
});

$('body').on('click', '#statusForm .statusOption .colorSwatch', function () {
  $(this).closest('.input-group').find('.colorInput').val($(this).data('color'));
});

$('body').on('blur', '#statusForm .statusOption input[name$="[label]"]', function (e) {
  e.preventDefault();

  reconstructRelatedStatusOptions();
});

$('#statusForm #addRow').on('click', function() {
  const element = $('.statusOption').first();
  const clonedElement = element.clone();

  $(clonedElement).find('.invalid-feedback').remove();

  $(clonedElement).find('input, select').each(function(_idx, formElement) {
    $(formElement).removeClass('is-invalid');
    if ($(formElement).attr('type') === 'checkbox') {
      $(formElement).siblings('input[type=hidden]').val(0);
      $(formElement).prop('checked', false);
    } else {
      $(formElement).val($(this).data('default-value') ?? '');
    }
  });

  $('#statusForm #statusOptions').find('tbody').append(clonedElement);

  reconstructRelatedStatusOptions();
  reindexStatusOptions();

  $('#statusForm .removeRow').prop('disabled', false);

  clonedElement.find('input:visible').first().prop('placeholder', `Status Option #${$('#statusForm .statusOption').length}`).trigger('focus');
});

$('body').on('click', '#statusForm .moveRowUp', function() {
  const element = $(this).closest('.statusOption');

  element.prev('.statusOption').insertAfter(element);

  reindexStatusOptions();
});

$('body').on('click', '#statusForm .moveRowDown', function() {
  const element = $(this).closest('.statusOption');

  element.next('.statusOption').insertBefore(element);

  reindexStatusOptions();
});

$('body').on('click', '#statusForm .removeRow', function() {
  const element = $(this).closest('.statusOption');
  element.remove();

  reconstructRelatedStatusOptions();
  reindexStatusOptions();

  if ($('#statusForm .statusOption').length === 1) {
    $('#statusForm .removeRow').prop('disabled', true);
  }

  if ($('#statusForm .statusOption .initialStatusOption:checked').length === 0) {
    const initialStatusOption = $('#statusForm .statusOption .initialStatusOption').first();

    initialStatusOption.siblings('input[type=hidden]').val(1);
    initialStatusOption.prop('checked', true);
  }
});

$('.delete-status').on('click', function() {
  if (confirm('Are you sure you want to delete this Status?')) {
    return $(this).closest('form').trigger('submit');
  }
});
