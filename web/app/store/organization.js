import { getOrganizations } from '~/api/organizations';

export const state = () => ({
    organization: null,
});

export const actions = {

    async get({ commit }) {
        const { data: { data } } = await getOrganizations();
        commit('setOrganization', data);
    },
};

export const mutations = {
    setOrganization(state, organization) {
        state.organization = organization;
    },
};
