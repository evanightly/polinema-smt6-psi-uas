import { persisted } from 'svelte-persisted-store';
import { get } from 'svelte/store';

const defaultViewMode = 'table';
const dataViewMode = persisted('dataViewMode', defaultViewMode);

const toggleViewMode = () => {
    dataViewMode.set(get(dataViewMode) === 'table' ? 'card' : 'table');
};

export { dataViewMode, toggleViewMode };
