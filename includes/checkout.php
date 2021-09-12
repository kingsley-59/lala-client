<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/header.css">
    <link rel="stylesheet" href="assets/css/checkout.css">
    <title>Checkout | Lala Healthy Foods</title>
</head>
<body>
    
    <?php include 'header.php'; ?>


    <section class="banner">
        <div class="banner-body">
            <div class="banner-content">
                <div class="big-text">
                    <span>Checkout</span>
                </div>
                <div class="banner-button">
                    <h3 class="text-white">Checkout in three easy steps!</h3>
                </div>
            </div>
        </div>
    </section>

    
    <section class="personal-info">
        <div class="personal-info-header">
            <h3>Personal Info</h3>
        </div>
        <div class="personal-info-main">
            <form action="">
                <div class="form-group">
                    <input type="text" name="name" id="name" class="form-control" placeholder="enter your name" required>
                </div>
                <div class="form-group">
                    <input type="email" name="email" id="email" class="form-control" placeholder="enter your email" required>
                </div>
                <div class="form-group">
                    <input type="tel" name="phone" id="phone" class="form-control" placeholder="enter your phone no" required>
                </div>
                <div class="form-group">
                    <label for="male" class="radio-inline"><input type="radio" name="gender" id="male" value="male">Male</label>
                    <label for="female" class="radio-inline"><input type="radio" name="gender" id="female" value="female">Female</label>
                    
                </div>
            </form>
        </div>
    </section>
    <hr>
    <section id="order-details">
        
        <div class="order-details">
            
            <table class="table table-bordered" id="cart-table">
                <h3 style="padding-top:20px">Your Cart</h3>
                <tr>
                    <th>Meal</th>
                    <th>Quantity</th>
                    <th>remove</th>
                </tr>
                
                <tr>
                    <td><?php echo $_GET['m'] ?? "no order yet" ; ?></td>
                    <td><?php echo $_GET['q'] ?? 0; ?></td>
                    <td><button class="btn-danger remove-order" onclick="remove_order(this)">&times;</button></td>
                </tr>
                
            </table>
            <div class="form-group">
                <label for="total-amount">Grand Total(NGN)</label>
                <input type="number" name="total-amount" id="total-amount" value="<?php echo $_GET['p'] ?? 0; ?>" disabled>
            </div>
            <div class="add-order-btn">
                <p>Add more items to your cart </p>
            </div>
            <div class="add-order">
                <table class="table">
                    <tr>
                        <td>
                            <select class="form-control" name="meal" id="select-meal">
                                <option value="0">choose a recipe</option>
                                <option value="meshai special">Meshai special</option>
                                <option value="noodles special">Noodles special</option>
                                <option value="meshai supreme">Meshai supreme</option>
                                <option value="meshai delight">Meshai delight</option>
                                <option value="noodles delight">Noodles delight</option>
                                <option value="meshai deluxe">Meshai delight</option>
                                <option value="noodles deluxe">Noodles delight</option>
                                <option value="meshai super">Meshai super</option>
                                <option value="noodles dibia">Noodles dibia</option>
                            </select>
                        </td>
                        <td>
                            <input type="number" name="qty" id="select-qty" value="0" class="form-control" placeholder="how many?">
                        </td>
                        <td>
                            <button class="form-control btn-success" id="add-order-btn">Add</button>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="next-btn text-right">
                <div class="alert alert-info" style="margin-bottom: 0;">
                    Done adding to cart? <button class="btn btn-primary" id="next-btn">Next</button>
                </div>
                
            </div>
        </div>

        <div class="delivery-option" id="delivery-details">
            <h3>Delivery Details</h3>
            <table class="table">
                <tr>
                    <td>
                        <select name="delivery-option" class="form-control" id="delivery-option">
                            <option value="0">Choose delivery option</option>
                            <option value="store pickup">pickup at nearest store</option>
                            <option value="home delivery">bring it to my house</option>
                        </select>
                    </td>
                    <td>
                        <button class="btn btn-success" id="delivery-ok-btn">Ok</button>
                    </td>
                </tr>
            </table>
            <div class="delivery-direction" id="delivery-direction">
                <div id="direction-alert">

                </div>
                <div class="delivery-form" id="delivery-form">
                    <form action="" method="POST">
                        <div class="form-group" id="delivery-location">
                            <label for="delivery-location">Choose Delivery location</label>
                            <input list="delivery-areas" type="text" name="delivery-area" id="delivery-area" class="form-control" required>
                            <datalist id="delivery-areas">
                                <option value="Hostel">
                                <option value="Umuchima">
                                <option value="Eziobodo">
                                <option value="Ihiagwa">
                            </datalist>
                        </div>
                        <div class="form-group">
                            <label for="location-name">Name of hostel/lodge</label>
                            <input type="text" name="location-name" id="location-name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="location-desc">Additional description of location</label>
                            <textarea name="" id="location-desc" cols="30" rows="10" class="form-control" required></textarea>
                        </div>
                        <div class="form-group text-right">
                            <input type="submit" value="Checkout" id="checkout-btn" class="btn btn-success form-checkout-btn">
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </section>

    <?php include 'footer.php'; ?>

    <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="https://js.paystack.co/v1/inline.js"></script>
    <script src="/assets/js/main.js"></script>
    <script src="/assets/js/checkout.js"></script>
    
</body>
</html>