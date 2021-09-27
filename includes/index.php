<?php

use Src\System\DatabaseConnector;
use Src\Gateway\MenuGateway;
use Src\Gateway\ReviewGateway;

$db = (new DatabaseConnector)->getConnection();
$menu_gateway = new MenuGateway($db);
$review_gateway = new ReviewGateway($db);

//get all menu items from database
$menu_result = $menu_gateway->get_all();
$reviews = $review_gateway->get_all();


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/header.css">
    <link rel="stylesheet" href="/assets/css/style.css">
    <script src="https://kit.fontawesome.com/114be06a79.js" crossorigin="anonymous"></script>
    <title>Lala Healthy Foods | Healthy Nutrition Good for You!</title>
</head>

<body>

    <?php include 'header.php'; ?>

    <section class="banner">
        <div class="banner-body">
            <div class="banner-content">
                <div class="big-text">
                    <span>Taste the Goodness of a Healthy Delicious Meal.</span>
                </div>
                <div class="banner-button">
                    <a href="/checkout"><button class="text-white">Place Order Now</button></a>
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
                            <? echo 'NGN' . $row['price']; ?>
                        </p>
                    </div>
                    <div class="product-btn">
                        <a href="<?php echo '/checkout?m='.$row['meal_name'].'q=1' ?>"><button>order online</button></a>
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

    <section class="process bg-white-brown">
        <div class="process-header">
            <h3>No More Waiting!</h3>
            <span>Hungry? No need standing and waiting for your turn to get your order. In few click, your belly will be rejoicing. Few clicks will do the job</span>
        </div>

        <div class="procedure">
            <div class="procedure-item bg-white" id="search">
                <div><img src="/assets/img/icons/search-food.svg" alt=""></div>
                <h3>1. Choose Recipe</h3>
                <p>Choose the sauce that suites the season. Click the button and head to checkout.</p>
            </div>
            <div class="procedure-item bg-white" id="order-n-pay">
                <div><img src="/assets/img/icons/order-n-pay.svg" alt=""></div>
                <h3>2. Order & Pay</h3>
                <p>Manage your order most effortlessly and pay with our most secure payment gateway</p>
            </div>
            <div class="procedure-item bg-white" id="delivery">
                <div><img src="/assets/img/icons/pickup.svg" alt=""></div>
                <h3>3. Delivery & Pickup</h3>
                <p>Have your meal delivered Hot and Fast or Self Pick at the nearest store. Enjoy!!!</p>
            </div>
        </div>
    </section>

    <section class="openhours-et-location">
        <div class="openhours">
            <div class="openhours-header">
                <h3>We Are OPEN!</h3>
                <span></span>
            </div>
            <div class="openhours-main">
                <table class="table">
                    <tr>
                        <td>Monday</td>
                        <td>Open</td>
                        <td>8:00am - 9:00pm</td>
                    </tr>
                    <tr>
                        <td>Tuesday</td>
                        <td>Open</td>
                        <td>8:00am - 9:00pm</td>
                    </tr>
                    <tr>
                        <td>Wednesday</td>
                        <td>Open</td>
                        <td>8:00am - 9:00pm</td>
                    </tr>
                    <tr>
                        <td>Thursday</td>
                        <td>Open</td>
                        <td>8:00am - 9:00pm</td>
                    </tr>
                    <tr>
                        <td>Friday</td>
                        <td>Open</td>
                        <td>8:00am - 9:00pm</td>
                    </tr>
                    <tr>
                        <td>Saturday</td>
                        <td>Open</td>
                        <td>8:00am - 9:00pm</td>
                    </tr>
                    <tr>
                        <td>Sunday</td>
                        <td>Closed</td>
                        <td>-:-- - -:--</td>
                    </tr>
                </table>
            </div>

        </div>

        <div class="location">
            <div class="location-header">
                <h3>Visit Our SHOP</h3>
            </div>
            <div class="map-container" id="map-container">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1582.665272073107!2d6.998201657837593!3d5.3895919990227155!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNcKwMjMnMjIuNSJOIDbCsDU5JzU3LjUiRQ!5e1!3m2!1sen!2sus!4v1629997904608!5m2!1sen!2sus" id="main-map" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
            <div class="location-main">
                <p><i>You can use the <a href="https://goo.gl/maps/qvbg49p8VQMZHJVx7">google maps</a> to get directions or call <a href="tel:+">+2348141971579</a> to talk with a customer care staff</i></p>
            </div>
        </div>
    </section>


    <section class="reviews">
        <div class="reviews-heading">
            <h3>WHAT CUSTOMERS ARE SAYING</h3>
        </div>
        <div class="container-main">
            <?php if($reviews): ?>
                <?php foreach($reviews as $row): ?>
                    <div class="review">
                        <p>
                            <?php echo $row['review']; ?>
                        </p>
                        <span><?php echo $row['name'] ?></span>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="review">
                        <p>
                            Very delicious meal. I've tasted every one of them. You just can't wait to taste the delight!
                        </p>
                        <span>David Martins</span>
                    </div>
            <?php endif; ?>
        </div>
    </section>

    <?php include 'footer.php'; ?>

    <script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAAqj_41kB7ryl9iUQAYiwm9Jy27F1mmgk&callback=create_map"></script>
    <script src="assets/js/main.js"></script>
    <script src="assets/js/maps.js"></script>
</body>

</html>