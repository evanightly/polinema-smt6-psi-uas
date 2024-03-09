<script>
    import { darkMode, toggleDarkMode } from '../../Stores/darkModeStore';
</script>

<button class="btn avatar avatar-ring avatar-squared" on:click={toggleDarkMode}>
    {#if $darkMode}
        <i class="ri-sun-line"></i>
    {:else}
        <i class="ri-moon-foggy-line"></i>
    {/if}
</button>
