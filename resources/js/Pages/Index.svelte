<script>
    import { page } from '@inertiajs/svelte';
    import DashboardLayout from '../Layouts/DashboardLayout.svelte';

    const title = 'Home';
    let navbarSubTitle = `Hello ${$page.props.user.name}`;
</script>

<DashboardLayout title="Home" {navbarSubTitle}>
    <div class="h-[1000rem]">Dashboard</div>
</DashboardLayout>
