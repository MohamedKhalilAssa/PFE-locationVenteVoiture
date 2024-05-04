<template>
  <div class="" style="max-height: 55vh">
    <canvas :id="id" width="400" height="400"></canvas>
  </div>
</template>
<script setup>
import Chart from "chart.js/auto";
import { onMounted } from "vue";
const props = defineProps(["data", "id", "bg", "title"]);
const months = [
  "January",
  "February",
  "March",
  "April",
  "May",
  "June",
  "July",
  "August",
  "September",
  "October",
  "November",
  "December",
];
console.log(props.data);
onMounted(() => {
  const ctx = document.getElementById(`${props.id}`).getContext("2d");
  const labels = [];
  const dataArray = [];
  console.log(props.data);
  props.data.forEach((element) => {
    labels.push(months[element.month - 1]);
    dataArray.push(element.total_announces);
  });

  const data = {
    labels: labels,
    datasets: [
      {
        label: props.title,
        backgroundColor:
          props.bg == 1
            ? ["rgba(75, 192, 192, 0.2)"]
            : ["rgba(255, 99, 132, 0.2)"],
        borderColor:
          props.bg == 1 ? ["rgb(75, 192, 192)"] : ["rgb(255, 99, 132)"],
        borderWidth: 1,
        fill: false,
        data: dataArray,
      },
    ],
  };

  const myChart = new Chart(ctx, {
    type: "bar",
    data: data,
    options: {
      scales: {
        y: {
          beginAtZero: true,
          stepSize: 1, // Ensure y-axis ticks are integers
        },
      },
    },
  });
});
</script>
