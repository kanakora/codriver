import { createInertiaApp } from '@inertiajs/vue3';
import createServer from '@inertiajs/vue3/server';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';

import { createSSRApp, h } from 'vue';
import { route, Ziggy } from 'ziggy-js';
import { renderToString } from 'vue/server-renderer';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createServer(
    (page) =>
        createInertiaApp({
            page,
            render: renderToString,
            title: (title) => (title ? `${title} - ${appName}` : appName),
            resolve: (name) =>
                resolvePageComponent(
                    `./pages/${name}.vue`,
                    import.meta.glob('./pages/**/*.vue'),
                ),
            setup: ({ App, props, plugin }) => {
                const app = createSSRApp({ render: () => h(App, props) });
                app.use(plugin);

                // Initialize Ziggy with the shared props
                if (props.initialPage.props.ziggy) {
                    Ziggy.default = props.initialPage.props.ziggy;
                }

                // Make route function available globally
                app.config.globalProperties.$route = route;

                return app;
            },
        }),
    { cluster: true },
);
