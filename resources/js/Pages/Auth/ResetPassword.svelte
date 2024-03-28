<script>
    import MainLayout from '@/Layouts/MainLayout.svelte';
    import { page, router } from '@inertiajs/svelte';
    import loading from '@/Stores/Utility/loadingOverlayStore';
    import { showDialog } from '@/Helpers/showDialog';

    let password = '';
    let passwordConfirmation = '';
    let title = 'Forgot Password';
    let email = $page.props.email;
    let token = $page.props.token;
    let isLoading = false;

    async function handleResetPassword() {
        try {
            isLoading = true;
            loading.start('Resetting password...');
            const { data } = await axios.post('/reset-password', {
                email,
                password,
                password_confirmation: passwordConfirmation,
                token,
            });

            await showDialog({
                title: 'Success',
                text: data.message,
            });

            router.visit('/login');
        } catch (error) {
            console.log(error.response.data);
        } finally {
            loading.stop();
            isLoading = false;
        }
    }
</script>

<MainLayout {title}>
    <div class="flex flex-col items-center justify-center h-screen">
        <h1 class="text-2xl font-bold mb-4">Reset Password</h1>
        <p class="text-gray-600 mb-8">Enter your email address and new password.</p>
        <form class="w-64" on:submit|preventDefault={handleResetPassword}>
            <input type="email" placeholder="Email" bind:value={email} class="input mb-4" required disabled />
            <input type="password" placeholder="Password" bind:value={password} class="input mb-4" required />
            <input
                type="password"
                placeholder="Confirm Password"
                bind:value={passwordConfirmation}
                class="input mb-4"
                required
            />
            <button class="btn btn-primary {isLoading ? 'btn-loading' : ''}">
                {isLoading ? 'Please wait' : 'Reset Password'}
            </button>
        </form>
    </div>
</MainLayout>
