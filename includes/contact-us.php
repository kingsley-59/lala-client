<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/contact.css">
    <link rel="stylesheet" href="/assets/css/header.css">
    <title>LALA FOODS</title>
</head>
<body>
    
    <?php include 'header.php'; ?>
    

    <section class="banner">
        <div class="banner-body">
            <div class="banner-content">
                <div class="big-text">
                    <span>Contact Us</span>
                </div>
                <div class="banner-button">
                    <h3 class="text-white">Get in touch!</h3>
                </div>
            </div>
        </div>
    </section>


    <section id="contact-form">
        <div class="contact-form">
            <div class="contact-form-header">
                <h3>Send us a Message</h3>
            </div>
            <div class="contact-main">
                <form action="">
                    <div class="form-group">
                        <label for="sender-name">Name: </label>
                        <input type="text" name="name" id="sender-name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="sender-email">Email: </label>
                        <input type="email" name="email" id="sender-email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="sender-phone">Phone: </label>
                        <input type="tel" name="phone" id="sender-phone" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="sender-message">Message: </label>
                        <textarea name="message" id="sender-message" class="form-control" cols="30" rows="10"></textarea>
                    </div>
                    <div class="form-group text-center">
                        <input type="submit" id="send-msg-btn" class="btn btn-success" value="Send Message">
                    </div>
                </form>
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