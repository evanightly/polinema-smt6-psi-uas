<script>
    import { Link } from '@inertiajs/svelte';
    import DashboardDarkModeToggler from './DashboardDarkModeToggler.svelte';
    import DashboardNotification from './DashboardNotification.svelte';

    const handleLogout = () => {
        axios.post('/logout').then(() => {
            window.location.href = '/login';
        });
    };

    export let navbarTitle = '';
    export let showDataTitle = true;
</script>

<div class="navbar px-12 py-6">
    <div class="navbar-start">
        <div class="flex flex-col gap-5">
            <p class="text-base">Dashboard/{navbarTitle}</p>
            {#if showDataTitle}
                <p class="text-xl font-bold">Data {navbarTitle}</p>
            {/if}
        </div>
    </div>
    <div class="navbar-end h-fit">
        <div class="flex gap-3">
            <DashboardDarkModeToggler />
            <DashboardNotification />
        </div>
        <div class="divider divider-vertical h-10"></div>
        <div class="dropdown-container">
            <div class="dropdown">
                <button class="btn btn-ghost flex cursor-pointer px-0 gap-3" tabindex="0">
                    <img
                        src="https://i.pravatar.cc/150?u=a042581f4e29026024d"
                        alt="avatar"
                        class="avatar avatar-ring avatar-squared avatar-md"
                    />
                    <i class="ri-arrow-down-s-line"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-bottom-left">
                    <Link href="/account_settings" class="dropdown-item text-sm">Account settings</Link>
                    <Link href="/post_settings" class="dropdown-item text-sm">Settings</Link>
                    <button class="dropdown-item text-sm" on:click={handleLogout}>Logout</button>
                </div>
            </div>
        </div>
    </div>
</div>
