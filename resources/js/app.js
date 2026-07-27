// import './bootstrap';
import '../css/all.css';
import '../../public/dashboard-assets/js/main.js';

import { createApp, h } from 'vue';
import { createInertiaApp, router } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';

const appName =
    import.meta.env.VITE_APP_NAME || 'Laravel';

router.on('navigate', (event) => {
    const locale = event.detail.page.props.locale;
    document.body.classList.toggle('rtl', locale === 'ar');
});

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`,
        import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});