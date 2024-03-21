<script>
    import { page } from '@inertiajs/svelte';
    import DashboardLayout from '../Layouts/DashboardLayout.svelte';
    import { onMount } from 'svelte';
    import Chart from 'chart.js/auto';

    let transactionDataStore;

    onMount(async () => {
        const {
            data: { data },
        } = await axios.get('/api/transactions'); // replace with your actual API endpoint

        transactionDataStore = data;
        const ctx = document.getElementById('transaction-chart').getContext('2d');

        // Get the height of the chart
        const chartHeight = ctx.canvas.clientHeight;

        // Create a gradient
        const gradient = ctx.createLinearGradient(0, 0, 0, chartHeight);
        gradient.addColorStop(0, 'rgba(255, 99, 132, 0.5)');
        gradient.addColorStop(1, 'rgba(255, 99, 132, 0)');

        new Chart(ctx, {
            type: 'line', // Change this to the type of chart you want
            data: {
                labels: transactionDataStore.map(t => t.buyer_name), // replace with actual property names
                datasets: [
                    {
                        label: '# of Total Price',
                        data: transactionDataStore.map(t => t.price_total), // replace with actual property names
                        backgroundColor: gradient, // Use the gradient as the background color
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1,
                    },
                ],
            },
            options: {
                title: {
                    display: true,
                    text: 'Transaction Chart',
                },
            },
        });
    });

    const title = 'Home';
    let navbarSubTitle = `Hello ${$page.props.user.name}`;
</script>

<DashboardLayout {title} {navbarSubTitle}>
    <div class="shadow-lg to-backgroundSecondary rounded p-5">
        <h1 class="text-xl font-bold">Transaction Chart</h1>
        <canvas id="transaction-chart"></canvas>
    </div>
</DashboardLayout>
