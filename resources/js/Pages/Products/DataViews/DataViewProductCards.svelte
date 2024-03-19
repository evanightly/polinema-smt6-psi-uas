<script>
    import ProductCard from '../Components/ProductCard.svelte';
    import Masonry from 'svelte-bricks';
    import { fly } from 'svelte/transition';
    import { quintOut } from 'svelte/easing';

    export let store = {};
    export let handleDeleteItem = () => {};

    let [minColWidth, maxColWidth, gap] = [250, 800, 20];
    $: isProductExists = store?.data?.length > 0;
</script>

{#if isProductExists}
    <div
        transition:fly={{
            delay: 250,
            duration: 300,
            x: 100,
            y: 500,
            opacity: 0.5,
            easing: quintOut,
        }}
    >
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
    </div>
{:else}
    <p>No Data Available</p>
{/if}
