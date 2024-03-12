<script>
    import { Link, page } from '@inertiajs/svelte';

    export let href = '';
    export let icon = '';
    export let label = '';

    $: console.log($page.url === href);

    $: menuClass = $page.url === href ? 'menu-item menu-active' : 'menu-item';
</script>

<Link {href} class={menuClass}>
    <i class={icon}></i>
    <span>{label}</span>
</Link>
