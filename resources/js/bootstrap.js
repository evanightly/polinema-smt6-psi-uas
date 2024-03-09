/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import Swal from 'sweetalert2';
window.Swal = Swal;

import axios from 'axios';
window.axios = axios;

const formatErrorMessages = error => {
    console.log(error);

    const errorHtml = Object.values(error.response.data.errors)
        .map(errorArray =>
            errorArray
                .map(
                    error =>
                        `<div class="bg-error text-white rounded p-2">${error}</div>`,
                )
                .join(''),
        )
        .join('');

    return `
    <div class="flex flex-col gap-2">
        <p>${error.response.data.message}</p>
        ${errorHtml}
    </div>
    `;
};

const handleAxiosError = error => {
    // Skip interceptor (Bypass error handling)
    if (error.config.skipInterceptor) return Promise.reject(error);

    console.error('Hol up:', error);
    if (error.response.status >= 500) {
        const defaultAlertOptions = {
            icon: 'error',
            title: 'Oops...',
            text: error.response.data.message,
            confirmButtonText: 'On it!',
        };

        if (
            error.response.data.errors &&
            Object.keys(error.response.data.errors).length > 0
        ) {
            defaultAlertOptions.html = formatErrorMessages(error);
        }

        Swal.fire(defaultAlertOptions);
    } else if (error.response.status >= 401) {
        const defaultSwalOptions = {
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            icon: 'error',
            title: 'Hol up...',
            text: error.response.data.message,
            didOpen: toast => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            },
        };

        if (
            error.response.data.errors &&
            Object.keys(error.response.data.errors).length > 0
        ) {
            defaultSwalOptions.customClass = 'swal2-error-list';
            defaultSwalOptions.html = formatErrorMessages(error);
        }

        Swal.fire(defaultSwalOptions);
    }
    return Promise.reject(error);
};

window.axios.interceptors.response.use(response => response, handleAxiosError);
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

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
