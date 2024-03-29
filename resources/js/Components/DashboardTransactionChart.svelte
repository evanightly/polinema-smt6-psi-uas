<script>
    import { onMount } from 'svelte';
    import Chart from 'chart.js/auto';

    let transactionDataStore;
    let transactionYears;
    let transactionYear;
    let chart;

    async function fetchTransactionData() {
        const { data } = await axios.get(`/api/transactions-by-year/${transactionYear}`);
        transactionDataStore = data;
    }

    $: {
        transactionYear, fetchTransactionData();
    }

    $: if (transactionDataStore) {
        const ctx = document.getElementById('transaction-chart').getContext('2d');

        const color = '#fff';

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
                            label: '# of Profits (Rp)',
                            data: [],
                            backgroundColor: ['rgba(255, 99, 132, 0.2)'],
                            fill: true,
                            borderColor: 'rgba(255, 255, 255, 1)',
                            tension: 0.4,
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
</script>

<div class="mt-8 shadow-lg rounded-xl bg-gradient-to-tr from-blue-500 to-purple-500 p-5">
    <div class="flex gap-2 items-center justify-between">
        <h1 class="text-xl font-bold text-white">Transaction Chart</h1>
        <select bind:value={transactionYear} class="select bg-white border-0 text-black w-fit pr-8">
            {#each transactionYears ?? [] as year}
                <option value={year}>{year}</option>
            {/each}
        </select>
    </div>
    <canvas id="transaction-chart"></canvas>
</div>
