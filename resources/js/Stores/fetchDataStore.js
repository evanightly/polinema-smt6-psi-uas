import { derived, writable } from 'svelte/store';
import axios from 'axios';
import loading from './loadingOverlayStore';

export function createFetchDataStore(initialUrl) {
    const url = writable(initialUrl);

    const store = derived(
        url,
        ($url, set) => {
            loading.start('Loading...');
            axios.get($url).then(({ data }) => {
                console.log(data);
                set(data);
                loading.stop();
            });
        },
        {},
    );

    return {
        subscribe: store.subscribe,
        setUrl: url.set,
    };
}
