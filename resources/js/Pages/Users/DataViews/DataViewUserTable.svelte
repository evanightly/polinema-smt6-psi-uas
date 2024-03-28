<script>
    import { inertia, page } from '@inertiajs/svelte';

    export let usersData = {};
    export let handleDeleteItem = () => {};
</script>

<div class="flex w-full overflow-x-auto">
    <table class="table-hover table">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Image</th>
                <th>Email</th>
                <th>Email Status</th>
            </tr>
        </thead>
        <tbody>
            {#each usersData?.data ?? [] as user, index (user.id)}
                <tr class="group">
                    <th>{index + usersData.firstItem}</th>
                    <td>
                        <div class="flex flex-col relative">
                            <span>{user.name}</span>

                            <!-- Current logged user cant edit himself -->
                            {#if $page.props.user.id !== user.id}
                                <div class="flex absolute top-8 left-0 w-full h-full -translate-y-1/2 gap-2">
                                    <a
                                        use:inertia
                                        href={`/users/${user.id}/edit`}
                                        class="text-edit group-hover:opacity-100 opacity-0 transition-opacity duration-200"
                                    >
                                        <span>Edit</span>
                                    </a>
                                    {#if user.canBeDeleted}
                                        <button
                                            on:click={() => handleDeleteItem(user.id)}
                                            class="text-delete group-hover:opacity-100 opacity-0 transition-opacity duration-200"
                                        >
                                            Delete
                                        </button>
                                    {/if}
                                </div>
                            {/if}
                        </div>
                    </td>
                    <td><img src={user.image} alt={user.name} class="h-24" /></td>
                    <td>{user.email}</td>

                    <td>
                        {#if user.is_verified}
                            <span class="badge badge-success">Verified</span>
                        {:else}
                            <span class="badge badge-error">Unverified</span>
                        {/if}
                    </td>
                </tr>
            {:else}
                <tr>
                    <td>No Data</td>
                </tr>
            {/each}
        </tbody>
    </table>
</div>
