import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.withCredentials = true;
window.axios.defaults.withXSRFToken = true;

// Global Error Interceptor
window.axios.interceptors.response.use(
    response => response,
    error => {
        const message = error.response?.data?.message || "Došlo je do greške, pokušajte ponovo";
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'error',
                title: 'Greška',
                text: message,
                confirmButtonColor: '#dd5454'
            });
        }
        return Promise.reject(error);
    }
);

// import Echo from "laravel-echo";
// import Pusher from "pusher-js";

// window.Pusher = Pusher;

// Pusher.logToConsole = true;

// window.Echo = new Echo({
//     broadcaster: "pusher",
//     key: import.meta.env.VITE_PUSHER_APP_KEY,
//     cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
//     forceTLS: true,
// });



/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allow your team to quickly build robust real-time web applications.
 */

// import './echo';
