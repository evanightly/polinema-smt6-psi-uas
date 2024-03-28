<script>
    import DashboardLayout from '../../Layouts/DashboardLayout.svelte';
    import { showAlert } from '@/Helpers/showAlert';
    import loading from '@/Stores/Utility/loadingOverlayStore';
    import { selectedNotificationStore } from '@/Stores/Data/selectedNotificationStore';
    import { showConfirmDialog, showDeclinedDialog, showDialog } from '../../Helpers/showDialog';
    import axios from 'axios';
    import { router } from '@inertiajs/svelte';

    let notification;
    let message = '';

    const fetchProduct = id => {
        if (!id) return;
        try {
            axios.get(`/api/notifications/${id}`).then(response => {
                notification = response.data;
                console.log(notification);
            });
        } catch (error) {
        } finally {
            loading.stop();
        }
    };

    $: {
        fetchProduct($selectedNotificationStore);
    }

    const title = 'Products/Restock Info';
    const navbarSubTitle = 'Restock Info';

    async function copyToClipboard() {
        try {
            await navigator.clipboard.writeText(message);
            showAlert('Copied to clipboard', '', 'info', false);
        } catch (err) {
            console.error('Failed to copy text: ', err);
        }
    }

    async function handleMarkAsFinish() {
        const result = await showConfirmDialog({
            title: 'Mark as finish',
            text: 'Are you sure you want to mark this product as finish?, the notification will be deleted',
        });
        if (result.isConfirmed) {
            try {
                loading.start('Marking as finish...');
                axios
                    .post(`/api/notifications/mark-as-finish`, {
                        product_id: notification.data.product_id,
                        supplier_id: notification.data.supplier_id,
                        created_at: notification.created_at,
                    })
                    .then(response => {
                        showAlert('Success', response.data.message, 'success', false);

                        showConfirmDialog({
                            title: 'Attention',
                            text: 'You have to update the stock manually after marking as finish',
                            confirmButtonText: 'Update stock',
                            showCancelButton: false,
                        });

                        // User needs to update stock after marking as finish
                        router.visit(`/products/${notification.data.product_id}/edit`);
                    })
                    .catch(error => {
                        showAlert('Failed to mark as finish', error.response.data.message, 'error', false);
                    });
            } catch (error) {
                showAlert('Failed to mark as finish', error.response.data.message, 'error', false);
            } finally {
                loading.stop();
            }
        } else {
            showDeclinedDialog();
        }
    }
</script>

<DashboardLayout {title} {navbarSubTitle}>
    <div class="mt-5">
        {#if notification}
            <div class="flex mt-4">
                <div class="flex flex-col w-full items-center">
                    <div class="p-5 rounded bg-backgroundSecondary space-y-4">
                        <div class="grid grid-cols-2 gap-4 text-base">
                            <div class="flex flex-col items-start">
                                <h2 class="text-2xl mb-4">Product Information</h2>
                                <img
                                    src={notification.product.image}
                                    alt={notification.product.name}
                                    class="h-44 object-contain"
                                />
                                <div class="grid grid-cols-2 gap-x-8 text-base mt-4">
                                    <span>Name</span>
                                    <span>{notification.product.name}</span>
                                    <span>Price</span>
                                    <span>{notification.product.price}</span>
                                    <span>Stock</span>
                                    <span>{notification.product.stock}</span>
                                    <span>Min Stock</span>
                                    <span>{notification.product.min_stock}</span>
                                    <span>Max Stock</span>
                                    <span>{notification.product.max_stock}</span>
                                    <span>Restock Threshold</span>
                                    <span>{notification.product.restock_threshold} %</span>
                                </div>
                            </div>
                            <div class="flex flex-col gap-5">
                                <div>
                                    <h2 class="text-2xl mb-4">Supplier Information</h2>
                                    <div class="grid grid-cols-2 text-base">
                                        <span>Name</span>
                                        <span>{notification.supplier.name}</span>
                                        <span>Email</span>
                                        <span>{notification.supplier.email}</span>
                                        <span>Phone</span>
                                        <span>{notification.supplier.phone}</span>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between items-center mb-4">
                                        <h2 class="text-2xl">Send Message</h2>
                                        <button type="button" on:click={copyToClipboard}>
                                            <i class="ri-file-copy-line"></i>
                                        </button>
                                    </div>
                                    <div>
                                        <div class="flex flex-1 flex-col gap-4">
                                            <textarea
                                                class="textarea textarea-bordered textarea-block"
                                                rows="5"
                                                placeholder="Type your message here..."
                                                bind:value={message}
                                            ></textarea>
                                            <a
                                                href="https://wa.me/{notification.supplier
                                                    .phone}?text={encodeURIComponent(message)}"
                                                target="_blank"
                                                class="btn btn-success btn-block gap-2"
                                            >
                                                <i class="ri-whatsapp-fill text-3xl"></i>
                                                <span>Go to Chat</span>
                                            </a>
                                            <button class="btn btn-primary" on:click={handleMarkAsFinish}>
                                                Mark As Finish
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        {:else}
            You need to select a product in notification to continue.
        {/if}
    </div>
</DashboardLayout>
