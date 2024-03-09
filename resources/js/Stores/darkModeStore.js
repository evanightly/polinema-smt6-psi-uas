import jquery from 'jquery';
import { persisted } from 'svelte-persisted-store';
import { get } from 'svelte/store';

const darkMode = persisted('darkMode', false);

const changeHtmlTheme = () => {
    jquery('body').attr('data-theme', get(darkMode) ? 'dark' : 'light');
};

const toggleDarkMode = () => {
    darkMode.set(!get(darkMode));
    changeHtmlTheme();
};

changeHtmlTheme();

export { darkMode, toggleDarkMode };
