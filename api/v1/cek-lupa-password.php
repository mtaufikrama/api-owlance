<?php

include "cek-token.php";

//email

$password       = baca_tabel('dd_user', 'password', "where username='$email'");
// $emailuser      = baca_tabel('dd_user', 'username', "where username='$email'");
$nama_pegawai   = baca_tabel('mt_karyawan', 'nama_pegawai', "where email='$email'");

if ($password) { 
    $arrUsername    = explode("@", $email);
    $username       = $arrUsername[0];
    $pw             = $username."NEW321!";
    $password = md5($pw);

    $data['password'] = $password;

    $result = update_tabel('dd_user', $data, "where username='$email'");

    if ($result) {
        $datax['code']  = 200;
        $datax['msg']   = 'Kami akan mengirimkan password baru ke alamat email anda. Silahkan periksa kotak masuk atau di folder spam email';
    } else {
        $datax['code']  = 500;
        $datax['msg']   = 'Gagal Reset Password';
    }
} else {
    $datax['code']  = 500;
    $datax['msg']   = 'Email tidak terdaftar';
    echo json_encode($datax);
    die;
}

 $emailuser = $email;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once "../../library/PHPMailer.php";
require_once "../../library/Exception.php";
require_once "../../library/OAuth.php";
require_once "../../library/POP3.php";
require_once "../../library/SMTP.php";

// $mail->SMTPDebug = 3;
$mail = new PHPMailer;
$mail->isSMTP();
$mail->Host = "mbx.averin.co.id"; //host mail server (sesuaikan dengan mail hosting Anda)
$mail->SMTPAuth = true; 

$mail->Username = "adokter@averin.co.id";   //nama-email smtp  
$mail->Password = "Averin@2023!";           //password email smtp  

$mail->SMTPSecure = "ssl";
$mail->Port = 465;
$mail->From = "adokter@averin.co.id"; //email pengirim
$mail->FromName = "A-DOKTER"; //nama pengirim
$mail->addAddress($email, "");

$recipients = array(
	'adokter@averin.co.id' => 'CC 1',
	// ..
);/**/
foreach ($recipients as $email => $name) {
	$mail->AddCC($email, $name);
}

$mail->isHTML(true);
$subject = 'RESET PASSWORD A-DOKTER';
$message = $keterangan;

$mail->isHTML(true);
$subject = 'RESET PASSWORD A-DOKTER';
$message = "Dear " . $nama_pegawai;
$message .= "<br>";
$message .= "<br>";
$message .= "Halo " . $nama_pegawai;
$message .= "<br>";
$message .= "Berikut kami kirimkan kata sandi yang baru untuk login ke aplikasi A-Dokter";
$message .= "<br>";
$message .= "<br>";
$message .= "Username      			: " . $emailuser;
$message .= "<br>";
$message .= "Password             	: " . $pw;
$message .= "<br>";
$message .= "<br>";
$message .= "Login a-Dokter : https://a-dokter.id/form_login.php";
$message .= "<br>";

$message .= "Adapun untuk Mitra a-Dokter yang ingin melakukan trial aplikasi, Mitra a-Dokter dapat login melalui link berikut : https://demo.a-dokter.id/form_login.php dengan menggunakan username dan password seperti diatas.";
$message .= "<br>";
$message .= "Jika bapak/ibu Mitra a-Dokter belum mendaftarkan diri ke Satu Sehat Kemenkes RI, bapak/ibu Mitra A-Dokter dapat mengakses melalu link berikut : https://satusehat.kemkes.go.id/platform/welcome";
$message .= "<br>";
$message .= "Kami berharap bapak/ibu langsung menganti password untuk menjaga kerahasiaan, apabila ada kesulitan dalam menggunakan aplikasi silahkan hubungi kami";

$message .= "<br>";

$message .= "<br>";


$message .= "Terimakasih";
$message .= "<br>";
$message .= "Salam a-Dokter";
/****************************************************************************************/
$mail->Subject = $subject;
$mail->Body = nl2br($message); //isi email
$mail->AltBody = "PHP mailer"; //body email
$mail->send();



echo json_encode($datax);
?>