<?php
// MySQL database connection parameters$database = "your_database";
session_start();
require_once "../config.php";

// Fetch data from MySQL table
$sql = "SELECT id, value FROM demo ORDER BY id DESC LIMIT 20";
$result = mysqli_query($conn, $sql);

// Store data in an array
$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = array(
        "x" => $row["id"],
        "y" => $row["value"]
    );
}

// Convert data to JSON format
$jsonData = json_encode($data);

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Scatter Chart Example</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    #scatterChartContainer {
      width: 800px;
      height: 600px;
    }
  </style>
</head>
<body>
  <div id="scatterChartContainer">
    <canvas id="scatterChart"></canvas>
  </div>

  <script>
    // Pass the PHP data to JavaScript
    var data = <?php echo $jsonData; ?>;
    console.log(data);

    // Render the scatter chart using Chart.js
    var ctx = document.getElementById('scatterChart').getContext('2d');
    new Chart(ctx, {
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
  </script>
</body>
</html>
