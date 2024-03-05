<script>
    import LoginSideImage from "../Assets/Images/login-side-image.png";
</script>

<div class="flex">
    <img class="hidden lg:block" src={LoginSideImage} alt="Left Side" />

    <section
        class="login-form flex flex-col flex-1 items-center justify-center gap-9 p-36 lg:p-80"
    >
        <span class="text-3xl font-bold text-primary gap-2 inline-flex">
            <i class="ri-restaurant-fill"></i>
            <p>E-Canteen</p>
        </span>
        <p class="text-xl font-bold">Log in to your account</p>
        <form class="flex flex-col w-full items-end gap-4" action="">
            <input class="input input-block" type="email" placeholder="Email" />
            <input
                class="input input-block"
                type="password"
                placeholder="Password"
            />
            <a class="text-primary" href="/forgot">Forgot your password?</a>
            <button class="btn btn-block btn-primary mt-5" type="submit">
                Log in
            </button>
        </form>
    </section>
</div>
