<script>
    import axios from 'axios';
    import RegisterSideImage from '../../Assets/Images/register-side-image.png';
    import MainLayout from '../../Layouts/MainLayout.svelte';
    import { inertia } from '@inertiajs/svelte';
    import loading from '../../Stores/Utility/loadingOverlayStore';
    import persistTokenAndRedirect from '@/Helpers/persistTokenAndRedirect';

    let name = '';
    let email = '';
    let password = '';
    let confirmPassword = '';
    let title = 'Register';

    async function handleSubmit() {
        loading.start('Registering...');
        try {
            await axios
                .post('/register', { name, email, password, password_confirmation: confirmPassword })
                .then(({ data: apiToken }) => {
                    loading.stop();
                    persistTokenAndRedirect(apiToken);
                });
        } catch (error) {
            console.log(error);
        } finally {
            loading.stop();
        }
    }
</script>

<MainLayout {title}>
    <div class="flex max-h-screen">
        <section class="register-form flex flex-1 flex-col items-center justify-center gap-9 p-12 md:p-36 lg:px-24">
            <span class="text-3xl font-bold text-primary gap-2 inline-flex">
                <i class="ri-restaurant-fill"></i>
                <p>E-Canteen</p>
            </span>
            <p class="text-xl font-bold">Please fill in your credentials</p>
            <form class="flex flex-col w-full items-end gap-4" on:submit|preventDefault={handleSubmit}>
                <input
                    class="input input-block"
                    type="text"
                    name="name"
                    placeholder="Name"
                    bind:value={name}
                    required
                />
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
                <input
                    class="input input-block"
                    type="password"
                    name="confirmPassword"
                    placeholder="Confirm Password"
                    bind:value={confirmPassword}
                    required
                />
                <button class="btn btn-block btn-primary mt-5" type="submit">Register</button>
                <a href="/auth/google" class="btn btn-block btn-secondary gap-2">
                    <i class="ri-google-fill"></i>
                    <span>Log in with Google</span>
                </a>
                <p class="text-center">
                    Already have account? <a class="text-primary" href="/login" use:inertia>Login</a>
                </p>
            </form>
        </section>
        <img class="hidden lg:flex flex-1 object-cover object-center" src={RegisterSideImage} alt="Left Side" />
    </div>
</MainLayout>
