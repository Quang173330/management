import axios from '~/libs/axios';

export const get = (project, params) => axios.get(`/projects/${project}/issues`, {params});

export const show = (project, issueId) => axios.get(`/projects/${project}/issues/${issueId}`);

export const store = (project, issue) => axios.post(`/projects/${project}/issues`, issue);

export const update = (project, issueId, data) => axios.put(`/projects/${project}/issues/${issueId}`, data);
