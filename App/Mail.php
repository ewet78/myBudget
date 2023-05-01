<?php

namespace App;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//require_once 'vendor/autoload.php';

//require 'vendor/phpmailer/phpmailer/src/Exception.php';
//require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
//require 'vendor/phpmailer/phpmailer/src/SMTP.php';

//require 'vendor/league/oauth2-google/src/Exception/HostedDomainException.php';
//require 'vendor/league/oauth2-google/src/Provider/Google.php';
//require 'vendor/league/oauth2-google/src/Provider/GoogleUser.php';

use League\OAuth2\Client\Provider\Google;

$provider = new Google([
    'clientId'     => Config::CLIENTID,
    'clientSecret' => Config::CLIENTSECRET,
    'redirectUri'  => Config::REDIRECTURI,
]);


/**
 * Mail
 * 
 * PHP version 8.2
 */
class Mail
{
    /**
     * Send a message
     * 
     * @param string $to Recipient
     * @param string $subject Subject
     * @param string $text Text-only content of the message
     * @param string $html HTML content of the message
     * 
     * @return mixed
     */
    public static function send($to, $subject, $text, $html)
    {
        $mail = new PHPMailer(true);

        try {
            //Server settings
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = Config::SMTP_HOST;                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = Config::SMTP_USER;                    //SMTP username
            $mail->Password   = Config::SMTP_PASS;                               //SMTP password
            $mail->SMTPSecure = 'ssl';                                   //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('ewelinatokarz28@gmail.com');
            $mail->addAddress($to);     //Add a recipient
            //$mail->addAddress('ellen@example.com');               //Name is optional
            //$mail->addReplyTo('info@example.com', 'Information');
            //$mail->addCC('cc@example.com');
           // $mail->addBCC('bcc@example.com');

            //Attachments
            //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $html;
            $mail->AltBody = $text;

            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}