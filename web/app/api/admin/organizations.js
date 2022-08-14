import axios from '~/libs/axios';

export const get = (params) => axios.get('/admin/organizations', { params });

export const update = (slug, organization) => axios.put(`/admin/organizations/${slug}`, organization);
