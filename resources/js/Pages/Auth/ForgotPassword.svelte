<script>
    import MainLayout from '@/Layouts/MainLayout.svelte';
    import { inertia } from '@inertiajs/svelte';
    import { showDialog } from '@/Helpers/showDialog';
    import loading from '../../Stores/Utility/loadingOverlayStore';
    let email = '';
    let title = 'Forgot Password';
    let isLoading = false;

    async function handleSendEmail() {
        try {
            loading.start('Sending email...');
            isLoading = true;
            const { data } = await axios.post('/forgot-password', { email });

            await showDialog({
                title: 'Success',
                text: data.message,
            });
        } catch (error) {
        } finally {
            loading.stop();
            isLoading = false;
        }
    }
</script>

<MainLayout {title}>
    <div class="flex flex-col items-center justify-center h-screen">
        <div class="card relative p-5">
            <a class="btn btn-ghost btn-circle absolute top-0 left-0" href="/login" use:inertia>
                <i class="ri-arrow-left-line"></i>
            </a>
            <h1 class="card-header justify-center">Forgot Password</h1>

            <p class="text-gray-600 mb-8">Enter your email address to reset your password.</p>
            <form class="w-64" on:submit|preventDefault={handleSendEmail}>
                <input type="email" name="email" placeholder="Email" bind:value={email} class="input mb-4" required />
                <button class="btn btn-primary {isLoading ? 'btn-loading' : ''}">
                    {isLoading ? 'Please wait' : 'Send Email'}
                </button>
            </form>
        </div>
    </div>
</MainLayout>
