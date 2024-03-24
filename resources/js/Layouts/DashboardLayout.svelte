<script>
    import { router } from '@inertiajs/svelte';
    import MainLayout from './MainLayout.svelte';
    import DashboardNavbar from './Partials/DashboardNavbar.svelte';
    import DashboardSidebar from './Partials/DashboardSidebar.svelte';
    import { onMount } from 'svelte';
    import logout from '@/Helpers/logout';
    import { showDialog } from '@/Helpers/showDialog';

    export let title = 'Dashboard';
    export let navbarSubTitle = '';
    export let noPadding = false;

    onMount(async () => {
        // if no session of api_token redirect to login page
        if (!sessionStorage.getItem('api_token')) {
            await showDialog({
                title: 'Session Expired',
                text: 'Please login again to continue.',
            });
            logout();
        }
    });
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
