import Message from 'element-ui/lib/message';
import _mapValues from 'lodash/mapValues';

export function collectServerError(errors) {
    return _mapValues(errors, '0');
}

export function handleError(error, statusHandlers = {}) {
    // Confirm dialog cancel/close
    if (error === false || error === 'close' || error === 'cancel') {
        return;
    }

    if (!error.response) {
        throw error;
    }

    const status = error.response.status;
    const handle = statusHandlers[status];

    if (handle) {
        handle(error);
    } else if (status === 419) {
        Message.error('Your session has expired, try reloading the page');
    } else if (error.response.data.message) {
        Message.error(error.response.data.message);
    } else {
        Message.error('Something went wrong, please try again later');
    }
}
