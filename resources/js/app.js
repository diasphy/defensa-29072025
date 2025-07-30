import '../css/app.css';
import './bootstrap';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, h } from 'vue';

// ***************************************************************
// CAMBIOS AQUÍ:
// 1. Eliminamos la importación incorrecta de '../../vendor/tightenco/ziggy'.
// 2. Importamos la función `route` directamente de 'ziggy-js'.
// ***************************************************************
import route from 'ziggy-js'; // Importa la función `route` desde el paquete instalado 'ziggy-js'

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
        // CAMBIOS AQUÍ:
        // No usamos `.use(ZiggyVue)` porque el paquete no existe.
        // En su lugar, hacemos que la función `route` de ziggy-js
        // y el objeto global `Ziggy` (de @routes) estén disponibles
        // globalmente en tus componentes Vue.
        // ***************************************************************
        app.config.globalProperties.$route = route; // Para usar `this.$route('my.route')` en tus componentes
        app.config.globalProperties.$ziggy = Ziggy; // El objeto `Ziggy` global (contiene todas las rutas)

        app.mount(el);
        return app;
    },
    progress: {
        color: '#4B5563',
    },
});