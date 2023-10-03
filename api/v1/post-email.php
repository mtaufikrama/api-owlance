<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include "../dev/cek-token.php";
require_once "../../library/PHPMailer.php";
require_once "../../library/Exception.php";
require_once "../../library/OAuth.php";
require_once "../../library/POP3.php";
require_once "../../library/SMTP.php";

//host, from, fromname, frompw, to, subject, message

$mail = new PHPMailer();
$mail->isSMTP();
$mail->Host = $host;
$mail->SMTPAuth = true;

$mail->Username = $from;
$mail->Password = $frompw;

$mail->SMTPSecure = "ssl";
$mail->Port = 465;
$mail->From = $from;
$mail->FromName = $fromname;
$mail->addAddress($email, "");

$recipients = array(
    $from => 'CC 1',
    // ..
); /**/
foreach ($recipients as $email => $name) {
    $mail->AddCC($email, $name);
}

/****************************************************************************************/
$mail->isHTML(true);
$mail->Subject = $subject;
$mail->Body = nl2br($message);
$mail->AltBody = "PHP mailer";
$mail->send();
/****************************************************************************************/

$data['code'] = 200;
$data['msg'] = 'Email berhasil dikirim';
?>