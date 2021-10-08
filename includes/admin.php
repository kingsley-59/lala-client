<?php

// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: /admin-login");
    exit;
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- <link rel="stylesheet" href="css/slick-slider.css"> -->
    <link rel="stylesheet" href="/assets/css/header.css">
    <link rel="stylesheet" href="/assets/css/admin.css">
    <script src="https://kit.fontawesome.com/114be06a79.js" crossorigin="anonymous"></script>
    <title>Dashboard | Lala Healthy Foods</title>
</head>
<body>
    
    <?php include 'header.php'; ?>

    <div class="nav-toggle" style="display: none;">
        <span><i class="fa fa-arrow-right"></i></span>
    </div>

    <nav class="side-nav" id="side-nav">
        <div class="admin-nav">
            <div class="dashboard">
                <a href="?">Dashboard</a>
            </div>
            <div class="dashboard">
                <a href="?admin-page=menu">Menu</a>
            </div>
            <div class="users">
                <a href="?admin-page=users">Users</a>
            </div>
            <div class="users">
                <a href="?admin-page=manage-admin">Manage Admins</a>
            </div>
            <div class="txns">
                <a href="?admin-page=orders">Orders</a>
            </div>
            <div class="txns">
                <a href="?admin-page=reviews">Manage Reviews</a>
            </div>
            <div class="email">
                <a href="?admin-page=compose-email">Compose email</a>
            </div>
        </div>
        <div class="admin-info">
            <p>James Charles</p>
            <span class="online">Online </span>
            <div class="logout">
                <a href="/logout" style="color: #fff; text-decoration: none;cursor:pointer;">Logout</a>
            </div>
        </div>
        
    </nav>

    <main>
        


        <?php if(isset($_GET["admin-page"])): ?>

            <?php include 'admin-includes/' . $_GET["admin-page"] . '.php' ; ?>

        <?php else: ?>

            <?php include 'admin-includes/dashboard.php' ; ?>

        <?php endif; ?>
    </main>

    <script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAAqj_41kB7ryl9iUQAYiwm9Jy27F1mmgk&callback=create_map"></script>
    <script src="/assets/js/main.js"></script>
    <script src="assets/js/admin.js"></script>
</body>
</html>