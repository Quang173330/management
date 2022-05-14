import _get from 'lodash/get';

export default {
    name: 'BetaFeature',

    props: {
        allowAdmin: {
            type: Boolean,
            default: true,
        },
    },

    functional: true,

    render(h, { parent, props, slots }) {
        const isAdmin = _get(parent, '$store.state.auth.user.is_admin', false);

        return (props.allowAdmin && isAdmin) || parent.$config('app_env') !== 'production'
            ? slots().default
            : h(false);
    },
};
