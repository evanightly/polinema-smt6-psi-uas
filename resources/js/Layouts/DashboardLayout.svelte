<script>
    import DashboardSidebar from "../Components/DashboardSidebar.svelte";
</script>

<div class="flex bg-red-400 w-screen max-h-screen">
    <DashboardSidebar />
    <div class="flex flex-1 overflow-y-auto">
        <slot />
    </div>
</div>
