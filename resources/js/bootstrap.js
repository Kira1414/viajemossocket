window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
} catch (e) {}

require('datatables.net');
require('datatables.net-colreorder')
require('datatables.net-colreorder-bs4')
require('datatables.net-buttons-bs4');
require('datatables.net-fixedcolumns');
require('datatables.net-buttons/js/buttons.colVis.js');
require('datatables.net-buttons/js/buttons.html5.js');

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');
//window.moment = require('moment')
/* console.log(window.Laravel)
console.log(window.apiToken) */
if(window.Laravel != undefined && window.apiToken != undefined)
{

    window.axios.defaults.headers.common = {
        'X-CSRF-TOKEN': window.Laravel.csrfToken,
        'X-Requested-With': 'XMLHttpRequest',
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        'Authorization': `Bearer ${window.apiToken}`
    };
    
    $.ajaxSetup( {
        headers: {
            'X-CSRF-TOKEN': window.Laravel.csrfToken,
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${window.apiToken}`
        }
    } );
}

window.axios.defaults.headers.common.crossDomain = true;

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

import Echo from 'laravel-echo';

window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    encrypted: false
});

window.pusher = new Pusher(`${process.env.MIX_PUSHER_APP_KEY}`, {
    cluster: `${process.env.MIX_PUSHER_APP_CLUSTER}`,
    encrypted: false
});


/* window.Echo.connector.socket.on('connect_error', () => {
    window.Echo.disconnect();
}); */

/*window.Echo.connector.socket.on('connect', () => {
    window.Echo.channel('notification')
    .listen('.Logistic\\Events\\NotificationEvent', function() {
        loadMynotificationsAlarms()
    });
});
 */