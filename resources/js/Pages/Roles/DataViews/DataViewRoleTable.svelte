<script>
    import { inertia } from '@inertiajs/svelte';

    export let rolesData = {};
    export let handleDeleteItem = () => {};
</script>

<div class="flex w-full overflow-x-auto">
    <table class="table-hover table">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>User Total</th>
            </tr>
        </thead>
        <tbody>
            {#each rolesData?.data ?? [] as role, index (role.id)}
                <tr class="group">
                    <th>{index + rolesData.firstItem}</th>
                    <td>
                        <div class="flex flex-col relative">
                            <span>{role.name}</span>
                            <div class="flex absolute top-8 left-0 w-full h-full -translate-y-1/2 gap-2">
                                <a
                                    use:inertia
                                    href={`/roles/${role.id}/edit`}
                                    class="text-edit group-hover:opacity-100 opacity-0 transition-opacity duration-200"
                                >
                                    <span>Edit</span>
                                </a>
                                {#if role.isRemovable}
                                    <button
                                        on:click={() => handleDeleteItem(role.id)}
                                        class="text-delete group-hover:opacity-100 opacity-0 transition-opacity duration-200"
                                    >
                                        Delete
                                    </button>
                                {/if}
                            </div>
                        </div>
                    </td>
                    <td>{role.users_total}</td>
                </tr>
            {:else}
                <tr>
                    <td>No Data</td>
                </tr>
            {/each}
        </tbody>
    </table>
</div>
