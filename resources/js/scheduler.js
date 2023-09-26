import moment from 'moment';
import '@fullcalendar/core/vdom';
import listPlugin from '@fullcalendar/list';
import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import interactionPlugin, { ThirdPartyDraggable } from '@fullcalendar/interaction';

await import('jquery-ui/dist/jquery-ui');

const TOKEN = $('meta[name=csrf-token]').attr('content');

let scheduler = null;
let draggable = null;

const timeFormat = 'HH:mm:ss';
const dateFormat = 'YYYY-MM-DD';
const dateTimeFormat = `${dateFormat} ${timeFormat}`;

const sprint = $('#schedulerContainer').data('sprint');
const jsPaths = $('#schedulerContainer').data('js-paths');

function constructCalendar() {
  const minTime = moment().startOf('day');
  const currentTime = moment();

  let scrollTime = currentTime.subtract(1.5, 'hours').format(timeFormat);
  if (minTime.clone().add(1.5, 'hours') > currentTime) {
    scrollTime = minTime.format(timeFormat);
  }

  const schedulerEl = $('#scheduler').get()[0];

  const schedulerOptions = {
    allDayContent: function () {
      return 'All Day'
    },
    allDaySlot: true,
    buttonText: {
      today: 'Today',
      month: 'Month',
      week: 'Week',
      day: 'Day',
      list: 'List'
    },
    droppable: true,
    drop: function (dropInfo) {
      const allDay = dropInfo.allDay;
      const date = moment(dropInfo.date);
      const draggedEelement = $(dropInfo.draggedEl);
      const duration = $('#timeblockDuration').val();

      if (draggedEelement.hasClass('calendar-task')) {
        if (allDay) {
          return alert('Tasks cannot be dropped in an "All Day" slot.');
        }

        const start = date.clone();
        const end = date.clone().add(duration, 'minutes');

        storeTimeblock('task', {
          _token: TOKEN,
          end_datetime: end.format(dateTimeFormat),
          issue_id: $(draggedEelement).data('issue-id'),
          logged: 0,
          start_datetime: start.format(dateTimeFormat)
        });
      } else if (draggedEelement.hasClass('calendar-occurrence')) {
        const start = date.clone();
        const end = allDay ? date.clone() : date.clone().add(duration, 'minutes');

        storeTimeblock('occurrence', {
          _token: TOKEN,
          all_day: allDay ? 1 : 0,
          end_datetime: end.format(dateTimeFormat),
          event_id: $(draggedEelement).data('event-id'),
          start_datetime: start.format(dateTimeFormat),
        });
      }
    },
    editable: true,
    events: function (fetchInfo, successCallback) {
      $.post(jsPaths['scheduler.events'], {
        _token: TOKEN,
        end: fetchInfo.endStr,
        start: fetchInfo.startStr
      }, function (response) {
        successCallback(response);
      });
    },
    eventContent: function (arg) {
      const viewType = arg.view.type;

      const viewPrefix = ['dayGrid', 'timeGrid', 'list'].find(function (viewPrefixOption) {
        if (viewType.startsWith(viewPrefixOption)) {
          return viewPrefixOption
        }
      });

      if (typeof viewPrefix !== 'undefined' && typeof arg.event.extendedProps.viewHtml !== 'undefined') {
        return {
          html: arg.event.extendedProps.viewHtml[viewPrefix]
        };
      }
    },
    eventDrop: function(eventDropInfo) {
      const [event, start_datetime, end_datetime, type] = eventInfoVars(eventDropInfo);

      if (type === 'task') {
        if (event.allDay) {
          alert('Tasks cannot be dropped in an "All Day" slot.');

          return scheduler.refetchEvents();
        }

        updateTimeblock(type, event.id, {
          _token: TOKEN,
          end_datetime,
          logged: 0,
          start_datetime
        });
      } else if (type === 'occurrence') {
        console.warn(start_datetime, end_datetime);
        updateTimeblock(type, event.id, {
          _token: TOKEN,
          all_day: event.allDay ? 1 : 0,
          end_datetime,
          start_datetime,
        });
      }
    },
    eventResize: function(eventResizeInfo) {
      const [event, start_datetime, end_datetime, type] = eventInfoVars(eventResizeInfo);

      if (type === 'task') {
        updateTimeblock(type, event.id, {
          _token: TOKEN,
          end_datetime,
          logged: 0,
          start_datetime
        });
      } else if (type === 'occurrence') {
        updateTimeblock(type, event.id, {
          _token: TOKEN,
          allDay: 0,
          end_datetime,
          start_datetime
        });
      }
    },
    headerToolbar: {
      left: 'prev today',
      center: 'title',
      right: 'timeGridDay,timeGridWeek,dayGridMonth,listWeek next'
    },
    height: '1175px',
    initialView: 'timeGridWeek',
    nowIndicator: true,
    plugins: [
      dayGridPlugin,
      timeGridPlugin,
      listPlugin,
      interactionPlugin
    ],
    scrollTime,
    scrollTimeReset: false,
    slotDuration: '00:05:00',
    slotLabelInterval: '00:30:00',
    slotLabelFormat: {
      hour: 'numeric',
      minute: '2-digit',
      omitZeroMinute: false
    },
    views: {
      dayGridMonth: {
        titleFormat: {
          year: 'numeric',
          month: 'long'
        }
      },
      listWeek: {
        eventTimeFormat: {
          hour: 'numeric',
          minute: '2-digit'
        }
      }
    },
    weekends: true
  };

  if (typeof sprint !== 'undefined') {
    const sprintStartDate = moment(sprint.fullcalendar_start_date);
    const sprintEndDate = moment(sprint.fullcalendar_end_date);

    schedulerOptions.customButtons = {
      viewSprint: {
        text: 'View Sprint',
        click: function () {
          window.location.href = jsPaths['sprints.show'].replace(':sprint', sprint.id)
        }
      }
    };

    schedulerOptions.headerToolbar.left = 'prev today,viewSprint';

    if (sprint.restrictDates) {
      schedulerOptions.validRange = {
        start: sprintStartDate.format(),
        end: sprintEndDate.format()
      }
    } else {
      schedulerOptions.dayCellClassNames = function (arg) {
        if (moment(arg.date).isBetween(sprintStartDate, sprintEndDate, undefined, '[]')) {
          return ['fc-sprint-highlight'];
        }
      }
    }
  }

  scheduler = new Calendar(schedulerEl, schedulerOptions);
  scheduler.render();
}

function constructDraggables(destroy = false) {
  if (destroy && draggable) {
    $('#scheduler-sidebar .list-group-item').draggable('destroy');
    draggable.destroy();
  }

  const minutes = $('#timeblockDuration').val();
  const duration = $('#timeblockDuration').find('option:selected').data('duration');

  $('#scheduler-sidebar .list-group-item').each(function () {
    $(this).data('minutes', minutes);
    $(this).data('duration', duration);
    $(this).draggable({
      zIndex: 9999,
      revert: true,
      revertDuration: 0,
      cursor: 'move',
      helper: function () {
        const helperClass = $(this).data('helper-class');
        const title = $(this).data('title');
        const styleString = 'padding: 5px; color: white; border-radius: 5px;';
        const color = $(this).data('color');

        return $(`<div class="fc-jquery-ui-draggable fc-draggable-${helperClass}" style="background-color: ${color} !important; border-color: ${color}; ${styleString}">${title}</div>`);
      },
      appendTo: 'body',
      cursorAt: {
        left: 2,
        top: 2
      }
    });
  });

  draggable = new ThirdPartyDraggable(document.getElementById('scheduler-sidebar'), {
    itemSelector: '.list-group-item',
    mirrorSelector: '.fc-jquery-ui-draggable',
    eventData: function (eventEl) {
      const eventElement = $(eventEl);
      return {
        title: eventElement.data('title'),
        create: false,
        backgroundColor: eventElement.data('color'),
        borderColor: eventElement.data('color'),
        duration
      };
    }
  });
}

function eventInfoVars(eventInfoSource) {
  const event = eventInfoSource.event;
  const type = event.extendedProps.type;

  const start_datetime = moment(event.start);
  let end_datetime = event.allDay ? moment(event.start) : moment(event.end);

  if (!end_datetime.isValid()) {
    end_datetime = moment(event.start).add($('#timeblockDuration').val(), 'minutes');
  }

  return [event, start_datetime.format(dateTimeFormat), end_datetime.format(dateTimeFormat), type];
}

function crudVars(type, action) {
  return [
    type === 'task' ? jsPaths[`tasks.${action}`] : jsPaths[`occurrences.${action}`],
    type.charAt(0).toUpperCase() + type.slice(1)
  ];
}

function storeTimeblock(type, postData) {
  const [storePath, errorString] = crudVars(type, 'store');

  $.post(storePath, postData, function (_data) {
    scheduler.refetchEvents();
  }).fail(function (response) {
    alert(`Unable to create ${errorString}: Error ${response.status}: ${response.responseText}`);
  });
}

function updateTimeblock(type, id, patchData, refresh = true) {
  const [updatePath, errorString] = crudVars(type, 'update');

  $.ajax({
    type: 'PATCH',
    url: updatePath.replace(`:${type}`, id),
    data: patchData,
    success: function (_data) {
      if (refresh) {
        scheduler.refetchEvents();
      }
    },
    error: function (response) {
      alert(`Unable to update ${errorString}: Error ${response.status}: ${response.responseText}`);
    }
  });
}

function logTimeblock(id) {
  $.ajax({
    type: 'PATCH',
    url: jsPaths['tasks.log'].replace(':task', id),
    data: { _token: TOKEN },
    success: function (_data) {
      scheduler.refetchEvents();
    },
    error: function (response) {
      alert(`Unable to log Task: Error ${response.status}: ${response.responseText}`);
    }
  });
}

function destroyTimeblock(type, id) {
  const [destroyPath, errorString] = crudVars(type, 'destroy');

  $.ajax({
    type: 'DELETE',
    url: destroyPath.replace(`:${type}`, id),
    data: { _token: TOKEN },
    success: function (_data) {
      scheduler.refetchEvents();
    },
    error: function (response) {
      alert(`Unable to delete ${errorString}: Error ${response.status}: ${response.responseText}`);
    }
  });
}

if ($('#schedulerWrapper').length) {
  constructCalendar();
  constructDraggables();

  $('#timeblockDuration').on('change', function () {
    constructDraggables(true);
  });

  $('body').on('click', '.fc-log', function () {
    logTimeblock($(this).data('task-id'));
  });

  $('body').on('click', '.fc-remove', function () {
    const element = $(this);
    const type = element.hasClass('fc-remove-task') ? 'task' : 'occurrence';

    destroyTimeblock(type, element.data(`${type}-id`));
  });
}
