import { persisted } from 'svelte-persisted-store';
import { showAlert } from '../../Helpers/showAlert';
// Initial state
const initialState = {
    items: [],
    total: 0,
};

const cartStore = persisted('cart', initialState);

function addItem(item) {
    cartStore.update(state => {
        // Check if the item is already in the cart
        const existingItem = state.items.find(i => i.id === item.id);

        // If the item is already in the cart and its quantity is less than the maximum, increase its quantity
        if (existingItem && existingItem.quantity < existingItem.maxQuantity) {
            existingItem.quantity++;
            state.total += item.price;
            state.total = Math.round(state.total * 100) / 100; // Round to two decimal places
        } else if (!existingItem) {
            // Otherwise, if the item is not in the cart, add it to the cart with a quantity of 1
            state.items.push({ ...item, quantity: 1 });
            state.total += item.price;
            state.total = Math.round(state.total * 100) / 100; // Round to two decimal places
        } else {
            showAlert("Can't Do", 'The maximum quantity for this item has been reached');
        }

        return state;
    });
}

function removeItem(itemId) {
    cartStore.update(state => {
        // Find the index of the item in the items array
        const index = state.items.findIndex(item => item.id === itemId);

        // If the item was found, remove it from the items array and update the total
        if (index !== -1) {
            const item = state.items[index];
            state.total -= item.price * item.quantity;
            state.items.splice(index, 1);
            state.total = Math.round(state.total * 100) / 100; // Round to two decimal places
        }

        return state;
    });
}

function increaseQuantity(itemId) {
    cartStore.update(state => {
        // Find the item in the cart
        const item = state.items.find(i => i.id === itemId);

        // If the item was found and its quantity is less than the maximum, increase its quantity and update the total
        if (item && item.quantity < item.maxQuantity) {
            item.quantity++;
            state.total += item.price;
            state.total = Math.round(state.total * 100) / 100; // Round to two decimal places
        } else {
            showAlert("Can't Do", 'The maximum quantity for this item has been reached');
        }

        return state;
    });
}

function decreaseQuantity(itemId) {
    cartStore.update(state => {
        // Find the item in the cart
        const item = state.items.find(i => i.id === itemId);

        // If the item was found, decrease its quantity and update the total
        if (item) {
            item.quantity--;
            state.total -= item.price;
            state.total = Math.round(state.total * 100) / 100; // Round to two decimal places

            // If the quantity is 0, remove the item from the cart
            if (item.quantity === 0) {
                state.items = state.items.filter(i => i.id !== itemId);
            }
        }

        return state;
    });
}

export { cartStore, addItem, removeItem, increaseQuantity, decreaseQuantity };
