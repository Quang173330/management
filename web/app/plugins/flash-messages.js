import _get from 'lodash/get';
import { Message } from 'element-ui';

export default (ctx) => {
    const { store } = ctx;
    const messages = _get(store.state, 'messages', []);

    messages.map((message) => Message({
        type: message.type,
        message: message.message,
    }));
};
