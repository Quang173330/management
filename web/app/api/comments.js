import axios from '~/libs/axios';

export const getComment = (project, issue, params) => axios.get(`/projects/${project}/issues/${issue}/comments`, {params});

export const storeComment = (project, issue, comment) => axios.post(`/projects/${project}/issues/${issue}/comments`, comment);
