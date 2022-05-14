import Logger from '~/libs/logger';

export default ({ app }, inject) => {
    const defaultLogger = new Logger({
        isDebug: app.$config('app_debug', false),
    });

    inject('logger', defaultLogger);
};
