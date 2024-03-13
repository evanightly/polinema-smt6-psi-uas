<script>
    import axios from 'axios';
    import LoginSideImage from '../../Assets/Images/login-side-image.png';
    import MainLayout from '../../Layouts/MainLayout.svelte';
    import { inertia, router } from '@inertiajs/svelte';
    import loading from '../../Stores/loadingOverlayStore';

    let email = '';
    let password = '';

    async function handleSubmit() {
        loading.start('Logging in...');
        try {
            const response = await axios.post('/login', { email, password });
            sessionStorage.setItem('api_token', response.data.api_token);
            // inertia.get('page').props.flashMessage = response.data.message;
            router.visit('/');
            loading.stop();
        } catch (error) {
            console.log(error.response.data);
        }
    }
</script>

<MainLayout title="Login">
    <div class="flex max-h-screen">
        <img class="hidden lg:flex flex-1 object-cover object-center" src={LoginSideImage} alt="Left Side" />
        <section class="login-form flex flex-1 flex-col items-center justify-center gap-9 p-36 lg:px-24">
            <span class="text-3xl font-bold text-primary gap-2 inline-flex">
                <i class="ri-restaurant-fill"></i>
                <p>E-Canteen</p>
            </span>
            <p class="text-xl font-bold">Log in to your account</p>
            <form class="flex flex-col w-full items-end gap-4" on:submit|preventDefault={handleSubmit}>
                <input class="input input-block" type="email" name="email" placeholder="Email" bind:value={email} />
                <input
                    class="input input-block"
                    type="password"
                    name="password"
                    placeholder="Password"
                    bind:value={password}
                />
                <a class="text-primary" href="/forgot">Forgot your password?</a>
                <button class="btn btn-block btn-primary mt-5" type="submit">Log in</button>
                <a href="/auth/google" use:inertia class="btn btn-block btn-secondary gap-2">
                    <i class="ri-google-fill"></i>
                    <span>Log in with Google</span>
                </a>
                <p class="text-center">
                    Don't have an account? <a class="text-primary" href="/register">Register</a>
                </p>
            </form>
        </section>
    </div>
</MainLayout>
