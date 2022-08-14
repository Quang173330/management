import axios from '~/libs/axios';

export const getProjects = (params) => axios.get('/admin/projects', { params });

export const updateProject = (slug, project) => axios.put(`/admin/projects/${slug}`, project);

