<script>
    import ProductCard from '../Components/ProductCard.svelte';
    export let productData = {};
    export let deleteProduct = () => {};
</script>

<div class="flex w-full overflow-x-auto flex-wrap gap-5">
    {#each productData?.data ?? [] as product, index (product.id)}
        <ProductCard {product} {deleteProduct} />
    {:else}
        <p>No Data Available</p>
    {/each}
</div>
