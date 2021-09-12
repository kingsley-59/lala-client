<?php

use PHPMailer\PHPMailer\PHPMailer;
use Src\Controller\MailController;
use Src\System\DatabaseConnector;

$db = (new DatabaseConnector)->getConnection();

if(isset($_POST['to']) && !empty($_POST['to'])){
    $from = $_POST['from'];
    $from_name = $_POST['from_name'];
    $to = $_POST['to'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    //validate inputs
    $result = validate_inputs($to, $subject, $message);
    if($result != true){
        echo $result;
        exit();
    }

    $mail = new PHPMailer($db);
    $response = $mail->send($name=null, $to, $subject, $message, $alt_msg=null);

    if($response != true){
        echo $response;
    }else{
        echo "success";
    }

}

function validate_inputs($email, $subj, $msg){
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        return 'Invalid email!';
    }

    if(empty($message) || $message == null){
        return 'Invalid message';
    }

    return true;
}

?>



<section class="compose">
    <div class="header text-center">
        <h2>Compose Email</h2>
    </div>
    <div class="main">
        <div class="compose-area">
            <form action="" method="POST" id="compose-email-form">
                <div class="form-group">
                    <label for="from">From:</label>
                    <input type="text" name="from" value="Lala Healthy Foods <contact@lalahealthyfoods.com>" id="from" class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label for="to">To:</label>
                    <input type="email" name="to" id="to" class="form-control" placeholder="receiver's email" required>
                </div>
                <div class="form-group">
                    <label for="subject">Subject</label>
                    <input type="text" name="subject" id="subject" class="form-control" placeholder="mail subject" required>
                </div>
                <div class="form-group">
                    <label for="message">Message:</label>
                    <textarea name="" id="message" cols="30" rows="10" class="form-control" placeholder="This is a sample message..." required></textarea>
                </div>
                <div class="form-group submit">
                    <input type="submit" value="Send" id="send_email" class="btn btn-success form-control">
                    <input type="submit" value="Cancel" id="cancel_email" class="btn btn-danger form-control">
                </div>
            </form>
        </div>
        <div id="response">

        </div>
    </div>
</section>

<script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>
<script>
    $(document).ready(function(){
        $('form#compose-email-form').submit(function(event){
            event.preventDefault();
            let from = 'contact@lalahealthyfoods.com';
            let from_name = 'Lala Healthy Foods'
            let to = $('#to').val();
            let subject = $('#subject').val();
            let message = $('#message').val()

            $.ajax({
                type: 'POST',
                url: '/admin?admin-page=compose-email',
                data: {
                    from: from,
                    from_name: from_name,
                    to: to,
                    subject: subject,
                    message: message
                },
                success: function(response){
                    console.log(response);
                    let response_div = document.getElementById('response');
                    if($response == "success"){
                        response_div.innerHTML = `
                            <div class="alert alert-success">Email sent successfully!</div>
                        `;
                    }else{
                        response_div.innerHTML = `
                            <div class="alert alert-danger">An error occured! ${response}</div>
                        `;
                    }
                },
                error: function(err){
                    alert(err);
                }
            });
        });
    });
</script>