import _concat from 'lodash/concat';
import _filter from 'lodash/filter';
import { getProjects } from '~/api/projects';
import * as listUtils from '~/utils/list';

export const state = () => ({
    projects: [],
    project: null
});

export const actions = {

    async get({ commit }) {
        const { data: { data } } = await getProjects();

        commit('setProjects', data);
    },
};

export const mutations = {
    setProject(state, project) {
        state.project = project;
    },

    setProjects(state, projects) {
        state.projects = projects;
    },

    addProject(state, project) {
        state.projects = _concat(state.projects, project);
    },

    updateProject(state, project) {
        state.projects = listUtils.put(state.projects, project);
    },

    removeProject(state, project) {
        state.projects = _filter(state.projects, (currentProject) => currentProject.id !== project.id);
    },
};
