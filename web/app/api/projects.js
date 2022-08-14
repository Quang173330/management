import axios from '~/libs/axios';

export const getProjects = (organization, params) => axios.get(`/organizations/${organization}/projects`, { params });

export const getProject = (organization, project) => axios.get(`/organizations/${organization}/projects/${project}`);

export const getHome = (organization, project) => axios.get(`/organizations/${organization}/projects/${project}/home`);

export const store = (organization, project) => axios.post(`/organizations/${organization}/projects`, project);

export const update = (organization, project, data) => axios.put(`/organizations/${organization}/projects/${project}`, data);

export const getUsers = (project, params) => axios.get(`/projects/${project}/users`, {params});

export const getCategories = (project) => axios.get(`/projects/${project}/categories`);

export const storeCategory = (project, category) => axios.post(`/projects/${project}/categories`, category);

export const updateCategory = (project, category, data) => axios.put(`projects/${project}/categories/${category}`, data);

export const inviteUser = (project, params) => axios.post(`/projects/${project}/users`, params);

export const removeUser = (project, permission) => axios.delete(`/projects/${project}/users/${permission}`);

export const updatePermissionUser = (id, project, params) => axios.put(`/projects/${project}/users/${id}`, params);


export const getMonitors = (project, params) => axios.get(`/projects/${project}/monitors`, { params });

export const removeMonitor = (project, monitor) => axios.delete(`/projects/${project}/monitors/${monitor}`);

export const destroy = (organization, project) => axios.delete(`/organizations/${organization}/projects/${project}`);

export const getStatusPages = (project) => axios.get(`/projects/${project}/statusPages`);