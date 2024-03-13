<script>
    import { onMount } from 'svelte';
    import { showConfirmDialog, showDeclinedDialog, showSuccessDialog } from '../../Helpers/showDialog';
    import DashboardLayout from '../../Layouts/DashboardLayout.svelte';
    import axios from 'axios';
    import loading from '../../Stores/loadingOverlayStore';
    import { router } from '@inertiajs/svelte';
    let roles = [];

    let imageFile;

    let newUserData = {
        name: '',
        password: '',
        password_confirmation: '',
        image: '',
        address: '',
        email: '',
        roles: [],
    };

    function handleFileChange(event) {
        imageFile = event.target.files[0];
    }

    onMount(async () => {
        const { data: response } = await axios.get('/api/roles');
        roles = response.data;
    });

    async function handleSubmit() {
        const result = await showConfirmDialog();
        try {
            if (result.isConfirmed) {
                loading.start('Adding user');

                await axios.post(
                    '/api/users',
                    { ...newUserData, image: imageFile },
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data',
                        },
                    },
                );
                await showSuccessDialog('User added successfully');
                loading.stop();
                router.visit('/users');
            } else {
                await showDeclinedDialog('User addition declined');
            }
        } catch (error) {
            console.log(error);
        }
    }
</script>

<DashboardLayout title="Add User">
    <div class="flex flex-col gap-5">
        <form on:submit|preventDefault={handleSubmit} class="flex flex-col gap-5">
            <div class="rounded-lg bg-backgroundSecondary p-8 gap-5 flex flex-col">
                <div class="text-xl">User Information</div>

                <div class="form-group">
                    <div class="flex flex-1 gap-5">
                        <div class="form-field flex-1">
                            <label class="label" for="name">Name</label>
                            <input
                                type="text"
                                class="input input-bordered input-block"
                                id="name"
                                bind:value={newUserData.name}
                                required
                            />
                        </div>
                        <div class="form-field flex-1">
                            <label class="label" for="email">Email</label>
                            <input
                                type="email"
                                class="input input-bordered input-block"
                                id="email"
                                bind:value={newUserData.email}
                                required
                            />
                        </div>
                    </div>
                    <div class="flex flex-1 gap-5">
                        <div class="form-field flex-1">
                            <label class="label" for="password">Password</label>
                            <input
                                type="password"
                                class="input input-bordered input-block"
                                id="password"
                                bind:value={newUserData.password}
                                required
                            />
                        </div>
                        <div class="form-field flex-1">
                            <label class="label" for="password_confirmation">Confirm Password</label>
                            <input
                                type="password"
                                class="input input-bordered input-block"
                                id="password_confirmation"
                                bind:value={newUserData.password_confirmation}
                                required
                            />
                        </div>
                    </div>
                    <div class="form-field">
                        <label for="image" class="label">Image</label>
                        <input type="file" class="input-file max-w-full" id="image" on:change={handleFileChange} />
                    </div>
                    <div class="form-field">
                        <label for="role" class="label">Role</label>
                        {#each roles as role, i}
                            <!-- Show checkboxes of roles -->
                            <div class="flex items center gap-2">
                                <input
                                    type="checkbox"
                                    id={role.id}
                                    name="role"
                                    value={role.id}
                                    class="checkbox"
                                    on:change={e => {
                                        if (e.target.checked) {
                                            newUserData.roles.push(role.id);
                                        } else {
                                            // Looks for the index of the role in the array and removes it
                                            const index = newUserData.roles.indexOf(role.id);
                                            if (index !== -1) {
                                                newUserData.roles.splice(index, 1);
                                            }
                                        }
                                    }}
                                />
                                <label for={role.id}>{role.name}</label>
                            </div>
                        {/each}
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-fit">Add User</button>
        </form>
    </div>
</DashboardLayout>
