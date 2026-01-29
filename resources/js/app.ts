import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import type { DefineComponent } from 'vue';
import { createApp, h } from 'vue';
import '../css/app.css';
import { ZiggyVue } from 'ziggy-js';
import { route } from 'ziggy-js';
import { initializeTheme } from './composables/useAppearance';

declare global {
    var Ziggy: typeof route;
}

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => (title ? `${title} - ${appName}` : appName),
    resolve: (name) =>
        resolvePageComponent(
            `./pages/${name}.vue`,
            import.meta.glob<DefineComponent>('./pages/**/*.vue'),
        ),
    setup({ el, App, props, plugin }) {
            const app = createApp({ render: () => h(App, props) });
            app.use(plugin);
            app.use(ZiggyVue, (window as any).Ziggy);

            app.mount(el);
        },
        progress: {
            color: '#4B5563',
        },
});

// This will set light / dark mode on page load...
initializeTheme();
