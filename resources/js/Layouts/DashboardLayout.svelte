<script>
    import MainLayout from './MainLayout.svelte';
    import DashboardNavbar from './Partials/DashboardNavbar.svelte';
    import DashboardSidebar from './Partials/DashboardSidebar.svelte';

    export let title = 'Dashboard';
    export let navbarSubTitle = '';
    export let noPadding = false;
</script>

<MainLayout {title}>
    <div class="flex w-screen max-h-screen">
        <DashboardSidebar />
        <div class="flex flex-1 flex-col overflow-x-scroll">
            <DashboardNavbar navbarTitle={title} {navbarSubTitle} />
            <div class="overflow-y-auto {noPadding ? '' : 'px-12'}">
                <slot />
            </div>
        </div>
    </div>
</MainLayout>
