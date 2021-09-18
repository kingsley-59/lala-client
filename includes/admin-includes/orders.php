<?php
use Src\Gateway\OrderGateway;

$orderGateway = new OrderGateway($dbConnection, 'orders');

$filter = $_POST['show_filter'] ?? null;
if ($filter != null){
    $count = $_POST["row_count"];
    if ($filter == "verified only"){
        // get verified inputs from order table limit 20
        $header = "Verified Orders";
        $result = $orderGateway->get_verified($count);
    } elseif ($filter == "not redeemed"){
        // get umredeemed input from table limit 20
        $header = "Unredeemed Orders";
        $result = $orderGateway->get_unredeemed($count);
    } else {
        // show all transactions
        $header = "All Orders";
        $result = $orderGateway->get_all($count);
    }
}else{
    // show verified orders only
    $header = "Verified Orders";
    $result = $orderGateway->get_verified();
}

?>


<section class="txn">
    <div class="header">
        <strong><h2><?php echo $header; ?></h2></strong>
    </div>
    <div class="main">
        <div class="filters">
            <form action="" id="filter-form" method="post">
                <div class="formgroup">
                    <div class="left">
                        <select name="show_filter" class="form-control" id="">
                            <option value="verified only">Verified transactions only</option>
                            <option value="not redeemed">Unredeemed orders only</option>
                            <option value="show all">Show all transactions</option>
                        </select>
                    </div>
                    <div class="count">
                        <input type="number" name="row_count" value="20" id="count" class="form-control" placeholder="no. of rows">
                    </div>
                    <div class="right">
                        <input type="submit" value="Apply" id="apply" class="btn btn-success form-control">
                    </div>
                </div>
            </form>
        </div>
        <div class="data">
            <table class="table">
                <tr>
                    <th>Email</th>
                    <th>Name</th>
                    <!-- <th>Gender</th> -->
                    <!-- <th>Phone</th> -->
                    <th>Order</th>
                    <th>Amount</th>
                    <th>Order ID</th>
                    <th>Delivery</th>
                    <th>Redeemed</th>
                </tr>
                <?php if($result): ?>
                    <?php foreach($result as $row): ?>
                        <tr>
                            <td><?php echo $row["email"]; ?></td>
                            <td><?php echo $row["name"]; ?></td>
                            <!-- <td><?php //echo $row["gender"]; ?></td> -->
                            <!-- <td><?php //echo $row["phone"]; ?></td> -->
                            <td><?php echo $row["order_details"]; ?></td>
                            <td><?php echo $row["total_amount"]; ?></td>
                            <td><?php echo $row["txn_id"]; ?></td>
                            <td><?php echo $row["delivery_details"]; ?></td>
                            <td>
                                <?php //Use the button as a link to call the update ftn of the order gateway. ?>
                                <?php if($row["redeemed"] == 0): ?>
                                    <?php echo '<button class="btn btn-warning">No yet</button>'; ?>
                                <?php else: ?>
                                    <?php echo '<button class="btn btn-success">Yes!</button>'; ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><?php echo "Failed to load results"; ?></tr>
                <?php endif; ?>
            </table>
        </div>
    </div>
</section>
