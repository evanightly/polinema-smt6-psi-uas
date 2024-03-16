<!-- NOT RESPONSIVE YET, MIGHT IMPLEMENT MODAL IN CHECKOUT COMPONENT -->
<script>
    import DashboardLayout from '@/Layouts/DashboardLayout.svelte';
    import { productStore } from '@/Stores/Data/productStore.js';
    import { debounce } from 'lodash';
    import loading from '../Stores/Utility/loadingOverlayStore';
    import Pagination from '../Components/Pagination.svelte';
    import { showConfirmDialog, showDeclinedDialog, showErrorDialog, showSuccessDialog } from '../Helpers/showDialog';
    import {
        cartStore,
        addItem,
        removeItem,
        increaseQuantity,
        decreaseQuantity,
        clearCart,
    } from '@/Stores/Data/cartStore.js';
    import { page as currentPage, router } from '@inertiajs/svelte';

    const DEBOUNCE_TIME = 300;
    const title = 'Point of Sale';
    const navbarSubTitle = 'Point of Sale';
    const products = productStore();
    let previousSearch = '';
    let search = '';
    let page = 1;
    let buyerName = '';

    const debouncedFetchItems = debounce(async () => {
        loading.start('Loading');
        const options = {
            params: {
                options: { filters: { search } },
                page,
            },
        };

        await products.fetch(options);
        loading.stop();
    }, DEBOUNCE_TIME);

    $: {
        if (search && search !== previousSearch) {
            page = 1;
            previousSearch = search;
        }
        page, debouncedFetchItems();
    }

    function handleChangeUrl(newUrl) {
        if (+newUrl === page) {
            return;
        }
        loading.start('Loading'); // This needs to be stopped, eventually it will stopped in debouncedFetchItems
        page = newUrl;
    }

    async function handleSubmit(event) {
        event.preventDefault();
        const result = await showConfirmDialog();
        if (!result.isConfirmed) {
            return showDeclinedDialog();
        } else {
            loading.start('Loading');
            try {
                const userId = $currentPage.props.user.id;
                const products = $cartStore.items.map(item => ({
                    id: item.id,
                    image: item.image,
                    maxQuantity: item.maxQuantity,
                    name: item.name,
                    price_per_unit: item.price, // change 'price' to 'price_per_unit'
                    quantity: item.quantity,
                    price_subtotal: item.price * item.quantity, // add 'price_subtotal'
                }));

                const data = {
                    user_id: userId,
                    buyer_name: buyerName,
                    price_total: $cartStore.total,
                    products,
                };

                await axios.post('/api/transactions', data);
                showSuccessDialog({ title: 'Success!', text: 'Your order has been submitted' });
                clearCart();
                router.visit('/transactions');
            } catch (error) {
                console.log(error);
                showErrorDialog();
            } finally {
                loading.stop();
                clearCart();
            }
        }
    }

    function handleAddToCart(item) {
        addItem(item);
    }

    function handleRemoveFromCart(itemId) {
        removeItem(itemId);
    }
</script>

<DashboardLayout {title} {navbarSubTitle}>
    <div class="flex">
        <div class="flex flex-[2] flex-col overflow-x-scroll">
            <div class="px-12 py-6 overflow-y-auto space-y-6">
                <div class="flex gap-3 items-center">
                    <div class="relative">
                        <input type="text" class="input input-bordered" bind:value={search} placeholder="Search" />
                        <div class="absolute top-1/2 right-3 -translate-y-1/2">
                            <i class="ri-search-line"></i>
                        </div>
                    </div>
                </div>
                <div class="flex flex-wrap gap-5">
                    {#each $products?.data ?? [] as product}
                        <div class="card card-image-cover h-fit rounded max-w-64">
                            <div class="relative p-2">
                                <img src={product.image} alt="Image of {product.name}" class="!rounded" />
                                <button
                                    on:click={() =>
                                        handleAddToCart({
                                            id: product.id,
                                            name: product.name,
                                            price: +product.price,
                                            image: product.image,
                                            maxQuantity: product.stock,
                                        })}
                                    class="absolute top-5 right-5 p-2 px-3 bg-white rounded-lg text-orange-500 opacity-80"
                                >
                                    <i class="ri-shopping-cart-line text-xl"></i>
                                </button>
                            </div>
                            <div class="card-body p-2">
                                <h2 class="card-header">{product.name}</h2>
                                <p class="text-content2">{product.description}</p>
                                <div class="card-footer">
                                    <div class="flex flex-1 justify-between font-bold">
                                        <div class="flex">
                                            <p>Rp. {product.price}</p>
                                            <span class="text-gray-500 font-medium">&nbsp; / Item</span>
                                        </div>

                                        {#if product.stock > 0}
                                            <div class="flex gap-1 text-gray-500">
                                                <i class="ri-archive-line"></i>
                                                <span>{product.stock}</span>
                                            </div>
                                        {:else}
                                            <div class="flex gap-1 text-red-500">
                                                <span class="text-red-500">Out of Stock</span>
                                            </div>
                                        {/if}
                                    </div>
                                </div>
                            </div>
                        </div>
                    {:else}
                        <div class="flex flex-1 flex-col items-center justify-center gap-5">
                            <i class="ri-search-line text-4xl text-gray-500"></i>
                            <p class="text-2xl text-gray-500">No Products Found</p>
                            <p class="text-content2">Try changing your search criteria</p>
                        </div>
                    {/each}
                </div>
                <Pagination links={$products?.meta?.links} {handleChangeUrl} />
            </div>
        </div>
        <div class="flex flex-1 flex-col shadow-2xl p-5 space-y-5">
            <h3 class="text-lg font-bold">Current Order</h3>
            <div class="flex flex-1 flex-col">
                {#each $cartStore.items as item (item.id)}
                    <div class="flex gap-2 rounded shadow p-3 relative">
                        <button
                            on:click={() => handleRemoveFromCart(item.id)}
                            class="btn btn-sm absolute top-0 right-0 btn-ghost btn-circle"
                        >
                            <!-- trash -->
                            <i class="ri-delete-bin-line"></i>
                        </button>
                        <img src={item.image} alt={item.name} class="rounded h-20" />
                        <div class="flex flex-1 flex-col gap-5">
                            <p class="text-lg font-semibold">{item.name}</p>
                            <div class="flex justify-between items-center">
                                <p class="text-orange-500">Rp. <span>{item.price}</span></p>
                                <div class="grid grid-cols-3 items-center">
                                    <button
                                        class="btn btn-sm bg-orange-500 text-white"
                                        on:click={() => decreaseQuantity(item.id)}>-</button
                                    >
                                    <p class="text-center text-base">{item.quantity}</p>
                                    <button
                                        class="btn btn-sm bg-orange-500 text-white"
                                        on:click={() => increaseQuantity(item.id)}>+</button
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                {/each}

                <form class="flex flex-col mt-5 space-y-3" on:submit|preventDefault={handleSubmit}>
                    <div class="space-y-3 p-3 rounded">
                        <div class="form-group">
                            <label for="buyer_name" class="form-label text-base">Buyer Name: {buyerName}</label>
                            <input
                                id="buyer_name"
                                name="buyer_name"
                                type="text"
                                class="input form-control input-block"
                                bind:value={buyerName}
                            />
                        </div>
                        <div class="flex flex-col space-y-2">
                            <p class="text-base">Total</p>
                            <p class="text-lg tracking-wide">Rp. <span>{$cartStore.total}</span></p>
                        </div>
                    </div>

                    <button class="btn btn-primary">Finish</button>
                </form>
            </div>
        </div>
    </div>
</DashboardLayout>
