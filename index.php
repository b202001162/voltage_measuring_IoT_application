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

if (!isset($_SESSION['user_name']) && $_SESSION['user_loggedin'] !== true) {
    header("location: usrLogIn.php");
}

require_once "allStyle.php";

require_once "config.php";
?>

<?php

// Fetch data from MySQL table
$sql = "SELECT id, value FROM demo ORDER BY id DESC LIMIT 50";
$result = mysqli_query($conn, $sql);

// Store data in an array
$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = array(
        "x" => $row["id"],
        // Convert to milliseconds
        "y" => $row["value"]
    );
}

// Convert data to JSON format
$jsonData = json_encode($data);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>

<body>
    <div class="dashboard-main-ctn">
        <div class="dashboard-nav-bar">
            <div class="dashboard-nav-bar-logo">
                <img src="img/logo/logo.png" alt="logo" style="height: 46px; width: 46px;">
            </div>
            <div class="dashboard-nav-bar-menu"><a href="./logout.php?user=user"
                    style="color: var(--bs-danger); color: var(--bs-danger); align-items: center; display: flex; font-weight: 600; text-decoration: none;"><span
                        class="material-symbols-outlined"
                        style="font-size: 17px; margin-right: 5px; font-weight: 600;">logout</span>LOGOUT</a>
            </div>
        </div>
        <div class="dashboard-cnt">
            <div class="responsive_grid_container">
                <?php
                // COUNT
                require_once "pagination.php";
                $sql = "SELECT COUNT(*) FROM demo";
                $result = mysqli_query($conn, $sql);
                $r = mysqli_fetch_row($result);
                $numrows = $r[0];

                $rowsperpage = PAGINATION;
                $totalpages = ceil($numrows / $rowsperpage);

                $page = 1;
                if (isset($_GET['page']) && is_numeric($_GET['page'])) {
                    $page = (INT) $_GET['page'];
                }

                if ($page > $totalpages) {
                    $page = $totalpages;
                }

                if ($page < 1) {
                    $page = 1;
                }
                $offset = ($page - 1) * $rowsperpage;

                $sql = "SELECT * FROM demo ORDER BY id DESC LIMIT $offset, $rowsperpage";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) < 1) {
                    echo '<div class="w3-panel  w3-card-2 w3-round bg-box-color text-color p-2 ps-4 px-4">Currently databse is empty!</div>';
                } else {
                    while ($row = mysqli_fetch_assoc($result)) {

                        $id = htmlentities($row['id']);
                        $csv = htmlentities(strip_tags($row['value']));
                        $time = htmlentities($row['timeStamp']);
                
                        echo '<div class="w3-panel w3-card-2 rounded-2" id="post_container_box">';
                        echo "<h6 style='color: var(--primary-color);'>Serial No: $id</h6>";
                        echo "<p style='color:var(--primary-color); margin-bottom: 0.2rem;'> Sensed Value: " . $csv . "</p>";
                        // echo "<p style='color:var(--primary-color);'> Sensing Limit: $usv </p>";
                        // echo "<p style='color:var(--primary-color);'> Status: " . $status . "</p>";
                        echo "<div class=''  style='color: var(--secondary-color);  font-weight: 500; font-size: small;'> $time </div>";
                        // if (!isset($_SESSION['admin_name'])) {
                        //     echo '<button type="button" class="btn bg-box-color" style="box-shadow: none;"  data-toggle="modal" data-target="#myModal"><span class="material-symbols-outlined" style="color: var(--secondary-color);">edit_note</span></button>';
                        // }
                        echo '</div>';
                    }


                    echo "</div><p><div class='w3-bar w3-center' id='footer_slider'>";

                    if ($page > 1) {
                        echo "<a href='?page=1' class='w3-btn' style='background-color: var(--primary-color); color:var(--bg-color); margin-right:5px;  border-radius: 5px;'>&laquo;</a>";
                        $prevpage = $page - 1;
                        echo "<a href='?page=$prevpage' class='w3-btn' style='background-color: var(--primary-color); color:var(--bg-color); margin-right:5px;  border-radius: 5px;'><</a>";
                    }

                    $range = 5;
                    for ($x = $page - $range; $x < ($page + $range) + 1; $x++) {
                        if (($x > 0) && ($x <= $totalpages)) {
                            if ($x == $page) {
                                echo "<div class='w3-button' style='background-color:var(--bg-color); color:var(--primary-color); margin: 5px 5px; border: solid .5px; border-radius: 5px;'>$x</div>";
                            } else {
                                echo "<a href='?page=$x' class='w3-button' style='background-color: var(--primary-color); color:var(--bg-color); margin: 5px 5px;  border-radius: 5px;'>$x</a>";
                            }
                        }
                    }

                    if ($page != $totalpages) {
                        $nextpage = $page + 1;
                        echo "<a href='?page=$nextpage' class='w3-button' style='background-color: var(--primary-color); color:var(--bg-color); margin: 5px 5px;  border-radius: 5px;'>></a>";
                        echo "<a href='?page=$totalpages' class='w3-btn' style='background-color: var(--primary-color); color:var(--bg-color); margin: 5px 5px;  border-radius: 5px;'>&raquo;</a>";
                    }
                    echo "</div></p>";
                }
                echo "</div>";
                ?>

            </div>
        </div>








        <!-- Modal -->
        <!-- <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Change Sensing Value</h4>
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
        </div> -->
</body>

</html>