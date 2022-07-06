import axios from '~/libs/axios';

export const get = (project) => axios.get(`/projects/${project}/issues`);

export const store = (project, issue) => axios.post(`/projects/${project}/issues`, issue);
