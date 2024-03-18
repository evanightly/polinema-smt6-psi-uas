import { writable } from 'svelte/store';

const loggedUserStore = writable([]);

const fetch = async () => {
    const response = await axios.get('/api/user');
    console.log(response);
    loggedUserStore.set(response.data);
};

export default {
    subscribe: loggedUserStore.subscribe,
    fetch,
};
