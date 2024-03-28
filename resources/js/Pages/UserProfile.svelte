<script>
    import DashboardLayout from '@/Layouts/DashboardLayout.svelte';
    import { showAlert } from '@/Helpers/showAlert.js';
    import { showSuccessDialog } from '@/Helpers/showDialog.js';
    import { page } from '@inertiajs/svelte';
    import axios from 'axios';
    import loading from '../Stores/Utility/loadingOverlayStore';
    import formDataLogger from '@/Helpers/formDataLogger.js';

    const user = $page.props.user;

    console.log($page);

    const title = 'User Profile';
    let name = user.name;
    let userImage = user.image;
    let image;
    let email = user.email;
    let currentPassword;
    let password;
    let passwordConfirmation;

    async function handleChangeProfileInformation() {
        try {
            loading.start('Updating Profile Information...');
            await axios.post(
                'user/profile-information?_method=PUT',
                {
                    name,
                    email,
                    image,
                },
                {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    },
                },
            );
            await showSuccessDialog({
                title: 'Profile Information Updated',
                text: 'Your profile information has been updated successfully.',
            });
            location.reload();
        } catch (error) {
        } finally {
            loading.stop();
        }
    }

    async function handleChangePassword() {
        if (password !== passwordConfirmation) {
            showAlert('error', 'Password and Confirm Password do not match');
            return;
        }

        loading.start('Updating Password...');
        try {
            await axios.post('user/password?_method=PUT', {
                current_password: currentPassword,
                password,
                password_confirmation: passwordConfirmation,
            });
            await showSuccessDialog({
                title: 'Password Updated',
                text: 'Your password has been updated successfully.',
            });
            location.reload();
        } catch (error) {
        } finally {
            loading.stop();
        }
    }

    function handleFileChange(event) {
        image = event.target.files[0];
    }
</script>

<DashboardLayout {title}>
    <div class="container mx-auto mt-8">
        <h1 class="text-2xl font-semibold mb-4">User Profile</h1>
        <div class="flex flex-col gap-5">
            <form on:submit|preventDefault={handleChangeProfileInformation}>
                <div class="form-group bg-backgroundSecondary rounded shadow-lg p-5">
                    <div class="form-field">
                        <img src={userImage} alt={`${name}'s Image'`} class="w-20" />
                        <label class="form-label" for="image"> Image </label>
                        <input class="form-control input-file" id="image" type="file" on:change={handleFileChange} />
                    </div>
                    <div class="form-field">
                        <label class="form-label" for="name"> Name </label>
                        <input
                            class="form-control input input-block"
                            id="name"
                            type="text"
                            placeholder="Name"
                            bind:value={name}
                            required
                        />
                    </div>
                    {#if !user.is_google_user}
                        <div class="form-field">
                            <label class="form-label" for="email"> Email </label>
                            <input
                                class="form-control input input-block"
                                id="email"
                                type="email"
                                placeholder="Email"
                                bind:value={email}
                                required
                            />
                        </div>
                    {/if}
                    <div class="form-field">
                        <button class="btn btn-edit w-fit"> Update Profile </button>
                    </div>
                </div>
            </form>

            {#if !user.is_google_user}
                <form on:submit|preventDefault={handleChangePassword}>
                    <div class="form-group bg-backgroundSecondary rounded shadow-lg p-5">
                        <div class="form-field">
                            <label class="form-label" for="current-password"> Current Password </label>
                            <input
                                class="form-control input input-block"
                                id="current-password"
                                type="password"
                                placeholder="Current Password"
                                bind:value={currentPassword}
                                required
                            />
                        </div>
                        <div class="form-field">
                            <label class="form-label" for="password"> Password </label>
                            <input
                                class="form-control input input-block"
                                id="password"
                                type="password"
                                placeholder="Password"
                                bind:value={password}
                                required
                            />
                        </div>
                        <div class="form-field">
                            <label class="form-label" for="password_confirmation"> Confirm Password </label>
                            <input
                                class="form-control input input-block"
                                id="password_confirmation"
                                type="password"
                                placeholder="Confirm Password"
                                bind:value={passwordConfirmation}
                                required
                            />
                        </div>
                        <div class="form-field">
                            <button class="btn btn-edit w-fit"> Update Password </button>
                        </div>
                    </div>
                </form>
            {/if}
        </div>
    </div>
</DashboardLayout>
