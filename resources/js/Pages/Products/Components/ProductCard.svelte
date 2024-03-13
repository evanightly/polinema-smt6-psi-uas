<script>
    import { Link } from '@inertiajs/svelte';
    export let product = {};
    export let deleteProduct = () => {};
</script>

<div class="card card-image-cover">
    <img src={product.image} alt={product.name} />
    <div class="card-body">
        <h2 class="card-header">{product.name}</h2>
        <p class="text-content2">{product.description}</p>
        <div class="card-footer">
            <div class="flex flex-1 flex-col gap-4">
                <div class="flex justify-between">
                    <span class="text-primary font-bold">Rp {product.price}</span>
                    <span class="text-primary font-bold">
                        <i class="ri-archive-line"></i>{product.stock}
                    </span>
                </div>

                <div class="flex gap-3">
                    <Link href={`/products/${product.id}/edit`} class="btn btn-edit">Edit</Link>
                    {#if product.canBeDeleted}
                        <button class="btn btn-delete" on:click={() => deleteProduct(product.id)}>Delete</button>
                    {/if}
                </div>
            </div>
        </div>
    </div>
</div>
