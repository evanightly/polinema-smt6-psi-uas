<script>
    import ProductCard from '../Components/ProductCard.svelte';
    import Masonry from 'svelte-bricks';

    export let store = {};
    export let handleDeleteItem = () => {};

    let [minColWidth, maxColWidth, gap] = [250, 800, 20];
    $: isProductExists = store?.data?.length > 0;
</script>

{#if isProductExists}
    <Masonry
        items={store?.data ?? []}
        {minColWidth}
        {maxColWidth}
        {gap}
        let:item={product}
        style="justify-content: start;"
    >
        <ProductCard {product} deleteProduct={handleDeleteItem} />
    </Masonry>
{:else}
    <p>No Data Available</p>
{/if}
