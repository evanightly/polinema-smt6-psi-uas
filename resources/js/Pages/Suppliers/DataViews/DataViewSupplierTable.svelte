<script>
    import { inertia } from '@inertiajs/svelte';

    export let suppliersData = {};
    export let handleDeleteItem = () => {};
</script>

<div class="flex w-full overflow-x-auto">
    <table class="table-hover table">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Address</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Note</th>
                <th>Product Total</th>
            </tr>
        </thead>
        <tbody>
            {#each suppliersData?.data ?? [] as supplier, index (supplier.id)}
                <tr class="group">
                    <th>{index + suppliersData.firstItem}</th>
                    <td>
                        <div class="flex flex-col relative">
                            <span>{supplier.name}</span>
                            <div class="flex absolute top-8 left-0 w-full h-full -translate-y-1/2 gap-2">
                                <a
                                    use:inertia
                                    href={`/suppliers/${supplier.id}/edit`}
                                    class="text-edit group-hover:opacity-100 opacity-0 transition-opacity duration-200"
                                >
                                    <span>Edit</span>
                                </a>
                                {#if supplier.canBeDeleted}
                                    <button
                                        on:click={() => handleDeleteItem(supplier.id)}
                                        class="text-delete group-hover:opacity-100 opacity-0 transition-opacity duration-200"
                                    >
                                        Delete
                                    </button>
                                {/if}
                            </div>
                        </div>
                    </td>
                    <td>{supplier.address}</td>
                    <td>{supplier.email}</td>
                    <td>{supplier.phone}</td>
                    <td>{supplier.note}</td>
                    <td>{supplier.products_total}</td>
                </tr>
            {:else}
                <tr>
                    <td>No Data</td>
                </tr>
            {/each}
        </tbody>
    </table>
</div>
