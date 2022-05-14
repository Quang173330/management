import Vue from 'vue';
import * as Sentry from '@sentry/vue';
import { Integrations } from '@sentry/tracing';

export default ({ app }) => {
    window.onNuxtReady(() => {
        const dsn = app.$config('sentry.dsn');
        const environment = app.$config('sentry.environment');
        const tracesSampleRate = app.$config('sentry.traces_sample_rate');
        const trackComponents = app.$config('sentry.track_components');

        if (dsn) {
            Sentry.init({
                Vue,
                dsn,
                environment,
                integrations: [
                    new Integrations.BrowserTracing({
                        routingInstrumentation: Sentry.vueRouterInstrumentation(window.$nuxt.$router),
                    }),
                ],
                trackComponents,
                hooks: ['mount', 'update'],
                tracesSampleRate,
            });
        }
    });
};
