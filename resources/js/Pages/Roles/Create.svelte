<script>
    import { router } from '@inertiajs/svelte';
    import { showConfirmDialog, showDeclinedDialog, showSuccessDialog } from '../../Helpers/showDialog';
    import DashboardLayout from '../../Layouts/DashboardLayout.svelte';

    let newRoleData = {
        name: '',
    };

    async function handleSubmit() {
        const result = await showConfirmDialog();
        try {
            if (result.isConfirmed) {
                await axios.post('/api/roles', newRoleData);
                await showSuccessDialog('Role added successfully');
                router.visit('/roles');
            } else {
                await showDeclinedDialog('Role addition declined');
            }
        } catch (error) {
            console.log(error);
        }
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
                            bind:value={newRoleData.name}
                            required
                        />
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-fit">Add Role</button>
        </form>
    </div>
</DashboardLayout>
