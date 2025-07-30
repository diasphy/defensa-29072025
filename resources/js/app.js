import '../css/app.css';
import './bootstrap';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, h } from 'vue';

// ***************************************************************
// ¡¡¡LÍNEA CLAVE CORREGIDA!!!
// Importa la función `route` como una EXPORTACIÓN NOMBRADA desde 'ziggy-js'.
// ***************************************************************
import { route } from 'ziggy-js'; // <-- ¡Cambio aquí!

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue'),
        ),
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) });

        app.use(plugin);

        // ***************************************************************
        // Hacemos que la función `route` y el objeto `Ziggy` (global)
        // estén disponibles en todos tus componentes Vue.
        // ***************************************************************
        app.config.globalProperties.$route = route; // Permite usar `this.$route('nombre.de.ruta')`
        app.config.globalProperties.$ziggy = Ziggy; // Permite acceder al objeto `Ziggy` global si lo necesitas

        app.mount(el);
        return app;
    },
    progress: {
        color: '#4B5563',
    },
});