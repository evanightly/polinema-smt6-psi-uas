import { writable } from 'svelte/store';
import axios from 'axios';

export function createApiStore(url, wsConfigs = [], onMessage = function (e) {}) {
    // const DEFAULT_DEBOUNCE_TIME = 300;

    const { subscribe, set, update: updateStore } = writable({});

    // const debouncedFetch = debounce(async (options = {}) => {
    //     const { data } = await axios.get(url, options);
    //     set(data);
    // }, DEFAULT_DEBOUNCE_TIME);

    async function fetch(options = {}) {
        const response = await axios.get(url, options);
        console.log(options, response);
        set(response.data);
    }

    wsConfigs.forEach(({ wsUrl, listenEvent }, i) => {
        window.Echo.channel(wsUrl).listen(listenEvent, async e => {
            console.log('Event', e);
            onMessage(e);
            await fetch();
        });
    });

    return {
        subscribe,
        fetch,
        delete: async id => {
            await axios.delete(`${url}/${id}`);
            updateStore(response => {
                return {
                    ...response,
                    data: response.data.filter(item => item.id !== id),
                };
            });
        },
        create: async item => {
            const { data } = await axios.post(url, item);
            updateStore(response => {
                return {
                    ...response,
                    data: [...response.data, data],
                };
            });
        },
        update: async (id, item) => {
            const { data } = await axios.put(`${url}/${id}`, item);
            updateStore(response => {
                return {
                    ...response,
                    data: response.data.map(i => (i.id === id ? data : i)),
                };
            });
        },
    };
}
