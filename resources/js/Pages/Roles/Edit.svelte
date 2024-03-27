<script>
    import DashboardLayout from '../../Layouts/DashboardLayout.svelte';
    import { showConfirmDialog, showDeclinedDialog, showSuccessDialog } from '../../Helpers/showDialog';
    import { router } from '@inertiajs/svelte';

    export let role;

    async function handleSubmit() {
        // const result = await showConfirmDialog();
        // try {
        //     if (result.isConfirmed) {
        //         await axios.post(`/api/roles/${role.id}?_method=PUT`, role);
        //         await showSuccessDialog('Role added successfully');
        //         router.visit('/roles');
        //     } else {
        //         await showDeclinedDialog('Role addition declined');
        //     }
        // } catch (error) {}
    }
</script>

<DashboardLayout title="Add Role">
    <div class="flex flex-col gap-5">
        <form on:submit|preventDefault={handleSubmit} class="flex flex-col gap-5">
            <div class="rounded-lg bg-backgroundSecondary p-8 gap-5 flex flex-col">
                <div class="text-xl">Role Information</div>

                <div class="form-group">
                    <div class="form-field">
                        <label class="label" for="name">Name</label>
                        <input
                            type="text"
                            class="input input-bordered input-block"
                            id="name"
                            bind:value={role.name}
                            required
                            disabled
                        />
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-fit">Edit Role</button>
        </form>
    </div>
</DashboardLayout>
