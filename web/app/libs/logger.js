export default class Logger {
    constructor({ scope = null, isDebug = false }) {
        this.scope = scope;
        this.isDebug = isDebug;
    }

    withScope(scope) {
        return new Logger({ scope, isDebug: this.isDebug });
    }

    print(level, ...args) {
        // eslint-disable-next-line no-console
    }

    debug(...args) {
        if (this.isDebug) {
            this.print('debug', ...args);
        }
    }
}
