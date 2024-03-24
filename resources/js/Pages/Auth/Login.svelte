<script>
    import axios from 'axios';
    import LoginSideImage from '../../Assets/Images/login-side-image.png';
    import MainLayout from '../../Layouts/MainLayout.svelte';
    import { inertia, router, page } from '@inertiajs/svelte';
    import loading from '../../Stores/Utility/loadingOverlayStore';
    import persistTokenAndRedirect from '@/Helpers/persistTokenAndRedirect';
    import { onMount } from 'svelte';
    let apiToken = $page.props.api_token;
    let email = '';
    let password = '';

    onMount(async () => {
        if (apiToken) {
            persistTokenAndRedirect(apiToken);
        }
    });

    async function handleSubmit() {
        loading.start('Logging in...');
        try {
            await axios.post('/login', { email, password }).then(response => {
                loading.stop();
                persistTokenAndRedirect(response.data.api_token);
                // inertia.get('page').props.flashMessage = response.data.message;
            });
        } catch (error) {
            console.log(error.response.data);
        } finally {
            loading.stop();
        }
    }
</script>

<MainLayout title="Login">
    <div class="flex max-h-screen">
        <img class="hidden lg:flex flex-1 object-cover object-center" src={LoginSideImage} alt="Left Side" />
        <section class="login-form flex flex-1 flex-col items-center justify-center gap-9 p-12 md:p-36 lg:px-24">
            <span class="text-3xl font-bold text-primary gap-2 inline-flex">
                <i class="ri-restaurant-fill"></i>
                <p>E-Canteen</p>
            </span>
            <p class="text-xl font-bold">Log in to your account</p>
            <form class="flex flex-col w-full items-end gap-4" on:submit|preventDefault={handleSubmit}>
                <input
                    class="input input-block"
                    type="email"
                    name="email"
                    placeholder="Email"
                    bind:value={email}
                    required
                />
                <input
                    class="input input-block"
                    type="password"
                    name="password"
                    placeholder="Password"
                    bind:value={password}
                    required
                />
                <a class="text-primary" href="/forgot-password" use:inertia>Forgot your password?</a>
                <button class="btn btn-block btn-primary mt-5" type="submit">Log in</button>
                <a href="/auth/google" class="btn btn-block btn-secondary gap-2">
                    <i class="ri-google-fill"></i>
                    <span>Log in with Google</span>
                </a>
                <p class="text-center">
                    Don't have an account? <a class="text-primary" href="/register" use:inertia>Register</a>
                </p>
            </form>
        </section>
    </div>
</MainLayout>
