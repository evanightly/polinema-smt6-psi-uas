import { persisted } from 'svelte-persisted-store';
import { get } from 'svelte/store';

const darkMode = persisted('darkMode', false);

const changeHtmlTheme = () => {
    document.body.setAttribute('data-theme', get(darkMode) ? 'dark' : 'light');
};

const toggleDarkMode = () => {
    darkMode.set(!get(darkMode));
    changeHtmlTheme();
};

changeHtmlTheme();

export { darkMode, toggleDarkMode };
