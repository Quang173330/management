import path from 'path';
import { ProvidePlugin, NormalModuleReplacementPlugin } from 'webpack';

import head from './nuxt/head';
import { finalizeRoutes as extendRoutes } from './nuxt/router';
import {
    HOST,
    PORT,
    DEVTOOLS,
    isDev,
    isProduction,
} from './nuxt/env';

export default {
    ssr: false,

    dev: isDev,

    srcDir: path.resolve(__dirname, 'app'),

    head,

    server: {
        host: HOST,
        port: PORT,
    },

    css: [
        'tippy.js/dist/tippy.css',
        'tippy.js/animations/shift-away-subtle.css',
        'tippy.js/themes/translucent.css',
        '~/assets/css/tailwind.css',
        '~/assets/scss/index.scss',
    ],

    loading: '~/components/Loading.vue',

    plugins: [
        '~/plugins/nuxt-client-init',
        '~/plugins/element-ui',
        '~/plugins/ionicon',
        '~/plugins/components',
        '~/plugins/directives',
        '~/plugins/filters',
        '~/plugins/config',
        '~/plugins/logger',
        '~/plugins/flash-messages',
        '~/plugins/sentry',
    ],

    router: {
        extendRoutes,
    },

    build: {
        plugins: [
            new NormalModuleReplacementPlugin(/element-ui[/\\]lib[/\\]locale[/\\]lang[/\\]zh-CN/, 'element-ui/lib/locale/lang/en'),

            new ProvidePlugin({
                io: 'socket.io-client',
            }),
        ],

        devtools: DEVTOOLS || isDev,
        extractCSS: isProduction,

        postcss: {
            preset: {
                features: {
                    // Fixes: https://github.com/tailwindcss/tailwindcss/issues/1190#issuecomment-546621554
                    'focus-within-pseudo-class': false,
                },
            },

            plugins: {
                tailwindcss: path.resolve(__dirname, './app/tailwind.config.js'),
            },
        },

        optimization: {
            runtimeChunk: 'single',
            splitChunks: {
                chunks: 'all',
                maxInitialRequests: Infinity,
                cacheGroups: {
                    vendor: {
                        test: /[\\/]node_modules[\\/]/,
                        name(module) {
                            return module.context.match(/([\\/])node_modules(\1@.+?)?\1(.+?)(\1|$)/)[3];
                        },
                    },
                },
            },
        },

        splitChunks: {
            commons: false,
        },
    },

    generate: {
        fallback: 'index.html',

        exclude: [/.+/],
    },
};
