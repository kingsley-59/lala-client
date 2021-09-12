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
            <div class="alert alert-success">
                <h3>Order Confirmed</h3>
                <p>Your order has been confirmed. Your order id <strong><?php echo $_GET['txn_id'] ?? ''; ?></strong> has been sent to your email. Please do not lose it as that is the ticket to redeeming your order.</p>
                <p>Please make sure you retrieve your order before 09:00pm today.</p>
            </div>
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