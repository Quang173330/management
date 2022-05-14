import axios from '~/libs/axios';

export const logout = () => axios.post('/logout');
