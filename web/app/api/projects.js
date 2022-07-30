import axios from '~/libs/axios';

export const getProjects = (params) => axios.get('/projects', { params });

export const getProject = (organization, project) => axios.get(`/organizations/${organization}/projects/${project}`);

export const store = (organization, project) => axios.post(`/organizations/${organization}/projects`, project);

export const getUsers = (project, params) => axios.get(`/projects/${project}/users`, {params});

export const getCategories = (project) => axios.get(`/projects/${project}/categories`);


export const inviteUser = (project, params) => axios.post(`/projects/${project}/users`, params);

export const removeUser = (project, permission) => axios.delete(`/projects/${project}/users/${permission}`);

export const updatePermissionUser = (id, project, params) => axios.put(`/projects/${project}/users/${id}`, params);

export const update = (id, project) => axios.put(`/projects/${id}`, project);

export const getMonitors = (project, params) => axios.get(`/projects/${project}/monitors`, { params });

export const removeMonitor = (project, monitor) => axios.delete(`/projects/${project}/monitors/${monitor}`);

export const destroy = (project) => axios.delete(`/projects/${project}`);

export const getStatusPages = (project) => axios.get(`/projects/${project}/statusPages`);