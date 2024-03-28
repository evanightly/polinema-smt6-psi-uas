<script>
    import { inertia } from '@inertiajs/svelte';

    export let transactionsData = {};
    export let handleDeleteItem = () => {};
</script>

<div class="flex w-full overflow-x-auto">
    <table class="table-hover table">
        <thead>
            <tr>
                <th>#</th>
                <th>Staff</th>
                <th>Buyer</th>
                <th>Total</th>
                <th>Transaction Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            {#each transactionsData?.data ?? [] as transaction, index (transaction.id)}
                <tr class="group">
                    <th>{index + transactionsData.firstItem}</th>
                    <td>
                        <div class="flex flex-col relative">
                            <span>{transaction.user.name}</span>
                            <div class="flex absolute top-8 left-0 w-full h-full -translate-y-1/2 gap-2">
                                <a
                                    use:inertia
                                    href={`/transactions/${transaction.id}/edit`}
                                    class="text-edit group-hover:opacity-100 opacity-0 transition-opacity duration-200"
                                >
                                    <span>Edit</span>
                                </a>
                                {#if transaction.isRemovable}
                                    <button
                                        on:click={() => handleDeleteItem(transaction.id)}
                                        class="text-delete group-hover:opacity-100 opacity-0 transition-opacity duration-200"
                                    >
                                        Delete
                                    </button>
                                {/if}
                            </div>
                        </div>
                    </td>
                    <td>{transaction.buyer_name}</td>
                    <td>{transaction.price_total}</td>
                    <td>{transaction.formatted_transaction_date}</td>
                    <td>
                        <a use:inertia href={`/transactions/${transaction.id}`} class="text-primary"> View </a>
                    </td>
                </tr>
            {:else}
                <tr>
                    <td>No Data</td>
                </tr>
            {/each}
        </tbody>
    </table>
</div>
