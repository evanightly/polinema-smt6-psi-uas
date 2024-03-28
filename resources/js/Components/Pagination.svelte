<script>
    export let links = [];
    export let handleChangeUrl = () => {};
    import validateNumber from '../Helpers/validateNumber';

    $: buttonClass = link => {
        return link.active ? 'btn btn-active' : 'btn';
    };
</script>

<div class="pagination pagination-rounded w-full max-w-xs overflow-auto py-4">
    {#each links as link}
        {#if link.url && validateNumber(link.label)}
            <button class={buttonClass(link)} on:click={() => handleChangeUrl(link.label)}>
                {link.label}
                <span class="sr-only">
                    Page {link.label}
                </span>
            </button>
        {/if}
    {/each}
</div>
