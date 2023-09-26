/**
* We'll load the axios HTTP library which allows us to easily issue requests
* to our Laravel back-end. This library automatically handles sending the
* CSRF token as a header based on the value of the "XSRF" token cookie.
*/

import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import loadash from 'lodash';
window._ = loadash;

import * as Popper from '@popperjs/core';
window.Popper = Popper;

import 'bootstrap';

import $ from 'jquery';
window.$ = $;
window.jQuery = $;

import * as bootstrap from 'bootstrap';

const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]');
[...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl));

const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
[...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

const errorToggle = $('#errorContainer #toggleErrors');

errorToggle.on('click', function () {
  const errorList = $('#errorContainer #errorList');

  if(errorList.hasClass('hidden')) {
    errorToggle.html('<i class="fa-solid fa-eye-slash me-1"></i> Hide Errors');
    errorList.removeClass('hidden');
  } else {
    errorToggle.html('<i class="fa-solid fa-eye me-1"></i> Show Errors');
    errorList.addClass('hidden');
  }
});

$('.toggle-dropdown').on('click', function () {
  // -TODO- Convert to event listener to prevent icon disconnect
  $(this).find('.toggle-icon').toggleClass('fa-angle-down fa-angle-right');
});

$('body').on('change', 'input[type=checkbox]', function () {
  $(this).siblings('input[type=hidden]').val($(this).is(':checked') ? 1 : 0);
});

$('.external-link').on('mouseenter', function () {
  $(this).find('.external-link-a').removeClass('hidden');
}).on('mouseleave', function () {
  $(this).find('.external-link-a').addClass('hidden');
});

/**
* Echo exposes an expressive API for subscribing to channels and listening
* for events that are broadcast by Laravel. Echo and event broadcasting
* allows your team to easily build robust real-time web applications.
*/

// import Echo from 'laravel-echo';

// import Pusher from 'pusher-js';
// window.Pusher = Pusher;

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: import.meta.env.VITE_PUSHER_APP_KEY,
//     cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'mt1',
//     wsHost: import.meta.env.VITE_PUSHER_HOST ? import.meta.env.VITE_PUSHER_HOST : `ws-${import.meta.env.VITE_PUSHER_APP_CLUSTER}.pusher.com`,
//     wsPort: import.meta.env.VITE_PUSHER_PORT ?? 80,
//     wssPort: import.meta.env.VITE_PUSHER_PORT ?? 443,
//     forceTLS: (import.meta.env.VITE_PUSHER_SCHEME ?? 'https') === 'https',
//     enabledTransports: ['ws', 'wss'],
// });
