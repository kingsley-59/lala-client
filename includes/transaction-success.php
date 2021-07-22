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
        <div class="txn-response">
            <h3>Thanks for Your Patronage!</h3>
        </div>
        <div class="txn-details">
            <span></span>
            <table>
                <tr>
                    <th>Title</th>
                    <th>Detail</th>
                </tr>
                <tr>
                    <td>Name</td>
                    <td>John Davis</td>
                </tr>
                <tr>
                    <td>Order</td>
                    <td>Lala Specials</td>
                </tr>
                <tr>
                    <td>Amount</td>
                    <td>N1000</td>
                </tr>
                <tr>
                    <td>Transaction ID</td>
                    <td>167298438130</td>
                </tr>
            </table>
            <div><?php if(isset($txnId)){echo $result;}?></div>
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