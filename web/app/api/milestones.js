import axios from '~/libs/axios';

export const get = (project) => axios.get(`/projects/${project}/milestones`);

export const store = (project, milestone) => axios.post(`/projects/${project}/milestones`, milestone);
