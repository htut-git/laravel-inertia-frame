import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp, usePage } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import { createI18n } from 'vue-i18n';
import en_US from './locales/en.json';
import my_MM from './locales/mm.json';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';
const page = usePage();
const i18n = createI18n({
    locale:page.locale,
    legacy:false,
    fallbackLocale: 'en-US',
    messages:{
        'en-US':en_US,
        'my-MM':my_MM,
    }
})
createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(i18n)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
