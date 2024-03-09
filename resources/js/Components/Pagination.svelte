<script>
    export let data = {};
    export let handleChangeUrl = () => {};

    $: links = data.meta?.links ?? 0;

    $: console.log(data);

    function isNumber(n) {
        return !isNaN(parseFloat(n)) && isFinite(n);
    }
</script>

<div class="pagination pagination-rounded w-full max-w-xs overflow-auto">
    {#if links}
        {#each links as link}
            {#if link.url}
                {#if isNumber(link.label)}
                    <button class="btn {link.active ? 'btn-active' : ''}" on:click={() => handleChangeUrl(link.url)}>
                        {link.label}
                        <span class="sr-only">
                            Page {link.label}
                        </span>
                    </button>
                {/if}
            {/if}
        {/each}
    {/if}
</div>
