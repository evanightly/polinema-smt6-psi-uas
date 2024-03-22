import { writable } from 'svelte/store';

const loggedUserStore = writable([]);

const fetch = async () => {
    const response = await axios.get('/api/user');
    loggedUserStore.set(response.data);
};

const listenForProductRestockUpdates = () => {
    Echo.channel('product-needs-restock').listen('ProductNeedsRestockEvent', async e => {
        fetch();
    });
};

export default {
    subscribe: loggedUserStore.subscribe,
    fetch,
    listenForProductRestockUpdates,
};
