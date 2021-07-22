<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">

    <title>LALA FOODS</title>
</head>
<body>
    <header>
        <div id="header-menu" class="header-menu">
            <a href="javascript:void(0)" class="closemenubtn" onclick="closeMenu()">&times;</a>

            <div class="menu-overlay">
                <a href="#">Who we are</a>
                <a href="#">Our produts</a>
                <a href="#">Gallery</a>
                <a href="#">Contact Us</a>
            </div>
        </div>
        <div class="logo">
            <!-- <img src="img/LALA Foods Logo.png" alt="" width="100px" height="100px"> -->
            <span>logo</span>
        </div>
        <div class="logo-name">
            <span href="/" style="color: green;"><span style="color: brown;">LALA</span> FOODS</span>
        </div>
        <div class="menu">
            <a href="javascript:void(0)" onclick="openMenu()">&#9776;</a>
        </div>
    </header>
    <section>
        <div class="header-writeup">
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Unde distinctio maxime eos molestiae beatae officia exercitationem autem ullam maiores, ut, consectetur veniam. Nam omnis iste expedita? Beatae vero assumenda cum at soluta nobis corrupti quod!
        </div>
        <div class="cta">
            <!-- <button>Make Order Now</button> -->
            <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Make Order Now</button>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">
    
            <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Lala Foods - Checkout</h4>
                    </div>
                    <div class="modal-body">
                        <div class="checkout">
                            <form action="" id="paymentForm" class="checkoutform">
                                <div class="form-group">
                                    <label for="email">Email Address</label>                         <input type="email" id="email" class="form-control" required />
                                </div>

                                <div class="form-group">
                                    <label for="Meal"></label>
                                    <select name="food" id="selectfood" class="form-control">
                                        <option value="1">Bread Sandwich (Mini)</option>
                                        <option value="2">Bread Sandwich (Midi)</option>
                                        <option value="3">Bread Sandwich (Maxi)</option>
                                        <option value="4">Bread Sandwich Specials (Lala Specials)</option>
                                        <option value="5">Lala Noodles</option>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label for="amount">Amount(NGN)</label>
                                    <input type="tel" id="amount" value="400" class="form-control" disabled required />
                                </div>

                                <div class="form-group">
                                    <label for="description">Meal Description</label>
                                    <textarea name="description" id="meal-description" class="form-control" cols="30" rows="2" disabled></textarea>
                                </div>
                                
                                <div class="form-group">
                                    <label for="first-name">First Name</label>
                                    <input type="text" id="firstname" class="form-control" />
                                </div>
                                
                                <div class="form-group">
                                    <label for="last-name">Last Name</label>
                                    <input type="text" id="lastname" class="form-control"/>
                                </div>

                                <div class="form-group">
                                    <label for="last-name">Phone No</label>
                                    <input type="tel" id="phone_no" class="form-control"/>
                                </div>
                                
                                <div class="form-submit form-group">
                                    <input type="submit" class="btn btn-primary" value="Pay Now">
                                </div>
                                <div class="alert alert-success alert-dismissible fade in" id="txn-success">
                                    <a href="#" class="close"  data-dismiss="alert" aria-label="close">&times;</a>
                                    <strong>Success!</strong> Your transaction ID is <span id="txnid"></span>. Screenshot or copy and save till you redeem your order.
                                </div>
                                <div class="alert alert-danger alert-dismissible fade in" id="txn-failed">
                                    <a href="#" class="close"  data-dismiss="alert" aria-label="close">&times;</a>
                                    <strong>Error!</strong> Your transaction was not successful. Please try again or contact us at <a href="https://wa.me/+2348155418988?text=Hello.%20My%20name%20is____" class="alert-link">Lala Foods</a>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <footer>

    </footer>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://js.paystack.co/v1/inline.js"></script>
    <!-- <script src="js/jquery.js"></script> -->
    <script src="assets/js/main.js"></script>
</body>
</html>