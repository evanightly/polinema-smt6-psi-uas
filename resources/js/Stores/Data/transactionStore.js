import { createApiStore } from './createApiStore';

export const transactionStore = () => createApiStore('/api/transactions');
