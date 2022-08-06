import _get from 'lodash/get';

export default ({ store, error }) => {
    if (!_get(store.state, 'auth.user.is_admin', false)) {
        error({ statusCode: 403 });
    }
};
