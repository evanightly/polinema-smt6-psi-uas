import { createApiStore } from './createApiStore';

export const productStore = () =>
    createApiStore('api/products', [{ wsUrl: 'transaction-created', listenEvent: 'TransactionCreated' }]);
