<?php

// Include the database configuration file

use Src\System\DatabaseConnector;
use Src\Gateway\MenuGateway;

$db = (new DatabaseConnector)->getConnection();
$menu_gateway = new MenuGateway($db);


// File upload path
$targetDir = dirname(dirname(__DIR__)) . '\storage\meal_photos\\';
//echo $targetDir;

$upload_result = (isset($_POST['meal'])) ? process_request($targetDir, $menu_gateway) : '';
echo $upload_result;

$delete_meal = (isset($_GET['del'])) ? delete_meal($_GET['del'], $menu_gateway) : '';

//get all menu items from database
$menu_result = $menu_gateway->get_all();


function process_request($targetDir, $menu_gateway)
{
    if (isset($_POST["meal"]) && !empty($_FILES["photo"]["name"])) {
        $fileName = basename($_FILES["photo"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $filetype = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        // Allow certain file formats
        $valid_format = verify_format($filetype);
        if (!$valid_format) {
            return "Invalid file type.";
        }
        
        $file_exists = (file_exists($targetDir . $fileName)) ? 'File already exists' : false;
        if($file_exists != false){
            return $file_exists;
        }

        if (move_uploaded_file($_FILES["photo"]["tmp_name"], $targetFilePath)) {
            $input = array();
            $input['name'] = $_POST['meal'];
            $input['desc'] = $_POST['description'];
            $input['price'] = $_POST['price'];
            $input['file_name'] = $fileName;
            $response = $menu_gateway->insert($input);

            return ($response == '1') ? 'File has been uploaded successfully.' : 'Could not save file to database.';
        } else {
            return 'Sorry, there was an error uploading your file';
        }
    } else {
        return 'Please select a file to upload.';
    }
}


function verify_format($file_type)
{
    $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'pdf');

    if (in_array($file_type, $allowTypes)) {
        return true;
    } else {
        return false;
    }
}


function delete_meal($meal, $menu_gateway){
    if(empty($meal)){
        return "No meal selected to be deleted";
    }

    $response = $menu_gateway->delete($meal);

    return ($response == '1') ? "Item deleted successfully" : "An error ocurred: " . $response;
}


?>

<section class="manage-menu">
    <div class="header text-center">
        <h2>Manage Menu</h2>
    </div>
    <div class="add">
        <div class="add-to-menu">
            <form action="" method="post" id="add-meal" enctype="multipart/form-data">
                <div class="form-group">
                    <input type="text" name="meal" id="meal-name" class="form-control" placeholder="meal name" required>
                </div>
                <div class="form-group">
                    <input type="text" name="description" id="meal-desc" class="form-control" placeholder="brief description" required>
                </div>
                <div class="form-group">
                    <input type="number" name="price" id="meal_price" class="form-control" placeholder="meal price (NGN)" required>
                </div>
                <div class="form-group inline-inputs">
                    <input type="file" name="photo" id="meal-photo" class="form-control" hidden required>
                    <!-- <label for="meal-photo">Choose Photo</label>
                    <span id="photo-name">No file chosen</span> -->
                </div>
                <div class="form-group text-center">
                    <input type="submit" value="Save" class="btn btn-success">
                </div>
            </form>
        </div>
    </div>
    <div class="show">
        <div class="show-header text-center">
            <h3>Meal Catalog</h3>
        </div>
        <div class="show-menu">
        <?php if($menu_result): ?>
            <?php foreach($menu_result as $row): ?>
                <div class="menu-item">
                    <div class="item-photo">
                        <img src="<?php echo '/storage/meal_photos//' . $row['file_name']; ?>" alt="<?php echo $row['meal_name'] . 'photo'; ?>">
                        <div class="item-overlay">
                            <a href="<?php echo '?del=' . $row['meal_name']; ?>"><button class="btn btn-danger">Delete</button></a>
                        </div>
                    </div>
                    <div class="item-name text-center">
                        <h4><?php echo $row['meal_name']; ?></h4>
                        <p><?php echo $row['meal_desc'] ?></p>
                    </div>
                    <div class="item-price">
                        <span><?php echo 'NGN ' . $row['price']; ?></span>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="menu-item">
                <div class="item-photo">
                    No photo yet
                </div>
                <div class="item-name text-center">
                    <h4>No meal yet</h4>
                    <p>No description ...</p>
                </div>
                <div class="item-price">
                    <span>NGN 0.00</span>
                </div>
            </div>
        <?php endif; ?>
        </div>
    </div>
</section>

<script>

    
</script>