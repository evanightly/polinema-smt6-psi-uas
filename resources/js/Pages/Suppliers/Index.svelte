<script>
    import GenericDataView from '../../Layouts/GenericDataView.svelte';
    import { supplierStore } from '../../Stores/Data/supplierStore';

    let title = 'Supplier';
    const modelUrl = 'suppliers';
    const columns = [
        {
            key: 'name',
            label: 'Name',
        },
        {
            key: 'phone',
            label: 'Phone',
        },
        {
            key: 'products_total',
            label: 'Product Total',
        },
    ];

    const store = supplierStore();
</script>

<GenericDataView {store} {title} {modelUrl} {columns}>
    <div slot="cardsView" let:handleDeleteItem>Card View Not Implemented Yet</div>
</GenericDataView>
