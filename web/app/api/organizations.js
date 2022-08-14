import axios from '~/libs/axios';

export const getOrganizations = () => axios.get('/organizations');

export const getOrganization = (organization) => axios.get(`/organizations/${organization}`);

export const store = (organization) => axios.post(`/organizations`, organization);

export const update = (organization, data) => axios.put(`/organizations/${organization}`, data);

export const getUsers = (organization, params) => axios.get(`/organizations/${organization}/users`, {params});

export const inviteUser = (organization, params) => axios.post(`/organizations/${organization}/users`, params);

export const removeUser = (organization, permission) => axios.delete(`/organizations/${organization}/users/${permission}`);

export const updatePermissionUser = (permissionId, organization, params) => axios.put(`/organizations/${organization}/users/${permissionId}`, params);