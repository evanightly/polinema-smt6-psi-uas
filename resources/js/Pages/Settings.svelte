<script>
    import DashboardLayout from '../Layouts/DashboardLayout.svelte';
    import { darkMode, toggleDarkMode } from '@/Stores/Utility/darkModeStore.js';
    import { dataViewMode, toggleViewMode } from '@/Stores/Data/dataViewModeStore.js';
    const title = 'Settings';
    let navbarSubTitle = `Settings Page`;
</script>

<DashboardLayout {title} {navbarSubTitle}>
    <div class="flex flex-col gap-2 rounded bg-backgroundSecondary p-5 mt-8">
        <p>Theme:</p>
        <div class="flex gap-2">
            <input
                id="dark-mode"
                type="checkbox"
                value={$darkMode}
                on:change={toggleDarkMode}
                class="form-control checkbox checkbox-primary"
            />
            <label for="dark-mode" class="form-label">Dark Mode</label>
        </div>
    </div>

    <div class="flex flex-col gap-2 rounded bg-backgroundSecondary p-5">
        <p>Preferable Data Rendering: <span class="text-primary">{$dataViewMode}</span></p>
        <button class="btn btn-primary w-fit" on:click={toggleViewMode}>Toggle Data Rendering</button>
    </div>
</DashboardLayout>
