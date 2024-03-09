<script>
    import axios from 'axios';
    import DashboardLayout from '../../Layouts/DashboardLayout.svelte';
    import Pagination from '../../Components/Pagination.svelte';
    import { derived, writable } from 'svelte/store';
    import loading from '../../Stores/loadingOverlayStore';

    const url = writable(`/api/products?page=1`);
    let productData = {};

    const fetchData = derived(
        url,
        ($url, set) => {
            loading.start('Loading...');
            axios.get($url).then(({ data }) => {
                set(data);
                loading.stop();
            });

            // return () => {
            //     // Cancel any pending fetches as the component is unmounting
            //     // (or navigating to a new page)
            //     axios.cancel();
            // };
        },
        {},
    );

    $: productData = $fetchData;

    const handleChangeUrl = newUrl => {
        url.set(newUrl);
    };
</script>

<DashboardLayout>
    <div class="flex flex-col gap-5 mt-5">
        <div class="flex justify-between">
            <button class="btn btn-primary">Add Product</button>
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
