import axios from '~/libs/axios';

export const getProjects = (params) => axios.get('/projects', { params });

export const getProject = (organization, project) => axios.get(`/organizations/${organization}/projects/${project}`);

export const store = (organization, project) => axios.post(`/organizations/${organization}/projects`, project);
