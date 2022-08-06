import axios from '~/libs/axios';

export const getUsers = (params) => axios.get('/admin/users', { params });

export const update = (id, user) => axios.put(`admin/users/${id}`, user);
