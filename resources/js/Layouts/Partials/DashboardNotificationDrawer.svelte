<script>
    import loggedUserStore from '@/Stores/Data/loggedUserStore';
    import { onMount } from 'svelte';
    import { selectedNotificationStore } from '@/Stores/Data/selectedNotificationStore';
    import { router } from '@inertiajs/svelte';

    onMount(() => {
        loggedUserStore.fetch();
        loggedUserStore.listenForProductRestockUpdates();
    });

    function handleChangeNotification(id) {
        $selectedNotificationStore = id;
        router.visit(`/products/restock`);
    }
</script>

<input type="checkbox" id="drawer-right" class="drawer-toggle" />

<div class="w-fit relative">
    <label for="drawer-right" class="btn avatar avatar-ring avatar-squared">
        <i class="ri-notification-line"></i>
    </label>
    {#if $loggedUserStore?.unread_notifications?.length > 0}
        <span class="absolute top-0 right-0 badge badge-error -translate-y-1/2 translate-x-1/2">
            {$loggedUserStore.unread_notifications.length}
        </span>
    {/if}
</div>

<label class="overlay" for="drawer-right"></label>
<div class="drawer drawer-right">
    <div class="drawer-content pt-10 flex flex-col h-full">
        <label for="drawer-right" class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</label>
        <div class="flex flex-col flex-1">
            <h2 class="text-xl font-medium">Notifications</h2>
            <div class="flex flex-col flex-1 overflow-y-auto space-y-6 mt-4">
                {#each $loggedUserStore?.unread_notifications ?? [] as notification}
                    <div class="flex gap-2 rounded-lg shadow p-3 relative group">
                        <img
                            src={notification.data.product_image}
                            alt={notification.data.product_name}
                            class="avatar avatar-ring avatar-squared avatar-md self-center"
                        />

                        <div class="flex flex-1 flex-col ml-1">
                            <p class="text-lg font-semibold">{notification.data.product_name}</p>
                            <p>Status: <span class="text-orange-500">{notification.data.message}</span></p>
                        </div>

                        <button
                            on:click={() => handleChangeNotification(notification.id)}
                            class="btn btn-info absolute top-0 left-0 w-full h-0 group-hover:h-full transition-all transition-duration-300 ease-in-out opacity-0 group-hover:opacity-100 bg-gradient-to-br from-emerald-600 to-emerald-200 text-lg"
                        >
                            Find Out
                        </button>
                    </div>
                {/each}
            </div>
        </div>
    </div>
</div>
