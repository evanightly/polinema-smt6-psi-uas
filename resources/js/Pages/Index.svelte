<script>
    import { page } from '@inertiajs/svelte';
    import DashboardLayout from '../Layouts/DashboardLayout.svelte';
    import { onMount } from 'svelte';
    import Chart from 'chart.js/auto';
    import { darkMode } from '../Stores/Utility/darkModeStore';

    let transactionDataStore;
    let transactionYears;
    let transactionYear;
    let chart;

    async function fetchTransactionData() {
        const { data } = await axios.get(`/api/transactions-by-year/${transactionYear}`);
        console.log(data);
        transactionDataStore = data;
    }

    $: {
        transactionYear, fetchTransactionData();
    }

    $: if (transactionDataStore) {
        const ctx = document.getElementById('transaction-chart').getContext('2d');

        const color = $darkMode ? '#fff' : '#000';

        const lineOptions = {
            responsive: true,
            layout: {
                padding: 20,
            },
            scales: {
                x: {
                    ticks: {
                        color,
                    },
                    grid: {
                        drawOnChartArea: false,
                        drawTicks: false,
                    },
                    border: {
                        color,
                    },
                },
                y: {
                    ticks: {
                        color,
                        stepSize: 1,
                    },
                    grid: {
                        drawOnChartArea: false,
                        drawTicks: false,
                    },
                    border: {
                        color,
                    },
                },
            },
            plugins: {
                legend: {
                    display: false,
                },
            },
            elements: {
                point: {
                    radius: 0,
                    hitRadius: 50,
                },
            },
        };

        if (!chart) {
            chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: [],
                    datasets: [
                        {
                            label: '# of Profits',
                            data: [],
                            backgroundColor: ['rgba(255, 99, 132, 0.2)'],
                            fill: true,
                            borderColor: 'rgba(255, 99, 132, 1)',
                        },
                    ],
                },
                options: lineOptions,
            });
        }

        chart.data.labels = transactionDataStore.map(t => t.transaction_date);
        chart.data.datasets[0].data = transactionDataStore.map(t => t.total);
        chart.options = lineOptions;
        chart.update();
    }

    onMount(async () => {
        const { data: transactionYearsResponse } = await axios.get('/api/transaction-years');
        transactionYears = transactionYearsResponse;

        if (transactionYears.length > 0) {
            transactionYear = transactionYears[0];
        }
    });

    const title = 'Home';
    let navbarSubTitle = `Hello ${$page.props.user.name}`;
</script>

<DashboardLayout {title} {navbarSubTitle}>
    <div class="shadow-lg to-backgroundSecondary rounded p-5">
        <div class="flex gap-2">
            <h1 class="text-xl font-bold">Transaction Chart</h1>
            <select bind:value={transactionYear} class="select select-bordered w-fit pr-8">
                {#each transactionYears ?? [] as year}
                    <option value={year}>{year}</option>
                {/each}
            </select>
        </div>
        <canvas id="transaction-chart"></canvas>
    </div>
</DashboardLayout>
