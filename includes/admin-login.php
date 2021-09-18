<?php

// Include the database configuration file

use Src\System\DatabaseConnector;
use Src\Gateway\UserGateway;

$db = (new DatabaseConnector)->getConnection();
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$userGateway = new UserGateway($db, 'admins');

$admin_list = $userGateway->get_admin_users();

// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome.php");
    exit;
}

$process_result = (isset($_POST['email'])) ? process_request($userGateway, $admin_list) : '';
echo $process_result;

function process_request($userGateway, $admin_list){
    if(isset($_POST['email']) && !empty($_POST['email'])){
        
        $email = $_POST['email'];
        $pswd = trim($_POST['pswd']);

        $verify_inputs = validate_email($email);

        if($verify_inputs != true){
            return $verify_inputs;
        }

        $get_pswd = email_exists($email, $admin_list);
        if($get_pswd){
            if(password_verify($pswd, $get_pswd)){
                $_SESSION["loggedin"] = true;
                $_SESSION["email"] = $email;
                // Redirect user to admin page
                header("location: /admin");
            }else{
                return "Incorrect password. Please try again.";
            }
        }else{
            return "Email does not exist!";
        }


    }else{
        return 'Email is empty!';
    }
}

function validate_email($email){
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        return 'Invalid email!';
    }

    return true;
}

function email_exists($email, $admin_list){
    if(!is_array($admin_list)){
        return false;
    }

    foreach($admin_list as $rows){
        if($email == $rows['email']){
            return $rows['pswd'];
        }
    }

    return false;
}


?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/header.css">
    <link rel="stylesheet" href="/assets/css/admin.css">
    <style>
        .banner {
            padding: 0;
            width: 100%;
            height: 60vh;
            display: flex;
            justify-content: center;
            align-items: flex-end;
            background-image: url(/assets/img/banner1.jpg);
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .banner-body {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .banner-content {
            margin: auto;
            max-width: 800px;
            height: auto;
        }

        .big-text {
            text-align: left;
        }

        .big-text span {
            font-family: 'Oswald', sans-serif;
            font-weight: 400;
            font-size: 48px;
            color: white;
            text-align: center;
        }

        .banner-button {
            width: 100%;
            text-align: left;
        }

        .banner-button button {
            width: 200px;
            height: auto;
            padding: 8px 10px;
            margin: auto;
            background-color: #974C06;
            border: none;
            border-radius: 0;
            font-size: 18px;
            font-weight: 500;
        }

        .login-form{
            margin: auto;
        }
    </style>
    <script src="https://kit.fontawesome.com/114be06a79.js" crossorigin="anonymous"></script>
    <title>Admin Login | Lala Healthy Foods</title>
</head>

<body>

    <?php include 'header.php'; ?>

    <section class="banner">
        <div class="banner-body">
            <div class="banner-content">
                <div class="big-text">
                    <span>Login</span>
                </div>
                <div class="banner-button">
                    <h3 class="text-white">Admins only!</h3>
                </div>
            </div>
        </div>
    </section>

    <section class="login-page">
        <div class="header text-center">
            <h2>Login</h2>
        </div>
        <div class="login-form">
            <form action="/admin-login" method="post">
                <div class="form-group">
                    <input type="email" name="email" id="login_email" class="form-control" placeholder="your email" required>
                </div>
                <div class="form-group">
                    <input type="password" name="pswd" id="login_pswd" class="form-control" placeholder="password" required>
                </div>
                <div class="form-group text-center">
                    <input type="submit" value="Login" class="btn btn-success">
                </div>
            </form>
        </div>
    </section>

    <?php include 'footer.php'; ?>

    <script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="/assets/js/main.js"></script>
    <script src="assets/js/admin.js"></script>
</body>

</html>