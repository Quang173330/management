import _forEach from 'lodash/forEach';
import { logout } from '~/api/auth';
import { init } from '~/api/user';

export const state = () => ({
    user: null,
});

export const actions = {

    async init({ commit }) {
        const response = await init().then(({ data }) => data);

        commit('setUser', response.data);
    },

    async logout() {
        await logout();
        window.location.href = '/';
    },
};

export const mutations = {
    setUser(state, { user }) {
        state.user = user;
    },

    updateUser(state, data) {
        _forEach(data, (value, key) => {
            if (Object.prototype.hasOwnProperty.call(state, key)) {
                state[key] = value;
            }
        });
    },
};
