import { createApiStore } from './createApiStore';

export const supplierStore = () => createApiStore('/api/suppliers');
