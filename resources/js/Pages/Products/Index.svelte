<script>
    import DashboardLayout from '../../Layouts/DashboardLayout.svelte';
    import Pagination from '../../Components/Pagination.svelte';
    import { Link, inertia } from '@inertiajs/svelte';
    import loading from '../../Stores/loadingOverlayStore';

    let filters = {
        search: '',
        sort: 'id',
        page: 1,
    };

    let productData;

    async function fetchProducts() {
        const { data: response } = await axios.get('/api/products', {
            params: filters,
        });
        return response;
    }

    async function showConfirmDelete() {
        return await Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
        });
    }

    $: {
        filters, fetchProducts().then(data => (productData = data));
    }

    function handleChangeUrl(newUrl) {
        filters = {
            ...filters,
            page: newUrl,
        };
    }

    function isNumber(n) {
        return !isNaN(parseFloat(n)) && isFinite(n);
    }

    const deleteProduct = async id => {
        const result = await showConfirmDelete();

        if (result.isDenied) {
            return Swal.fire('Changes are not saved', '', 'info');
        }

        try {
            await axios.delete(`/api/products/${id}`);
            fetchProducts().then(data => (productData = data));
            Swal.fire('Deleted!', 'Your file has been deleted.', 'success');
        } catch (error) {
            console.log(error);
            Swal.fire({
                title: 'Error!',
                text: error.response.data.message,
                icon: 'error',
            });
        } finally {
            loading.stop();
        }
    };
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
                        <tr class="group">
                            <th>{index + productData.firstItem}</th>
                            <td>
                                <div class="flex flex-col relative">
                                    <span>{product.name}</span>
                                    <div
                                        class="flex absolute top-8 left-0 w-full h-full -translate-y-1/2 gap-2"
                                    >
                                        <a
                                            use:inertia
                                            href={`/products/${product.id}/edit`}
                                            class="text-blue-500 group-hover:opacity-100 opacity-0 transition-opacity duration-200"
                                        >
                                            <span>Edit</span>
                                        </a>
                                        {#if product.isRemovable}
                                            <button
                                                on:click={() =>
                                                    deleteProduct(product.id)}
                                                class="text-rose-500 group-hover:opacity-100 opacity-0 transition-opacity duration-200"
                                            >
                                                Delete
                                            </button>
                                        {/if}
                                    </div>
                                </div>
                            </td>
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

        <div
            class="pagination pagination-rounded w-full max-w-xs overflow-auto"
        >
            {#each productData?.meta?.links ?? [] as link}
                {#if link.url}
                    {#if isNumber(link.label)}
                        <button
                            class="btn {link.active ? 'btn-active' : ''}"
                            on:click={() => handleChangeUrl(link.label)}
                        >
                            {link.label}
                            <span class="sr-only">
                                Page {link.label}
                            </span>
                        </button>
                    {/if}
                {/if}
            {/each}
        </div>
    </div>
</DashboardLayout>
