<script>
    import GenericDataView from '../../Layouts/GenericDataView.svelte';
    import { productStore } from '../../Stores/Data/productStore';
    import DataViewProductCards from './DataViews/DataViewProductCards.svelte';

    let title = 'Product';
    const modelUrl = 'products';
    const columns = [
        {
            key: 'name',
            label: 'Name',
        },
        {
            key: 'image',
            label: 'Image',
            isImage: true,
        },
        {
            key: 'price',
            label: 'Price',
        },
        {
            key: 'stock',
            label: 'Available Stock',
        },
        {
            key: 'needs_restock',
            label: 'Needs Restock',
        },
        {
            key: 'can_be_deleted',
            label: 'Can Be Deleted',
        },
    ];

    const store = productStore();
</script>

<GenericDataView {store} {title} {modelUrl} {columns}>
    <div slot="cardsView" let:handleDeleteItem>
        <DataViewProductCards store={$store} {handleDeleteItem} />
    </div>
</GenericDataView>
