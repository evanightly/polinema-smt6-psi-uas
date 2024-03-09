import './bootstrap';
import 'remixicon/fonts/remixicon.css';
import 'spinkit/spinkit.min.css';
import { createInertiaApp } from '@inertiajs/svelte';

createInertiaApp({
    title: title => `${title} - E - Canteen`,
    resolve: name => {
        const pages = import.meta.glob('./Pages/**/*.svelte', { eager: true });
        return pages[`./Pages/${name}.svelte`];
    },
    setup({ el, App }) {
        new App({ target: el });
    },
});
