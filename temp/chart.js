// Fetch MySQL data using PHP or any server-side language and store it in the `data` variable
const data = [
    { x: 10, y: 20 },
    { x: 15, y: 10 },
    { x: 25, y: 35 },
    // ... more data points
  ];
  
  // Render the scatter chart using Chart.js
  const ctx = document.getElementById('scatterChart').getContext('2d');
  new Chart(ctx, {
    type: 'scatter',
    data: {
      datasets: [
        {
          label: 'Scatter Chart',
          data: data,
          backgroundColor: 'rgba(75, 192, 192, 0.6)', // Adjust colors as needed
        }
      ]
    },
    options: {
      scales: {
        x: {
          type: 'linear', // Specify scale type for the x-axis (linear, logarithmic, etc.)
          position: 'bottom'
        },
        y: {
          type: 'linear', // Specify scale type for the y-axis (linear, logarithmic, etc.)
          position: 'left'
        }
      }
    }
  });
  