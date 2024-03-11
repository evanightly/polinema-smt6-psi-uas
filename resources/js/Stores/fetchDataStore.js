import { derived, writable } from 'svelte/store';
import axios from 'axios';
import loading from './loadingOverlayStore';

export function createFetchDataStore(initialUrl) {
    const url = writable(initialUrl);

    const fetchData = async url => {
        const response = await axios.get(url);
        return response.data;
    };

    const store = derived(
        url,
        async ($url, set) => {
            const data = await fetchData($url);
            set(data);
        },
        {},
    );

    return {
        subscribe: store.subscribe,
        setUrl: url.set,
        fetchData,
    };
}
