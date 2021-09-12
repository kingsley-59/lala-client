//initialize the object that would be sent to the server
const checkout_data = {};

function get_price(meal) {
    let meal_list = [
        'meshai special', 'noodles special', 'meshai supreme', 'meshai delight', 'noodles delight', 'meshai deluxe',
        'noodles deluxe', 'meshai super', 'noodles dibia'
    ];
    let price_list = [
        400, 450, 500, 550, 600, 650, 700, 750, 800
    ];
    let index = meal_list.indexOf(meal);
    let price = price_list[index];

    return price;
}

$(document).ready(function () {
    $("#delivery-form").css('display', 'none');
});

let add_order_btn = document.getElementById('add-order-btn');
add_order_btn.addEventListener('click', function () {
    let meal_order = document.getElementById('select-meal').value;
    let qty = document.getElementById('select-qty').value;

    if (meal_order == "0" || qty == 0) {
        alert('Invalid inputs');
        return false;
    }

    let cart_table = document.getElementById('cart-table');
    let row_length = cart_table.rows.length;
    let next_row = cart_table.insertRow(row_length);
    next_row.insertCell(0);
    next_row.insertCell(1);
    next_row.insertCell(2);
    next_row.cells[0].innerText = meal_order;
    next_row.cells[1].innerText = qty;
    next_row.cells[2].innerHTML = '<button class="btn-danger remove-order" onclick="remove_order(this)">&times;</button>';

    let first_row = cart_table.rows[1];
    let first_row_qty = first_row.cells[1].innerText;
    //alert(first_row_qty);
    if (first_row_qty == "0") {
        first_row.remove();
    }
    let total_amt = document.getElementById('total-amount');
    let current_total = parseInt(total_amt.value);
    let meal_price = get_price(meal_order);
    let meal_qty = parseInt(qty);
    let total_meal_price = meal_price * meal_qty;
    total_amt.value = current_total + total_meal_price;
});

//let delete_meal_btn = document.getElementsByClassName('remove-order');
function remove_order(e) {
    let total_amt = document.getElementById('total-amount');
    let current_total = parseInt(total_amt.value);
    if (current_total > 0) {
        let meal = e.parentElement.parentElement.cells[0].innerText;
        let meal_price = get_price(meal);
        let qty = e.parentElement.parentElement.cells[1].innerText;
        let meal_qty = parseInt(qty);
        let total_meal_price = meal_price * meal_qty;

        console.log(total_amt.value);
        total_amt.value = current_total - total_meal_price;
        if(total_amt.value == ''){
            total_amt.value = 0;
        }
    }

    e.parentElement.parentElement.remove();
}


let next_btn = document.getElementById('next-btn');
next_btn.addEventListener('click', function () {
    let delivery_details = document.getElementById('delivery-details');
    delivery_details.style.display = 'block';
    delivery_details.style.minHeight = '50vh';
    delivery_details.style.height = 'auto';
    delivery_details.scrollIntoView();

    //log checkout data in console
    var cart_table = document.getElementById('cart-table');
    var cart_data = Array();
    for (var i = 0; i < cart_table.rows.length; i++) {
        var row = cart_table.rows[i];
        cart_data[i] = {
            meal: row.cells[0].innerText,
            quantity: row.cells[1].innerText
        }
    }
    cart_data = JSON.stringify(cart_data);
    console.log(cart_data);
});


let delivery_ok_btn = document.getElementById('delivery-ok-btn');
delivery_ok_btn.addEventListener('click', function () {
    let delivery_option = document.getElementById('delivery-option').value;
    let delivery_direction = document.getElementById('delivery-direction');
    let direction_alert = document.getElementById('direction-alert');

    if (delivery_option == "store pickup") {
        direction_alert.innerHTML = `
        <div class="alert alert-success">
            Locate the nearest store and retrieve your order. To find the nearest store, you can use <a href="">google maps</a> or call <a tel="+">+234812345790</a>. Please do that before 10:00pm today!
        </div>
        <div class="form-group text-center">
            <button class="btn btn-success" id="checkout-btn2">Checkout</button>
        </div>
        `;
        document.getElementById('delivery-form').style.display = 'none';
        checkout_data.delivery_info = "Store pickup";
        $("#checkout-btn2").on('click', checkout());
    } else if (delivery_option == "home delivery") {
        direction_alert.innerHTML = "";
        document.getElementById('delivery-form').style.display = 'block';
        let btn_elem = document.getElementsByClassName('form-checkout-btn');
        //document.getElementById('d-area').focus();
    } else {
        direction_alert.innerHTML = `
        <div class="alert alert-warning">
            Please choose a delivery method.
        </div>
        `;
        //delivery_option.focus();
    }
    
});


let checkout_btn = document.getElementById('checkout-btn');

checkout_btn.addEventListener('click', function (event) {
    event.preventDefault();

    checkout();

});

function checkout() {
    //get cart table values
    let cart_table = document.getElementById('cart-table');
    let cart_data = Array();
    for (var i = 1; i < cart_table.rows.length; i++) {
        var row = cart_table.rows[i];
        let meal = row.cells[0].innerText;
        let quantity = row.cells[1].innerText;
        cart_data.push(`${meal} : ${quantity}`);
    }

    //get delivery details

    checkout_data.personal_info = {
        name: document.getElementById('name').value,
        email: document.getElementById('email').value,
        phone: document.getElementById('phone').value,
        gender: $("input[type='radio'][name='gender']:checked").val()
    };
    checkout_data.cart_info = cart_data;
    if (!checkout_data.delivery_info) {
        let area = document.getElementById('delivery-area').value;
        let location = document.getElementById('location-name').value;
        let description = document.getElementById('location-desc').value;
        checkout_data.delivery_info = `Area: ${area}. Location: ${location}. Description: ${description}.`;
    }
    checkout_data.total_amount = parseInt(document.getElementById('total-amount').value);
    checkout_data.reference = Date.now();
    let data = JSON.stringify(checkout_data);
    console.log(data);

    $.ajax({
        type: "POST",
        url: "/submit",
        data: data,
        contentType: "application/json; charset=utf-8",
        success: function (res) {
            console.log(res);
            payWithPaystack(
                checkout_data.personal_info.name,
                checkout_data.personal_info.email,
                cart_data.join(", "),
                checkout_data.total_amount * 100,
                checkout_data.reference
            );
        },
        error: function (err) {
            console.log(err);
        }
    });


}


function payWithPaystack(name, email, order, amount, ref) {
    var handler = PaystackPop.setup({
        key: 'pk_test_b201960416954ffb959c3ed057167bc6713d25a1', // Replace with your public key
        email: email,
        amount: amount, // the amount value is multiplied by 100 to convert to the lowest currency unit
        currency: 'NGN', // Use GHS for Ghana Cedis or USD for US Dollars
        ref: ref, // Replace with a reference you generated
        metadata: {
            custom_fields: [{
                    display_name: "Name",
                    variable_name: "name",
                    value: name
                },
                {
                    display_name: "Transaction ID",
                    variable_name: "txn_id",
                    value: ref
                },
                {
                    display_name: "Order",
                    variable_name: "order",
                    value: order
                }
            ]
        },
        callback: function (response) {
            //this happens after the payment is completed successfully
            var reference = response.reference;
            console.log(JSON.stringify(response));
            alert('Payment complete! Reference: ' + reference);
            // Make an AJAX call to your server with the reference to verify the transaction
            let data = {
                email: email,
                reference: response.reference
            };
            $.post(
                "/verify_transaction",
                JSON.stringify(data),
                function (response) {
                    console.log(response);
                    if(response == "success"){
                        window.location.href = "/confirmation?txn_id="+reference;
                    }
                }
            );
        },
        onClose: function () {
            alert('Transaction was not completed, window closed.');
        },
    });
    handler.openIframe();
}