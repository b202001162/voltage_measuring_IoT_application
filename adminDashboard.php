<?php
session_start();

// if(isset($_SESSION['user_name'])){
//     if(time() - $_SESSION['user_time_stamp'] > 90) { //subtract new timestamp from the old one
//         unset($_SESSION['user_name'], $_SESSION['user_time_stamp'], $_SESSION['user_loggedin']);
//         header("Location: ./usrLogIn.php"); //redirect to index.php
//         exit;
//     }
// }

// if(isset($_SESSION['admin_name'])){
//     if(time() - $_SESSION['admin_time_stamp'] > 90) { //subtract new timestamp from the old one
//         unset($_SESSION['admin_name'], $_SESSION['admin_time_stamp'], $_SESSION['admin_loggedin']);
//     }
// }

if (!isset($_SESSION['admin_name']) && $_SESSION['admin_loggedin'] !== true) {
    header("location: adminLogIn.php");
}

require_once "allStyle.php";

require_once "config.php";
?>

<?php

// Fetch data from MySQL table
$sql = "SELECT * FROM readings ORDER BY id DESC LIMIT 25";
$result = mysqli_query($conn, $sql);

// Store data in an array
$data1 = array();
$data2 = array();
$data3 = array();
$data4 = array();
$timestamp = array();
while ($row = $result->fetch_assoc()) {
    $timestamp[] = $row["timestamp"];
    $data1[] = $row["value1"];
    $data2[] = $row["value2"];
    $data3[] = $row["value3"];
    $data4[] = $row["value4"];
}

// Convert data to JSON format
$jsonData1 = json_encode($data1);
$jsonData2 = json_encode($data2);
$jsonData3 = json_encode($data3);
$jsonData4 = json_encode($data4);
$jsonTimestamp = json_encode($timestamp);
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        #chart-line {
            /* width: 500px; */
            /* height: 200px; */
        }
    </style>
</head>

<body>
    <div class="dashboard-main-ctn">
        <div class="dashboard-nav-bar">
            <div class="dashboard-nav-bar-logo">
                <img src="img/logo/logo.png" alt="logo" style="height: 46px; width: 46px;">
            </div>
            <div class="dashboard-nav-bar-menu"><a href="./adminDashboard.php"
                    style="color: var(--bs-primary);  align-items: center; display: flex; font-weight: 600; text-decoration: none;"><span
                        class="material-symbols-outlined"
                        style="font-size: 17px; margin-right: 5px; font-weight: 600;">dashboard</span>DASHBOARD</a>
                <button type="button" class="btn bg-box-color"
                    style="box-shadow: none; border: none; color: var(--bs-secondary); display: flex; align-items: center;;"
                    data-toggle="modal" data-target="#myModal"><span class="material-symbols-outlined"
                        style="color: var(--bs-secondary); font-size: 18px; margin-right: 5px; margin-left: 10px; ">devices</span>SENSOR
                    INFO</button>
            </div>
            <div class="dashboard-nav-bar-menu"><a href="./logout.php?user=user"
                    style="color: var(--bs-danger); align-items: center; display: flex; font-weight: 600; text-decoration: none;"><span
                        class="material-symbols-outlined"
                        style="font-size: 17px; margin-right: 5px; font-weight: 600;">logout</span>LOGOUT</a>
            </div>
        </div>
        <div class="dashboard-cnt">



            <!-- New Chart -->
            <div class="col-lg-7" id="chart-ctn-1">
                <div class="card z-index-2">
                    <div class="card-header pb-0">
                        <h6>Sensor Readings 1 (Voltage & Ampere)</h6>
                        <p class="text-sm">
                            <!-- <i class="fa fa-arrow-up text-success"></i> -->
                            <span class="font-weight-bold">ID: 1 Sensor</span> in 2021
                        </p>
                    </div>
                    <div class="card-body p-3">
                        <div class="chart">
                            <canvas id="chart-line" class="chart-canvas"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-7" id="chart-ctn-2">
                <div class="card z-index-2">
                    <div class="card-header pb-0">
                        <h6>Sensor Readings 2 (Temperature & Humidity)</h6>
                        <p class="text-sm">
                            <!-- <i class="fa fa-arrow-up text-success"></i> -->
                            <span class="font-weight-bold">ID: 2 Sensor</span> in 2021
                        </p>
                    </div>
                    <div class="card-body p-3">
                        <div class="chart">
                            <canvas id="chart-line2" class="chart-canvas"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <script>

                console.log(<?php echo $jsonTimestamp; ?>);

                var data1 = <?php echo $jsonData1; ?>;
                var data2 = <?php echo $jsonData2; ?>;
                var data3 = <?php echo $jsonData3; ?>;
                var data4 = <?php echo $jsonData4; ?>;

                var ctx1 = document.getElementById("chart-line").getContext("2d");
                var ctx2 = document.getElementById("chart-line2").getContext("2d");

                var gradientStroke1 = ctx1.createLinearGradient(0, 230, 0, 50);

                gradientStroke1.addColorStop(1, 'rgba(203,12,159,0.2)');
                gradientStroke1.addColorStop(0.2, 'rgba(72,72,176,0.0)');
                gradientStroke1.addColorStop(0, 'rgba(203,12,159,0)'); //purple colors

                var gradientStroke2 = ctx1.createLinearGradient(0, 230, 0, 50);
                gradientStroke2.addColorStop(1, 'rgba(20,23,39,0.2)');
                gradientStroke2.addColorStop(0.2, 'rgba(72,72,176,0.0)');
                gradientStroke2.addColorStop(0, 'rgba(20,23,39,0)'); //purple colors

                var gradientStroke3 = ctx2.createLinearGradient(0, 230, 0, 50);
                gradientStroke3.addColorStop(1, 'rgba(203,12,159,0.2)');
                gradientStroke3.addColorStop(0.2, 'rgba(72,72,176,0.0)');
                gradientStroke3.addColorStop(0, 'rgba(203,12,159,0)'); //purple colors

                var gradientStroke4 = ctx2.createLinearGradient(0, 230, 0, 50);
                gradientStroke4.addColorStop(1, 'rgba(20,23,39,0.2)');
                gradientStroke4.addColorStop(0.2, 'rgba(72,72,176,0.0)');
                gradientStroke4.addColorStop(0, 'rgba(20,23,39,0)'); //purple colors


                // var gradientStroke2 = ctx2.createLinearGradient(0, 230, 0, 50);

                // gradientStroke2.addColorStop(1, 'rgba(20,23,39,0.2)');
                // gradientStroke2.addColorStop(0.2, 'rgba(72,72,176,0.0)');
                // gradientStroke2.addColorStop(0, 'rgba(20,23,39,0)'); //purple colors

                new Chart(ctx2, {
                    type: "line",
                    data: {
                        // labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                        labels: <?php echo $jsonTimestamp; ?>,
                        datasets: [{
                            label: "Temparature",
                            tension: 0.4,
                            borderWidth: 0,
                            pointRadius: 0,
                            borderColor: "#cb0c9f",
                            borderWidth: 3,
                            backgroundColor: gradientStroke3,
                            fill: true,
                            data: data3,
                            maxBarThickness: 6
                        },
                        {
                            label: "Humidity",
                            tension: 0.4,
                            borderWidth: 0,
                            pointRadius: 0,
                            borderColor: "#3A416F",
                            borderWidth: 3,
                            backgroundColor: gradientStroke4,
                            fill: true,
                            data: data4,
                            maxBarThickness: 6
                        }
                        ],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false,
                            }
                        },
                        interaction: {
                            intersect: false,
                            mode: 'index',
                        },
                        scales: {
                            y: {
                                grid: {
                                    drawBorder: false,
                                    display: true,
                                    drawOnChartArea: true,
                                    drawTicks: false,
                                    borderDash: [5, 5]
                                },
                                ticks: {
                                    display: true,
                                    padding: 10,
                                    color: '#b2b9bf',
                                    font: {
                                        size: 11,
                                        family: "Open Sans",
                                        style: 'normal',
                                        lineHeight: 2
                                    },
                                }
                            },
                            x: {
                                grid: {
                                    drawBorder: false,
                                    display: false,
                                    drawOnChartArea: false,
                                    drawTicks: false,
                                    borderDash: [5, 5]
                                },
                                ticks: {
                                    display: false,
                                    color: '#b2b9bf',
                                    padding: 20,
                                    font: {
                                        size: 11,
                                        family: "Open Sans",
                                        style: 'normal',
                                        lineHeight: 2
                                    },
                                }
                            },
                        },
                    },
                });
                new Chart(ctx1, {
                    type: "line",
                    data: {
                        // labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                        labels: <?php echo $jsonTimestamp; ?>,
                        datasets: [{
                            label: "Ampere",
                            tension: 0.4,
                            borderWidth: 0,
                            pointRadius: 0,
                            borderColor: "#cb0c9f",
                            borderWidth: 3,
                            backgroundColor: gradientStroke1,
                            fill: true,
                            data: data1,
                            maxBarThickness: 6

                        },
                        {
                            label: "Voltage",
                            tension: 0.4,
                            borderWidth: 0,
                            pointRadius: 0,
                            borderColor: "#3A416F",
                            borderWidth: 3,
                            backgroundColor: gradientStroke2,
                            fill: true,
                            data: data2,
                            maxBarThickness: 6
                        },
                        ],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false,
                            }
                        },
                        interaction: {
                            intersect: false,
                            mode: 'index',
                        },
                        scales: {
                            y: {
                                grid: {
                                    drawBorder: false,
                                    display: true,
                                    drawOnChartArea: true,
                                    drawTicks: false,
                                    borderDash: [5, 5]
                                },
                                ticks: {
                                    display: true,
                                    padding: 10,
                                    color: '#b2b9bf',
                                    font: {
                                        size: 11,
                                        family: "Open Sans",
                                        style: 'normal',
                                        lineHeight: 2
                                    },
                                }
                            },
                            x: {
                                grid: {
                                    drawBorder: false,
                                    display: false,
                                    drawOnChartArea: false,
                                    drawTicks: false,
                                    borderDash: [5, 5]
                                },
                                ticks: {
                                    display: false,
                                    color: '#b2b9bf',
                                    padding: 20,
                                    font: {
                                        size: 11,
                                        family: "Open Sans",
                                        style: 'normal',
                                        lineHeight: 2
                                    },
                                }
                            },
                        },
                    },
                });
            </script>
        </div>



        <!-- Modal -->
        <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">SENSOR INFORMATION</h4>
                        <button type="button" class="close" data-dismiss="modal"
                            style="border: none; background: none;">&times;</button>
                    </div>
                    <div class="modal-body">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>






        <!-- Modal -->
</body>

</html>




<script>
    console.log(<?php echo $result; ?>);
</script>