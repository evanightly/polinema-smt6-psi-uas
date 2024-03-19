<script>
    import { inertia } from '@inertiajs/svelte';

    export let itemsData = {};
    export let handleDeleteItem = () => {};
</script>

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
            {#each itemsData?.data ?? [] as product, index (product.id)}
                <tr class="group">
                    <th>{index + itemsData.firstItem}</th>
                    <td>
                        <div class="flex flex-col relative">
                            <span>{product.name}</span>
                            <div class="flex absolute top-8 left-0 w-full h-full -translate-y-1/2 gap-2">
                                <a
                                    use:inertia
                                    href={`/products/${product.id}/edit`}
                                    class="text-edit group-hover:opacity-100 opacity-0 transition-opacity duration-200"
                                >
                                    <span>Edit</span>
                                </a>
                                {#if product.can_be_deleted}
                                    <button
                                        on:click={() => handleDeleteItem(product.id)}
                                        class="text-delete group-hover:opacity-100 opacity-0 transition-opacity duration-200"
                                    >
                                        Delete
                                    </button>
                                {/if}
                            </div>
                        </div>
                    </td>
                    <th>
                        <img src={product.image} alt={product.name} class="h-24" />
                    </th>
                    <td>{product.price}</td>
                    <td>{product.stock}</td>
                    <td>{product.restock_threshold}</td>
                    <td>{product.min_stock}</td>
                    <td>{product.max_stock}</td>
                    <td>{product.supplier?.name}</td>
                </tr>
            {:else}
                <tr>
                    <td>No Data</td>
                </tr>
            {/each}
        </tbody>
    </table>
</div>
