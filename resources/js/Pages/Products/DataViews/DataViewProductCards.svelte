<script>
    import ProductCard from '../Components/ProductCard.svelte';
    export let store = {};
    export let handleDeleteItem = () => {};
</script>

<div class="flex w-full overflow-x-auto flex-wrap gap-5">
    {#each store?.data ?? [] as product, index (product.id)}
        <ProductCard {product} deleteProduct={handleDeleteItem} />
    {:else}
        <p>No Data Available</p>
    {/each}
</div>
