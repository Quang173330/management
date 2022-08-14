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
                        config, messages, extras, organization, projects, ...authUser
                    },
                },
            } = await axios.get('/web-init');
            commit('setConfig', config);
            commit('setMessages', messages);
            commit('auth/setUser', authUser);
            if(authUser.user && organization) {
                const {data: {data: project} } = await axios.get(`/organizations/${organization.slug}/projects/${projects[0].slug}`)
                commit('organization/setOrganization', organization);
                commit('projects/setProjects', projects);
                commit('project/setProject', project);
            }
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
