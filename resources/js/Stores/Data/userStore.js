import { createApiStore } from './createApiStore';

export const userStore = () => createApiStore('/api/users');
