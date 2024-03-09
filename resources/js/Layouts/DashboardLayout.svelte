<script>
    import MainLayout from './MainLayout.svelte';
    import DashboardNavbar from './Partials/DashboardNavbar.svelte';
    import DashboardSidebar from './Partials/DashboardSidebar.svelte';
</script>

<MainLayout>
    <div class="flex w-screen max-h-screen">
        <DashboardSidebar />
        <div class="flex flex-1 flex-col">
            <DashboardNavbar />
            <div class="overflow-y-auto">
                <div class="px-12">
                    <slot />
                </div>
            </div>
        </div>
    </div>
</MainLayout>
