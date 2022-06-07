import axios from '~/libs/axios';

export const getOrganizations = (params) => axios.get('/organizations', { params });

export const getOrganization = (organization) => axios.get(`/organizations/${organization}`);

