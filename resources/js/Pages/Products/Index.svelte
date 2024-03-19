<script>
    import GenericDataView from '../../Layouts/GenericDataView.svelte';
    import { productStore } from '../../Stores/Data/productStore';
    import DataViewProductCards from './DataViews/DataViewProductCards.svelte';

    let title = 'product';
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
    ];

    const store = productStore();
</script>

<GenericDataView {store} {title} {modelUrl} {columns}>
    <div slot="cardsView" let:handleDeleteItem>
        <DataViewProductCards store={$store} {handleDeleteItem} />
    </div>
</GenericDataView>
