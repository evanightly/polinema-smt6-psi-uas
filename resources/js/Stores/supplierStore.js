import { writable } from 'svelte/store';
import axios from 'axios';
import { debounce } from 'lodash';

const createSupplierStore = () => {
    const { subscribe, set, update } = writable({ data: [], meta: {} });

    return {
        subscribe,
        search: debounce(async searchTerm => {
            const { data: response } = await axios.get(`/api/suppliers?search=${searchTerm}`);
            set(response);
        }, 300),
    };
};

export const supplierStore = createSupplierStore();
