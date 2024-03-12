<script>
    import axios from 'axios';
    import DashboardLayout from '../Layouts/DashboardLayout.svelte';

    axios.get('api/user').then(response => {
        console.log(response.data);
    });
</script>

<DashboardLayout title="Dashboard">
    <div class="h-[1000rem]">Dashboard</div>
</DashboardLayout>
