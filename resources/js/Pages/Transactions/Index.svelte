<script>
    import GenericDataView from '../../Layouts/GenericDataView.svelte';
    import { transactionStore } from '../../Stores/Data/transactionStore';

    let title = 'Transaction';
    const modelUrl = 'transactions';
    const columns = [
        {
            key: 'buyer_name',
            label: 'Buyer Name',
            fallbackValue: 'N/A',
        },
        {
            key: 'user.name',
            label: 'Staff',
        },
        {
            key: 'price_total',
            label: 'Price Total',
        },
        {
            key: 'has_related_models',
            label: 'Has Related Models',
        },
        {
            key: 'formatted_transaction_date',
            label: 'Transaction Date',
        },
    ];

    const store = transactionStore();
</script>

<GenericDataView {store} {title} {modelUrl} {columns} showAddButton={false} showEditButton={false}>
    <div slot="cardsView" let:handleDeleteItem>Card View Not Implemented Yet</div>
</GenericDataView>
