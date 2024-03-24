<script>
    import MainLayout from '../../Layouts/MainLayout.svelte';

    const title = 'Verify Email';
    let message = '';
    let isLoading = false;

    async function handleResendVerificationEmail() {
        try {
            isLoading = true;
            await axios.post('/email/verification-notification');
            message = 'Verification link sent!';
        } catch (error) {
            message = 'Error sending verification link.';
        } finally {
            isLoading = false;
        }
    }
</script>

<MainLayout {title}>
    <div class="flex flex-col items-center justify-center h-screen">
        <h1 class="text-3xl font-bold mb-4">Verify Your Email</h1>
        <p class="text-gray-600 mb-8">Please check your email for a verification link.</p>
        <button class="btn btn-primary {isLoading ? 'btn-loading' : ''}" on:click={handleResendVerificationEmail}>
            {isLoading ? 'Please wait' : 'Resend Verification Email'}
        </button>
        <p>{message}</p>
    </div>
</MainLayout>
