<script>
    import LoadingOverlay from '../Components/LoadingOverlay.svelte';

    export let title;
</script>

<svelte:head>
    <title>{title} - E-Canteen</title>
    <meta name="description" content="Dashboard" />
</svelte:head>

<div>
    <LoadingOverlay />
    <slot />
</div>
