<script>
    import { Link } from '@inertiajs/svelte';
    import { isSidebarMobileFixed } from '../../Stores/sidebarStore.js';
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
                    <Link href="/" class="menu-item">
                        <i class="ri-home-4-line"></i>
                        <span>Dashboard</span>
                    </Link>
                    <Link href="/staffs" class="menu-item">
                        <i class="ri-user-2-line"></i>
                        <span>Staff</span>
                    </Link>
                    <Link href="/suppliers" class="menu-item">
                        <i class="ri-truck-line"></i>
                        <span>Suppliers</span>
                    </Link>
                    <Link href="/products" class="menu-item">
                        <i class="ri-archive-2-line"></i>
                        <span>Products</span>
                    </Link>
                    <Link href="/transactions" class="menu-item">
                        <i class="ri-shake-hands-line"></i>
                        <span>Transactions</span>
                    </Link>
                </ul>
            </section>
            <div class="divider mt-auto"></div>
            <section class="menu-section px-4">
                <span class="menu-title">Settings</span>
                <ul class="menu-items">
                    <li class="menu-item">
                        <i class="ri-user-line"></i>
                        <span>Profile</span>
                    </li>
                    <li class="menu-item">
                        <i class="ri-settings-3-line"></i>
                        <span>Settings</span>
                    </li>
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
