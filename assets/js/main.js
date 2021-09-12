function openMenu() {
    document.getElementById("header-menu").style.height = "100%";
}

function closeMenu() {
    document.getElementById("header-menu").style.height = "0%";
}

function scrollright(){
    document.getElementById("r").scrollTop += 0;
    document.getElementById("r").scrollLeft += 400;
}

function scrollleft(){
    document.getElementById("r").scrollTop += 0;
    document.getElementById("r").scrollLeft += -400;
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

    var url_path = window.location.pathname;
    if (url_path != "/admin"){
        var admin_nav = $("#admin-menu-btn");
        admin_nav.css('display', 'none');
    }

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

});