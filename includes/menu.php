<?php

use Src\System\DatabaseConnector;
use Src\Gateway\MenuGateway;

$db = (new DatabaseConnector)->getConnection();
$menu_gateway = new MenuGateway($db);

//get all menu items from database
$menu_result = $menu_gateway->get_all();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/menu.css">
    <link rel="stylesheet" href="/assets/css/header.css">
    <title>LALA FOODS</title>
</head>
<body>
    
    <?php include 'header.php'; ?>
    

    <section class="banner">
        <div class="banner-body">
            <div class="banner-content">
                <div class="big-text">
                    <span>Menu</span>
                </div>
                <div class="banner-button">
                    <h3 class="text-white">Our savoury delicacies!</h3>
                </div>
            </div>
        </div>
    </section>

    <section class="product bg-white-green">
        <div class="product-header">
            <h3>Our Collection</h3>
            <span>We bring you the best of bread sandwich recipes and noodles just for you!</span>
        </div>
        <div class="product-main">
        <?php if($menu_result): ?>
            <?php foreach($menu_result as $row): ?>
                <div class="product-card bg-white">
                    <div class="product-img">
                        <img src="<?php echo '/storage/meal_photos//' . $row['file_name']; ?>" alt="">
                    </div>
                    <div class="product-text">
                        <span class="product-name">
                            <?php echo $row['meal_name']; ?>
                        </span>
                        <p class="product-desc">
                            <?php echo 'NGN' . $row['price']; ?>
                        </p>
                    </div>
                    <div class="product-btn">
                        <a href="<?php echo '/checkout?m='.$row['meal_name'].'&q=1&p='.$row['price']; ?>"><button>order online</button></a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="product-card bg-white">
                <div class="product-img" style="background-color: #ccc;">
                    Picture loading...
                </div>
                <div class="product-text">
                    <span class="product-name">
                        No meal yet
                    </span>
                    <p class="product-desc">
                        NGN 0.00
                    </p>
                </div>
                <div class="product-btn">
                    <a href="tel:+234812345678"><button>Call +234812345678</button></a>
                </div>
            </div>
        <?php endif; ?>

    </section>

    <?php include 'footer.php'; ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://js.paystack.co/v1/inline.js"></script>
    <!-- <script src="js/jquery.js"></script> -->
    <script src="assets/js/main.js"></script>
</body>
</html>