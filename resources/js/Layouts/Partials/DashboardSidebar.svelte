<script>
    import { isSidebarMobileFixed } from '@/Stores/Utility/sidebarStore.js';
    import DashboardSidebarMenuItem from './Components/DashboardSidebarMenuItem.svelte';
    import logout from '@/Helpers/logout.js';
    import { hasAnyRole } from '@/Helpers/hasAnyRole.js';
    import { inertia } from '@inertiajs/svelte';
</script>

<input type="checkbox" id="sidebar-mobile-fixed" class="dashboard sidebar-state" bind:checked={$isSidebarMobileFixed} />
<!-- <aside
    class="dashboard sidebar sidebar-fixed-left sidebar-mobile h-full justify-start max-sm:fixed max-sm:-translate-x-full"
> -->
<aside class="dashboard sidebar min-h-screen sidebar-mobile h-full justify-start max-sm:fixed max-sm:-translate-x-full">
    <section class="sidebar-title items-center p-4 relative">
        <div class="flex gap-2 text-primary text-xl px-4">
            <i class="ri-restaurant-fill"></i>
            <span>E-Canteen</span>
        </div>
        <div class="absolute top-1/2 right-0 -translate-y-1/2 translate-x-1/2">
            <label for="sidebar-mobile-fixed" class="btn btn-primary btn-circle font-bold">
                {#if $isSidebarMobileFixed}
                    <i class="ri-arrow-right-s-line"></i>
                {:else}
                    <i class="ri-arrow-left-s-line"></i>
                {/if}
            </label>
        </div>
    </section>
    <section class="sidebar-content flex flex-1">
        <nav class="menu flex-1 rounded-md justify-between">
            <section class="menu-section px-4">
                <span class="menu-title">Main menu</span>
                <ul class="menu-items">
                    <DashboardSidebarMenuItem href="/" icon="ri-home-4-line" label="Dashboard" />
                    {#if hasAnyRole('isStaff', 'isSuperAdmin', 'isManager')}
                        <DashboardSidebarMenuItem href="/suppliers" icon="ri-truck-line" label="Suppliers" />
                    {/if}

                    {#if hasAnyRole('isSuperAdmin', 'isManager')}
                        <DashboardSidebarMenuItem href="/roles" icon="ri-shield-keyhole-line" label="Roles" />
                        <DashboardSidebarMenuItem href="/users" icon="ri-user-2-line" label="Staff" />
                    {/if}

                    {#if hasAnyRole('isStaff')}
                        <DashboardSidebarMenuItem href="/products" icon="ri-archive-2-line" label="Products" />
                        <DashboardSidebarMenuItem
                            href="/transactions"
                            icon="ri-shake-hands-line"
                            label="Transactions"
                        />
                        <DashboardSidebarMenuItem href="/pos" icon="ri-shopping-cart-line" label="Point of Sale" />
                    {/if}
                </ul>
            </section>
            <div class="divider mt-auto"></div>
            <section class="menu-section px-4">
                <span class="menu-title">Settings</span>
                <ul class="menu-items">
                    <a href="/user-profile" use:inertia class="menu-item">
                        <i class="ri-user-line"></i>
                        <span>Profile</span>
                    </a>
                    <a href="/settings" use:inertia class="menu-item">
                        <i class="ri-settings-3-line"></i>
                        <span>Settings</span>
                    </a>
                    <button class="menu-item" on:click={logout}>
                        <i class="ri-door-line"></i>
                        <span>Logout</span>
                    </button>
                </ul>
            </section>
        </nav>
    </section>
    <!-- <section class="sidebar-footer justify-end bg-gray-2 pt-2">
            <div class="divider my-0"></div>
            <div
                class="dropdown z-50 flex h-fit w-full cursor-pointer hover:bg-gray-4"
            >
                <label
                    class="whites mx-2 flex h-fit w-full cursor-pointer p-0 hover:bg-gray-4"
                    tabindex="0"
                >
                    <div class="flex flex-row gap-4 p-4">
                        <div class="avatar-square avatar avatar-md">
                            <img
                                src="https://i.pravatar.cc/150?img=30"
                                alt="avatar"
                            />
                        </div>

                        <div class="flex flex-col">
                            <span>Sandra Marx</span>
                        </div>
                    </div>
                </label>
                <div class="dropdown-menu-right-top dropdown-menu ml-2">
                    <a class="dropdown-item text-sm">Profile</a>
                    <a tabindex="-1" class="dropdown-item text-sm"
                        >Account settings</a
                    >
                    <a tabindex="-1" class="dropdown-item text-sm"
                        >Change email</a
                    >
                    <a tabindex="-1" class="dropdown-item text-sm"
                        >Subscriptions</a
                    >
                    <a tabindex="-1" class="dropdown-item text-sm"
                        >Change password</a
                    >
                    <a tabindex="-1" class="dropdown-item text-sm"
                        >Refer a friend</a
                    >
                    <a tabindex="-1" class="dropdown-item text-sm">Settings</a>
                </div>
            </div>
        </section> -->
</aside>
