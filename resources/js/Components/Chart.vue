<template>
    <div class="chart-container">
      <canvas :id="chartId"></canvas>
    </div>
  </template>
  
  <script>
  import { ref, onMounted } from 'vue';
  import { Chart } from 'chart.js/auto';
  
  export default {
    props: {
      chartData: Object,
      chartId: String,
      chartType: {
        type: String,
        default: 'bar', // Default to bar chart but can be pie, line, etc.
      },
    },
    setup(props) {
      const chartInstance = ref(null);
  
      onMounted(() => {
        const ctx = document.getElementById(props.chartId).getContext('2d');
        chartInstance.value = new Chart(ctx, {
          type: props.chartType, // Chart type is dynamic
          data: props.chartData,
          options: {
            responsive: true,
            maintainAspectRatio: false, // Disable aspect ratio for better control
          },
        });
      });
  
      return { chartInstance };
    },
  };
  </script>
  
  <style scoped>
  .chart-container {
    width: 100%;
    height: 300px; /* Set a fixed height for better chart behavior */
    position: relative; /* Ensure proper positioning */
  }
  
  canvas {
    height: 100% !important;
    width: 100% !important;
    padding: 5px;
  }
  </style>
  