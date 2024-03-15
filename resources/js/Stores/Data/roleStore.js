import { createApiStore } from './createApiStore';

export const roleStore = () => createApiStore('/api/roles');
