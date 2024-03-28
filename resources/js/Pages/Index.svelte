<script>
    import DashboardTransactionChart from "../Components/DashboardTransactionChart.svelte";
    import DashboardLayout from "../Layouts/DashboardLayout.svelte";
    import { page } from "@inertiajs/svelte";
    const title = "Home";
    let navbarSubTitle = `Hello ${$page.props.user.name}`;
</script>

<DashboardLayout {title} {navbarSubTitle}>
    <DashboardTransactionChart />
</DashboardLayout>
