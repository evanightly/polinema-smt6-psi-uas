<script>
    import loading from '../Stores/loadingOverlayStore';
</script>

{#if $loading.isLoading}
    <div
        class="h-screen w-screen fixed bottom-0 left-0 bg-black bg-opacity-75 z-[100]"
    >
        <div class="flex flex-col justify-center items-center h-full gap-12">
            <div
                class="sk-chase text-4xl [--sk-size:4rem] [--sk-color:#fefefe]"
            >
                <div class="sk-chase-dot"></div>
                <div class="sk-chase-dot"></div>
                <div class="sk-chase-dot"></div>
                <div class="sk-chase-dot"></div>
                <div class="sk-chase-dot"></div>
                <div class="sk-chase-dot"></div>
            </div>

            <span class="text-gray-400 text-2xl animate-pulse">
                {$loading.message}
            </span>
        </div>
    </div>
{/if}
