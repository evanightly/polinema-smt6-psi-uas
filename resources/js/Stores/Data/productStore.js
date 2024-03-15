import { createApiStore } from './createApiStore';

export const productStore = () => createApiStore('/api/products');
