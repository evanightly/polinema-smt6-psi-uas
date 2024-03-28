<script>
    import { Link, page } from '@inertiajs/svelte';

    export let href = '';
    export let icon = '';
    export let label = '';

    let menuClass;

    const isDashboard = () => href === '/' && $page.url === href;
    const isOtherPage = () => href !== '/' && $page.url.startsWith(href);

    if (isDashboard()) {
        menuClass = 'menu-item menu-active';
    } else if (isOtherPage()) {
        menuClass = 'menu-item menu-active';
    } else {
        menuClass = 'menu-item';
    }
</script>

<Link {href} class={menuClass}>
    <i class={icon}></i>
    <span>{label}</span>
</Link>
