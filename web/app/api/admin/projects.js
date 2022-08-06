import axios from '~/libs/axios';

export const getProjects = (params) => axios.get('/admin/projects', { params });

export const updateProject = (id, project) => axios.put(`/admin/projects/${id}`, project);

export const updateMonitor = (project, monitorId, monitor) => axios.put(`admin/projects/${project}/monitors/${monitorId}`, monitor);
