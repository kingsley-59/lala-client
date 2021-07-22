function openMenu() {
    document.getElementById("header-menu").style.height = "100%";
}

function closeMenu() {
    document.getElementById("header-menu").style.height = "0%";
}

var mealdescriptions = [
    "Mini-sized bread with salad and eggs",
    "Medium-sized bread with salad and eggs",
    "Maxi-pack with salad and eggs",
    "Medium-sized bread with salad, eggs, hotdogs, etc",
    "Well garnished noodles with fried eggs"
]
var priceoptions = [300, 400, 450, 700, 400]

$(document).ready(function () {
    var meal = $("#selectfood").val();
    $("#amount").val(priceoptions[meal - 1]);
    $("#meal-description").val(mealdescriptions[meal - 1]);
    $("#selectfood").on('change', function (e) {
        var newoption = $(this).find("option:selected");
        var meal = newoption.val();
        $("#amount").val(priceoptions[meal - 1]);
        $("#meal-description").val(mealdescriptions[meal - 1]);
    });


$("#paymentForm").submit(function (event) {
    event.preventDefault(event);
    var mealoptions = [
        "Bread Sandwich (mini)",
        "Bread Sandwich (midi)",
        "Bread Sandwich (maxi)",
        "Bread Sandwich Specials (Lala Specials)",
        "Lala noodles"
    ]
    var firstname = $("#firstname").val();
    var lastname = $("#lastname").val();
    var email = $("#email").val();
    var order = $("#selectfood").val();
    order = mealoptions[order - 1];
    var amount = $("#amount").val();
    var txnId = Date.now();
    var phone_no = $("#phone_no").val();
    //create input to accept phone numeber!
    //payWithPaystack(email, amount, txnId, firstname, lastname, order, phone_no);
    $.ajax({
        url: 'http://127.0.0.1:5000/',
        type: 'POST',
        data: {
            name: firstname + ' ' + lastname,
            email: email,
            order: order,
            amount: amount,
            transactionId: txnId,
            phone_no: phone_no
        },
        success: function (status, response) {
            //alert('success');
            if (status == 'success') {
                //do something
            }
        },
        error: function () {
            alert('Error');
        }
    });
})

function generateTxnId() {
    var sec = Date.now();
    var randInt = Math.floor(Math.random() * 100);
    return sec + randInt;
}

function generateOrderCode(txnId) {
    hexString = txnId.toString(16);
}
function reverseOrderCode(orderCode) {
    txnId = parseInt(orderCode,16);
}

function payWithPaystack(email, amount, reference, firstname, lastname, order, phone_no) {

  var handler = PaystackPop.setup({

    key: 'pk_test_b201960416954ffb959c3ed057167bc6713d25a1', // Replace with your public key
    email: email,
    amount: amount * 100, // the amount value is multiplied by 100 to convert to the lowest currency unit
    currency: 'NGN', // Use GHS for Ghana Cedis or USD for US Dollars
    ref: reference, // Replace with a reference you generated
    metadata: {
        custom_fields: [
            {
                display_name: "Name",
                variable_name: "name",
                value: firstname + " " + lastname
            },
            {
                display_name: "Transaction ID",
                variable_name: "txn_id",
                value: reference
            },
            {
                display_name: "Order",
                variable_name: "order",
                value: order
            }
        ]
    },
    callback: function(response) {

        //this happens after the payment is completed successfully

        var reference = response.reference;
        $("#txnid").html(reference);
        $("#txn-success").css('display', 'block');
        //alert('Payment complete! Reference: ' + reference);

        // Make an AJAX call to your server with the reference to verify the transaction
        $.ajax({
            url: 'http://127.0.0.1:5000/',
            type: 'POST',
            data: {
                name: firstname + ' ' + lastname,
                email: email,
                order: order,
                amount: amount,
                transactionId: reference,
                phone_no: phone_no
            },
            success: function (status, response) {
                if (status == 'success') {
                    alert(response.status);
                    if (response.status == 'OK') {
                        location.href = '/transaction-success/'+reference;
                    }
                }
            },
            error: function () {
                //do something
            }
        });

    },

      onClose: function () {
        $("#txn-failed").css('display', 'block');
        //alert('Transaction was not completed, window closed.');
    },

  });

  handler.openIframe();

    }


});