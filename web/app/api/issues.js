import axios from '~/libs/axios';

export const get = (project, params) => axios.get(`/projects/${project}/issues`, {params});

export const store = (project, issue) => axios.post(`/projects/${project}/issues`, issue);

export const update = (project, issue) => axios.put(`/projects/${project}/issues/${issue.id}`, issue);
