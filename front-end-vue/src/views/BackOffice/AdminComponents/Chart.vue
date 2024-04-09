<template>
    <canvas id="myChart" width="400" height="400"></canvas>
</template>
<script setup>
import Chart from 'chart.js/auto';
import { onMounted } from 'vue';
onMounted(() => {
    const ctx = document.getElementById('myChart').getContext('2d');
    const labels = ['January', 'February', 'March', 'April'];
    const data = {
        labels: labels,
        datasets: [{
            label: 'Sales',
            backgroundColor: ['rgba(255, 99, 132, 0.2)', 'rgba(255, 159, 64, 0.2)', 'rgba(255, 205, 86, 0.2)', 'rgba(75, 192, 192, 0.2)'],
            borderColor: 'rgba(255, 99, 132, 1)',
            data: [10, 20, 30, 45],
        }]
    };

    const myChart = new Chart(ctx, {
        type: 'bar',
        data: data,
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
})

</script>