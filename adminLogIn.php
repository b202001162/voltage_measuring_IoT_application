<?php
//This script will handle login
session_start();



// check if the user is already logged in
if (isset($_SESSION['admin_name']) && $_SESSION['admin_loggedin'] === true) {
    header("location: ./adminDashboard.php");
    exit;
}
require_once "config.php";
require_once "allStyle.php";

$admin_name = $password = "";
$err = "";

// if request method is post
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (empty(trim($_POST['username'])) || empty(trim($_POST['password']))) {
        $err = "Please enter admin_name + password";
    } else {
        $admin_name = trim($_POST['username']);
        $password = trim($_POST['password']);
    }


    if (empty($err)) {

        $sql = "SELECT * FROM admin WHERE admin_name='$admin_name' AND password='$password'";

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) === 1) {

            $row = mysqli_fetch_assoc($result);

            if ($row['admin_name'] === $admin_name && $row['password'] === $password) {

                $_SESSION['admin_name'] = $row['admin_name'];

                // $_SESSION['id'] = $row['id'];
                $_SESSION['admin_loggedin'] = true;

                $_SESSION['admin_time_start'] = time();

                //Redirect user to welcome page
                header("location: adminDashboard.php");
            }
        }
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./CSS/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <title>LogIn</title>
</head>
<body>
    <div class="UsrLogInCtn">
        <div class="UsrLogInCtn__form">
            <h4 >User Log In</h4>
            <hr style="width: 90%; margin-bottom: 4vh;">
            <!-- action="usrLogIn.php" method="post" -->
            <form class="UsrLogInFormCls" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" novalidate>
                <div class="form-group">
                  <label for="exampleInputEmail1">Admin username</label>
                  <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter email" name="username" required>
                  <small class="text-danger"><? $usr_usrnm_email_err;  ?></small>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Password</label>
                  <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="password" required>
                  <small class="text-danger"><? $user_login_err;  ?></small>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
                <small class="text-danger"><? $user_login_err;  ?></small>
              </form>
        </div>
    </div>
</body>
</html>