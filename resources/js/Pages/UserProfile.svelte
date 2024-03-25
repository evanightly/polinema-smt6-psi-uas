<script>
    import DashboardLayout from '@/Layouts/DashboardLayout.svelte';
    const title = 'User Profile';

    let username;
    let email;

    let password;
    let passwordConfirmation;

    function handleChangeProfileInformation() {
        console.log('Profile Information Updated');
    }

    function handleChangePassword() {
        console.log('Password Updated');
    }
</script>

<DashboardLayout {title}>
    <div class="container mx-auto mt-8">
        <h1 class="text-2xl font-semibold mb-4">User Profile</h1>
        <div class="flex flex-col gap-5">
            <form on:submit|preventDefault={handleChangeProfileInformation}>
                <div class="form-group bg-backgroundSecondary rounded shadow-lg p-5">
                    <div class="form-field">
                        <label class="form-label" for="username"> Username </label>
                        <input
                            class="form-control input input-block"
                            id="username"
                            type="text"
                            placeholder="Username"
                            bind:value={username}
                            required
                        />
                    </div>
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
                    <div class="form-field">
                        <button class="btn btn-edit w-fit"> Update Profile </button>
                    </div>
                </div>
            </form>

            <form on:submit|preventDefault={handleChangePassword}>
                <div class="form-group bg-backgroundSecondary rounded shadow-lg p-5">
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
        </div>
    </div>
</DashboardLayout>
