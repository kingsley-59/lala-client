<?php

use Src\System\DatabaseConnector;
use Src\Gateway\UserGateway;

$db = (new DatabaseConnector)->getConnection();
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$userGateway = new UserGateway($db, 'admins');

$admin_list = $userGateway->get_admin_users();

$process_result = (isset($_POST['name'])) ? process_request($userGateway, $admin_list) : '';
echo $process_result;

function process_request($userGateway, $admin_list){
    if(isset($_POST['name']) && !empty($_POST['email'])){
        $inputs = array();

        $inputs['name'] = trim($_POST['name']);
        $inputs['email'] = $_POST['email'];
        $inputs['phone'] = $_POST['phone'];
        $pswd = trim($_POST['password']);
        $inputs['pswd'] = password_hash($pswd, PASSWORD_DEFAULT);
        $inputs['address'] = trim($_POST['address']);


        $verify_inputs = validate_email($inputs['email'], $inputs['address']);

        if($verify_inputs != true){
            return $verify_inputs;
        }

        if(email_exists($inputs['email'], $admin_list)){
            return "Email already exists";
        }

        if(phone_exists($inputs['phone'], $admin_list)){
            return "Phone number already exists";
        }

        $result = $userGateway->add_admin_user($inputs);
        if($result == 1){
            return true;
        }else{
            return 'An error occurred saving data to database.';
        }
    }else{
        return 'Incomplete inputs.';
    }
}

function validate_email($email, $address){
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        return 'Invalid email!';
    }

    if(empty($address) || $address == null){
        return 'Invalid address';
    }

    return true;
}

function email_exists($email, $admin_list){
    if(!is_array($admin_list)){
        return "No emails yet";
    }

    foreach($admin_list as $rows){
        if($email == $rows['email']){
            return true;
        }
    }

    return false;
}

function phone_exists($phone, $admin_list){
    if(!is_array($admin_list)){
        return "No emails yet";
    }

    foreach($admin_list as $rows){
        if($phone == $rows['phone']){
            return true;
        }
    }

    return false;
}


?>


<section class="admin-user-manager">
    <div class="header">
        <h2>Manage Admins</h2>
    </div>
    <div class="admin-manager">
        <div class="add-admin">
            <div class="form-header">
                <h3>Add Admin</h3>
            </div>
            <form action="/admin?admin-page=manage-admin" method="POST" id="add-admin-form">
                <div class="form-group">
                    <label for="admin-name">Admin name:</label>
                    <input type="text" name="name" id="admin-name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="admin-email">Admin email:</label>
                    <input type="email" name="email" id="admin-email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="admin-phone">Phone number:</label>
                    <input type="tel" name="phone" id="admin-phone" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="admin-password">Password:</label>
                    <input type="password" name="password" id="admin-password" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="admin-address">Address:</label>
                    <textarea name="address" id="admin-address" class="form-control" cols="30" rows="10" required></textarea>
                </div>
                <div class="form-group text-center">
                    <input type="submit" value="Save" class="btn btn-success">
                </div>
            </form>
        </div>
        <div class="manage-admins">
            <div class="manage-admins-header">
                <h3>Admins List</h3>
            </div>
            <div class="admin-list">
                <table class="table">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                    </tr>
                    <?php if(isset($admin_list) && !empty($admin_list)): ?>
                        <?php foreach($admin_list as $row): ?>
                        <tr>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['phone']; ?></td>
                            <td><?php echo $row['address']; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td>No name yet</td>
                            <td>No email yet</td>
                            <td>No phone yet</td>
                            <td>No address yet</td>
                        </tr>
                    <?php endif; ?>
                </table>
            </div>
        </div>
    </div>
</section>

<script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>
<script>
    // $(document).ready(function(){
    //     $('#add-admin-form').submit(function(event){
    //         event.preventDefault();
    //         let name = $('#admin-name').val();
    //         let email = $('#admin-email').val();
    //         let phone = $('#admin-phone').val();
    //         let pswd = $('#admin-password').val();
    //         let address = $('#admin-address').val();

    //         $.ajax({
    //             type: 'POST',
    //             url: '/admin?admin-page=manage-admin',
    //             data: {
    //                 admin_name: name,
    //                 admin_email: email,
    //                 admin_phone: phone,
    //                 admin_pswd: pswd,
    //                 admin_address: address
    //             },
    //             success: function(response){
    //                 console.log(response);
    //             },
    //             error: function(err){
    //                 console.log(err);
    //             }
    //         })
    //     });
    // });
</script>