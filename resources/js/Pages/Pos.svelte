<!-- NOT RESPONSIVE YET, MIGHT IMPLEMENT MODAL IN CHECKOUT COMPONENT -->
<script>
    import DashboardLayout from '@/Layouts/DashboardLayout.svelte';
    import { productStore } from '@/Stores/Data/productStore.js';
    import { debounce } from 'lodash';
    import loading from '../Stores/Utility/loadingOverlayStore';
    import Pagination from '../Components/Pagination.svelte';
    import { showConfirmDialog, showDeclinedDialog } from '../Helpers/showDialog';

    const DEBOUNCE_TIME = 300;
    const title = 'Point of Sale';
    const navbarSubTitle = 'Point of Sale';
    const products = productStore();
    let previousSearch = '';
    let search = '';
    let page = 1;

    const debouncedFetchItems = debounce(async () => {
        loading.start('Loading');
        const options = {
            params: {
                options: { filters: { search } },
                page,
            },
        };

        await products.fetch(options);
        console.log($products);
        loading.stop();
    }, DEBOUNCE_TIME);

    $: console.log($products);

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
            // Checkout logic
        }
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
                        <div class="card card-image-cover h-fit rounded-sm max-w-64">
                            <div class="relative">
                                <img src={product.image} alt="Image of {product.name}" class="rounded-sm" />
                                <button
                                    class="absolute top-5 right-5 p-2 px-3 bg-white rounded-lg text-orange-500 opacity-80"
                                >
                                    <i class="ri-shopping-cart-line text-xl"></i>
                                </button>
                            </div>
                            <div class="card-body p-5">
                                <h2 class="card-header">{product.name}</h2>
                                <p class="text-content2">{product.description}</p>
                                <div class="card-footer">
                                    <div class="flex flex-1 justify-between font-bold">
                                        <div class="flex">
                                            <p>Rp. {product.price}</p>
                                            <span class="text-gray-500">&nbsp; / Item</span>
                                        </div>

                                        <div class="flex gap-1 text-gray-500">
                                            <i class="ri-archive-line"></i>
                                            <span>{product.stock}</span>
                                        </div>
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
                <div class="flex gap-2 rounded shadow p-3">
                    <img />
                    <div class="flex flex-1 flex-col gap-5">
                        <p class="text-lg font-semibold">Double Chicken</p>
                        <div class="flex justify-between items-center">
                            <p class="text-orange-500">Rp. <span>99999</span></p>
                            <div class="grid grid-cols-3 items-center">
                                <button class="btn btn-sm bg-orange-500 text-white">-</button>
                                <p class="text-center text-base">1</p>
                                <button class="btn btn-sm bg-orange-500 text-white">+</button>
                            </div>
                        </div>
                    </div>
                </div>

                <form class="flex flex-col mt-5 space-y-3" on:submit|preventDefault={handleSubmit}>
                    <div class="space-y-3 p-3 rounded">
                        <div class="form-group">
                            <label for="buyer_name" class="form-label text-base">Buyer Name</label>
                            <input
                                id="buyer_name"
                                name="buyer_name"
                                type="text"
                                class="input form-control input-block"
                            />
                        </div>
                        <div class="flex flex-col space-y-2">
                            <p class="text-base">Total</p>
                            <p class="text-lg tracking-wide">Rp. <span>299.970</span></p>
                        </div>
                    </div>

                    <button class="btn btn-primary">Finish</button>
                </form>
            </div>
        </div>
    </div>
</DashboardLayout>
