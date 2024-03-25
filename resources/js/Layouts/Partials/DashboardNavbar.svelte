<script>
    import { Link, inertia, page } from '@inertiajs/svelte';
    import DashboardDarkModeToggler from './DashboardDarkModeToggler.svelte';
    import logout from '../../Helpers/logout';
    import DashboardNotificationDrawer from './DashboardNotificationDrawer.svelte';

    export let navbarTitle = '';
    export let navbarSubTitle = '';

    let userImage = $page.props.user.image;
</script>

<div class="navbar px-12 py-6">
    <div class="navbar-start">
        <div class="flex flex-col gap-5">
            <p class="text-base">Dashboard/{navbarTitle}</p>
            {#if navbarSubTitle}
                <p class="text-xl font-bold">{navbarSubTitle}</p>
            {/if}
        </div>
    </div>
    <div class="navbar-end h-fit">
        <div class="flex gap-3">
            <DashboardDarkModeToggler />
            <DashboardNotificationDrawer />
        </div>
        <div class="divider divider-vertical h-10"></div>
        <div class="dropdown-container">
            <div class="dropdown">
                <button class="btn btn-ghost flex cursor-pointer px-0 gap-3" tabindex="0">
                    <img
                        src={userImage}
                        alt="avatar"
                        class="avatar avatar-ring avatar-squared avatar-md object-cover"
                    />
                    <i class="ri-arrow-down-s-line"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-bottom-left">
                    <a href="/user-profile" use:inertia class="dropdown-item text-sm">Account settings</a>
                    <a href="/settings" use:inertia class="dropdown-item text-sm">Settings</a>
                    <button class="dropdown-item text-sm" on:click={logout}>Logout</button>
                </div>
            </div>
        </div>
    </div>
</div>
