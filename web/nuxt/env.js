import {
    bool, cleanEnv, host, port, str,
} from 'envalid';

const validEnv = cleanEnv(process.env, {
    HOST: host({
        default: '0.0.0.0',
        desc: 'Application host. For development server only.',
    }),

    PORT: port({
        default: 3000,
        desc: 'Application port. For development server only.',
    }),

    APP_URL: str({
        default: '',
        desc: 'Application url. Used to generate absolute URL for static resources.',
    }),

    DEVTOOLS: bool({
        default: false,
        desc: 'Whether to enable Vue.js devtools. Only affect production build.',
    }),
}, {
    strict: true,
});

export const {
    HOST,
    PORT,
    APP_URL,
    DEVTOOLS,
    isDev,
    isProduction,
} = validEnv;
