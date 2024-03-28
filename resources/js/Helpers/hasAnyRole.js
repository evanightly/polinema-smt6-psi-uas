import { page } from '@inertiajs/svelte';
import { get } from 'svelte/store';

export const hasAnyRole = (...roles) => roles.some(role => get(page).props[role]);
