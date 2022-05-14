import _get from 'lodash/get';
import _memoize from 'lodash/memoize';
import { URLGenerator } from '~/utils/url';

export default ({ store }, inject) => {
    const getConfig = _memoize((name, defaultValue) => _get(store, `state.config.${name}`, defaultValue));

    inject('config', getConfig);

    inject('url', (...args) => {
        const baseURL = getConfig('app_url', 'http://localhost');
        const urlGenerator = new URLGenerator(baseURL);
        return urlGenerator.generate(...args);
    });
};
