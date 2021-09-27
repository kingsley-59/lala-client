<?php

use Src\System\DatabaseConnector;
use Src\Gateway\ReviewGateway;

$db = (new DatabaseConnector)->getConnection();
$review_gateway = new ReviewGateway($db);

$reviewer_name = (isset($_POST['name'])) ? $_POST['name'] : '';
$reviewer_email = (isset($_POST['email'])) ? $_POST['email'] : '';
$review_msg = (isset($_POST['review'])) ? $_POST['review'] : '';

$response = '';
$input = array();

if(!empty($reviewer_name) && !empty($reviewer_email) && !empty($review_msg)){
    //save review to database
    $input['name'] = $reviewer_name;
    $input['email'] = $reviewer_email;
    $input['review'] = $review_msg;
    $result = $review_gateway->insert($input);

    if($result == '1'){
        $status = true;
    }else{
        $status = false;
    }

    $error_msg = "
    <div class='alert alert-danger'> Sorry, there was an error saving your review. Please try again.</div>
    ";
    $success_msg = "
    <div class='alert alert-success'>Thanks alot <strong>$reviewer_name</strong> for your review! We are so happy to have you.</div>
    ";

    $response = ($status == true) ? $success_msg : $error_msg;
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/about.css">
    <link rel="stylesheet" href="/assets/css/header.css">
    <title>Thank You | Lala Healthy Foods</title>
</head>
<body>
    
    <?php include 'header.php'; ?>

    <section class="banner">
        <div class="banner-body">
            <div class="banner-content">
                <div class="big-text">
                    <span>Thank You.</span>
                </div>
                <div class="banner-button">
                    <h3 class="text-white">Nice doing business with you!</h3>
                </div>
            </div>
        </div>
    </section>


    <section>
        <div class="about">
            <?php if(isset($_GET['txn_id']) && !empty($_GET['txn_id'])): ?>
            <div class="alert alert-success">
                <h3>Order Confirmed</h3>
                <p>Your order has been confirmed. Your order id <strong><?php echo $_GET['txn_id'] ?? ''; ?></strong> has been sent to your email. Please do not lose it as that is the ticket to redeeming your order.</p>
                <p>Please make sure you retrieve your order before 09:00pm today.</p>
            </div>
            <?php endif; ?>

            <div class="review-form">
            <div class="review-form-header">
                <h3>Please leave a review</h3>
            </div>
            <form action="/confirmation" method="post">
                <div class="form-group">
                    <input type="text" name="name" id="" class="form-control" placeholder="your name" required>
                </div>
                <div class="form-group">
                    <?php $customer_email = (isset($_GET['txn_email'])) ? $_GET['txn_email'] : ''; ?>
                    <input type="email" name="email" id="" class="form-control" value="<?php echo $customer_email; ?>" placeholder="your email" required>
                </div>
                <div class="form-group">
                    <textarea name="review" id="" class="form-control" cols="30" rows="10" required></textarea>
                </div>
                <div class="form-group text-center">
                    <input type="submit" value="Okay!" class="btn btn-success">
                </div>
            </form>
        </div>

        <?php echo $response; ?>
        </div>      
    </section>

    
    <?php include 'footer.php'; ?>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://js.paystack.co/v1/inline.js"></script>
    <!-- <script src="js/jquery.js"></script> -->
    <script src="assets/js/main.js"></script>
</body>
</html>