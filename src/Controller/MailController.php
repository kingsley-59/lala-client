<?php
namespace Src\Controller;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
use Src\Gateway\UserGateway;

class MailController {

    private $db;
    private $senderName;
    private $senderEmail;
    private $password;
    private $SMTPhost;

    public function __construct($db)
    {
        $this->db = $db;

        $this->senderName = "Lala Healthy Foods";
        $this->senderEmail = "contact@lalahealthyfoods.com";
        $this->SMTPhost = '';

        $this->txnGateway = new UserGateway($db, "lala-users");
    }

    public function send_confirmation_email($name, $email){
        $mail_subject = "";
        $html_message = "";
        $alt_message = "";
                
        $response = $this->send($name, $email, $mail_subject, $html_message, $alt_message);
        
    }

    public function send($name, $email, $subject, $msg, $alt_msg){
        $mail = new PHPMailer(true);
      
        try {
          //Server settings
          $mail->SMTPDebug = false;                      // Enable verbose debug output
          $mail->isSMTP();                                            // Send using SMTP
          $mail->Host       = 'rbx105.truehost.cloud';                    // Set the SMTP server to send through
          $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
          $mail->Username   = 'info@vendorcrest.com';                     // SMTP username
          $mail->Password   = 'kingsley-et-diva';                               // SMTP password
          $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
          $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
      
          //Recipients
          $mail->setFrom($this->senderEmail, $this->senderName);
          $mail->addAddress($email, $name);     // Add a recipient
          //$mail->addReplyTo('info@example.com', 'Information');
          //$mail->addBCC('divine10646@gmail.com');
          //$mail->addBCC('somaoloto@gmail.com');
      
          // Content
          $mail->isHTML(true);                                  // Set email format to HTML
          $mail->Subject = $subject;
          $mail->Body    = $msg;
          $mail->AltBody = $alt_msg;
      
          $mail->send();
          //$mail->smtpClose();
          return true;
        } catch (Exception $e) {
          $sendMailError =  "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
          return $sendMailError;
        }
    }

}