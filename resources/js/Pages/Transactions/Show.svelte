<script>
    import DashboardLayout from '../../Layouts/DashboardLayout.svelte';

    export let transaction = {};

    console.log(transaction);

    const title = 'Transaction/Detail Transaction';
</script>

<DashboardLayout {title}>
    <p>Transaction ID: {transaction.id}</p>

    <p>Transaction Date: {transaction.formatted_transaction_date}</p>

    <p>Buyer: {transaction.buyer_name}</p>

    <p>Total: {transaction.price_total}</p>

    <p>Staff: {transaction.user.name}</p>

    <p>Products:</p>

    <ul>
        {#each transaction.products as product, index (product.id)}
            <li>
                {index + 1}. {product.name} - {product.pivot.quantity} x {product.pivot.price_per_unit} = {product.pivot
                    .price_subtotal}
            </li>
        {/each}
    </ul>

    <a href="/transactions" class="text-primary">Back</a>

    <a href={`/transactions/${transaction.id}/edit`} class="text-edit">Edit</a>

    <button class="text-delete">Delete</button>

    <a href={`/transactions/${transaction.id}/print`} class="text-primary">Print</a>

    <a href={`/transactions/${transaction.id}/pdf`} class="text-primary">PDF</a>

    <a href={`/transactions/${transaction.id}/excel`} class="text-primary">Excel</a>
</DashboardLayout>
