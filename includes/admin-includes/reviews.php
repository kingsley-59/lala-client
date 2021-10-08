<?php
use Src\Gateway\ReviewGateway;

$reviewGateway = new ReviewGateway($dbConnection, 'reviews');


$review_update = '';
if(isset($_GET['delete']) && !empty($_GET['delete'])){
    $is_deleted = check_status($reviewGateway, $_GET['delete']);
    if($is_deleted == false){
        $response = $reviewGateway->update($_GET['delete'], 'is_deleted', TRUE);
        if($response == '1'){
            $review_update = 'deleted';
        }else{
            $review_update = 'error';
        }
    }
    
}

if(isset($_GET['golive']) && !empty($_GET['golive'])){
    $is_deleted = check_status($reviewGateway, $_GET['golive']);
    if($is_deleted == true){
        $response = $reviewGateway->update($_GET['golive'], 'is_deleted', 0);
        if($response == '1'){
            $review_update = 'live';
        }else{
            $review_update = 'error';
        }
    }
    
}

function check_status($reviewGateway, $id){
    $reviews = $reviewGateway->get_all();
    foreach($reviews as $review){
        if($review['id'] == $id){
            $status = (bool) $review['is_deleted'];
            return $status;
        }
    }
}

$filter = $_POST['show_filter'] ?? null;
if ($filter != null){
    $count = $_POST["row_count"];
    if ($filter == "live reviews"){
        // get live reviews from reviews table limit 20
        $header = "Live Reviews";
        $result = $reviewGateway->get_live_reviews($count);
    } elseif ($filter == "deleted reviews"){
        // get umredeemed input from table limit 20
        $header = "Unredeemed Orders";
        $result = $reviewGateway->get_deleted_reviews($count);
    } else {
        // show all transactions
        $header = "All Orders";
        $result = $reviewGateway->get_all($count);
    }
}else{
    // show verified orders only
    $header = "Live Reviews";
    $result = $reviewGateway->get_live_reviews($limit = 15);
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
                            <option value="live reviews">Live reviews only</option>
                            <option value="deleted reviews">Deleted reviews only</option>
                            <option value="show all">Show all reviews</option>
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
            <?php if($review_update == 'deleted'): ?>
                <div class="alert alert-warning">Review deleted successfully.</div>
            <?php elseif($review_update == 'live'): ?>
                <div class="alert alert-success">Review is now Live!</div>
            <?php elseif($review_update == 'error'): ?>
                <div class="alert alert-danger">Error while deleting review!</div>
            <?php endif; ?>
            <table class="table">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Review</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
                <?php if($result): ?>
                    <?php foreach($result as $row): ?>
                        <tr>
                            <td><?php echo $row["name"]; ?></td>
                            <td><?php echo $row["email"]; ?></td>
                            <td><?php echo $row["review"]; ?></td>
                            <td><?php echo $row["modified"]; ?></td>
                            <td>
                                <?php //Use the button as a link to call the update ftn of the order gateway. ?>
                                <?php if($row["is_deleted"] == 1): ?>
                                    <?php echo '<a href="?admin-page=reviews&golive='.$row["id"].'"><button class="btn btn-danger">Live!</button></a>'; ?>
                                <?php else: ?>
                                    <?php echo '<a href="?admin-page=reviews&delete='.$row["id"].'"><button class="btn btn-success">Live!</button></a>'; ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td cellspan=5 class="text-center"><?php echo "No results available"; ?></td></tr>
                <?php endif; ?>
            </table>
        </div>
    </div>
</section>
