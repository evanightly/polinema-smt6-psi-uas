<script>
    import { createFetchDataStore } from '../../Stores/fetchDataStore';
    import DashboardLayout from '../../Layouts/DashboardLayout.svelte';
    import Pagination from '../../Components/Pagination.svelte';
    import { Link } from '@inertiajs/svelte';

    let productDataStore = createFetchDataStore(`/api/products?page=1`);
    let productData = {};

    $: productData = $productDataStore;

    const handleChangeUrl = newUrl => productDataStore.setUrl(newUrl);
</script>

<DashboardLayout title="Products">
    <div class="flex flex-col gap-5 mt-5">
        <div class="flex justify-between">
            <Link href="/products/create" class="btn btn-primary gap-2">
                <i class="ri-add-large-line"></i>
                <span>Add Product</span>
            </Link>

            <div class="flex gap-3 items-center">
                <div class="relative">
                    <input
                        type="text"
                        class="input input-bordered"
                        placeholder="Search"
                    />
                    <div class="absolute top-1/2 right-3 -translate-y-1/2">
                        <i class="ri-search-line"></i>
                    </div>
                </div>

                <button class="btn btn-outline gap-2">
                    <i class="ri-sort-desc"></i>
                    <span> Sort </span>
                </button>

                <button class="btn btn-outline gap-2">
                    <i class="ri-equalizer-2-line"></i>
                    <span> Filter </span>
                </button>

                <button class="btn btn-outline gap-2">
                    <i class="ri-table-view"></i>
                </button>
            </div>
        </div>
        <div class="flex w-full overflow-x-auto">
            <table class="table-hover table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Image</th>
                        <th>Price (Rp)</th>
                        <th>Stock</th>
                        <th>Restock Threshold (%)</th>
                        <th>Min Stock</th>
                        <th>Max Stock</th>
                        <th>Supplier</th>
                    </tr>
                </thead>
                <tbody>
                    {#each productData?.data ?? [] as product, index (product.id)}
                        <tr>
                            <th>{index + productData.firstItem}</th>
                            <td>{product.name}</td>
                            <th>
                                <img
                                    src={product.image}
                                    alt={product.name}
                                    class="h-24"
                                />
                            </th>
                            <td>{product.price}</td>
                            <td>{product.stock}</td>
                            <td>{product.restock_threshold}</td>
                            <td>{product.min_stock}</td>
                            <td>{product.max_stock}</td>
                            <td>{product.supplier.name}</td>
                        </tr>
                    {:else}
                        <tr>
                            <td>No Data</td>
                        </tr>
                    {/each}
                </tbody>
            </table>
        </div>

        <Pagination data={productData} {handleChangeUrl} />
    </div>
</DashboardLayout>
