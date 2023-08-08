// Function to update the scatter chart with runtime data
function updateChart() {
    // Make an AJAX request to fetch runtime data
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
      if (xhr.readyState === 4 && xhr.status === 200) {
        // Parse the received JSON data
        var newData = JSON.parse(xhr.responseText);
  
        // Update the scatter chart with the new data
        scatterChart.data.datasets[0].data = newData;
  
        // Update the chart
        scatterChart.update();
      }
    };
  
    // Specify the URL to fetch the runtime data (PHP script or API endpoint)
    var url = "./chartApi.php";
  
    // Send the AJAX request
    xhr.open("GET", url, true);
    xhr.send();
  }
  
  // Render the initial scatter chart using Chart.js
  var ctx = document.getElementById('scatterChart').getContext('2d');
  var scatterChart = new Chart(ctx, {
    type: 'scatter',
    data: {
      datasets: [{
        label: 'Scatter Chart',
        data: data,
        backgroundColor: 'rgba(75, 192, 192, 0.6)'
      }]
    },
    options: {
      scales: {
        x: {
          type: 'linear',
          position: 'bottom'
        },
        y: {
          type: 'linear',
          position: 'left'
        }
      }
    }
  });
  
  // Update the chart every X seconds (adjust the interval as needed)
  setInterval(updateChart, 5000); // Update every 5 seconds
  