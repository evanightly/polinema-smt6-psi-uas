import { writable } from 'svelte/store';

const { subscribe, set } = writable({ isLoading: false, message: '' });

const loading = {
    subscribe,
    start: (msg = '') => set({ isLoading: true, message: msg }),
    stop: () => set({ isLoading: false, message: '' }),
};

export default loading;
