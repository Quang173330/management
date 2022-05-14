import _forEach from 'lodash/forEach';
import axios from '~/libs/axios';

export const state = () => ({
    initError: null,
    config: {},
    messages: [],
});

export const actions = {
    async nuxtClientInit({ commit, dispatch }) {
        try {
            const {
                data: {
                    data: {
                        config, messages, extras, ...authUser
                    },
                },
            } = await axios.get('/web-init');

            commit('setConfig', config);
            commit('setMessages', messages);
            commit('auth/setUser', authUser);

            _forEach(extras, (payload, action) => dispatch(action, payload));
        } catch (error) {
            commit('setError', error);
            throw error;
        }
    },
};

export const mutations = {
    setError(state, error) {
        state.initError = error;
    },

    setConfig(state, config) {
        state.config = config;
    },

    setMessages(state, messages) {
        state.messages = messages;
    },
};
