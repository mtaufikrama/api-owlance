<?php

include "cek-no-token.php";

// username, nama, email, password, no_hp, foto

$characters = '0123456789';
$otp = '';
$charLength = strlen($characters);

for ($i = 0; $i < 4; $i++) {
    $otp .= $characters[rand(0, $charLength - 1)];
}

if (!$username || !$password || !$email || !$no_hp || $username == '' || $password == '' || $email == '' || $no_hp == '') {
    $datarest['code'] = 500;
    $datarest['msg'] = "Username / Email / Password / No HP Harus Diisi";
    echo encryptData($datarest);
    die();
}

$cekSebelummasukusername = baca_tabel("user", "count(username)", "  where username='$username'");

if ($cekSebelummasukusername > 0) {
    $datarest['code'] = 500;
    $datarest['msg'] = "Username Sudah Terdaftar";
    echo encryptData($datarest);
    die();
}

$cekSebelummasukemail = baca_tabel("user", "count(email)", "  where email='$email'");

if ($cekSebelummasukemail > 0) {
    $datarest['code'] = 500;
    $datarest['msg'] = "Email Sudah Terdaftar";
    echo encryptData($datarest);
    die();
}

$cekSebelummasukhp = baca_tabel("user", "count(no_hp)", "  where no_hp='$no_hp'");

if ($cekSebelummasukhp > 0) {
    $datarest['code'] = 500;
    $datarest['msg'] = "No Hp Sudah Terdaftar";
    echo encryptData($datarest);
    die();
}
/****************************************************************************************/

$dataSend['id'] = generateID(50, 'user', 'id');
$dataSend['password'] = base64_encode(enkrip($password));
$dataSend['available'] = 0;

$dataOtp['id_user'] = $dataSend['id'];
$dataOtp['otp'] = $otp;

$result = insert_tabel("user", $dataSend);
if ($result) $result = insert_tabel('otp', $dataOtp);
if ($result) {
    $datarest['code'] = 200;
    $datarest['msg'] = "Berhasil Daftar";
} else {
    $datarest['code'] = 200;
    $datarest['msg'] = "Maaf, Pendaftaran Gagal diproses";
}

echo encryptData($datarest);

// =================================================================== //

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$emailUser = $email;

require_once "../../library/PHPMailer.php";
require_once "../../library/Exception.php";
require_once "../../library/OAuth.php";
require_once "../../library/POP3.php";
require_once "../../library/SMTP.php";

// $mail->SMTPDebug = 3;
$mail = new PHPMailer();
$mail->isSMTP();
$mail->Host = "mail.metir.my.id"; //host mail server (sesuaikan dengan mail hosting Anda)
$mail->SMTPAuth = true;

$mail->Username = "mtaufikrama@metir.my.id"; //nama-email smtp
$mail->Password = "MeTiR102!"; //password email smtp

$mail->SMTPSecure = "ssl";
$mail->Port = 465;
$mail->From = "mtaufikrama@metir.my.id"; //email pengirim
$mail->FromName = "MeTiR"; //nama pengirim
$mail->addAddress($email, "");

$recipients = array(
    'mtaufikrama@metir.my.id' => 'CC 1',
    // ..
); /**/
foreach ($recipients as $email => $name) {
    $mail->AddCC($email, $name);
}

// $mail->isHTML(true);
// $subject = 'RESET PASSWORD A-DOKTER';
// $message = $keterangan;

$mail->isHTML(true);
$subject = 'PASSWORD AKTIVASI A-DOKTER';
$message = "Dear " . $nama;
$message .= "<br>";
$message .= "<br>";
$message .= "Halo " . $nama;
$message .= "<br>";
// $message .= "Selamat kami dari team A-Dokter , menginformasikan bahwa Sistem A-Dokter telah dapat digunakan dan bapak/ibu yang telah terdaftar dapat melengkapi data-data secara langsung dengan menggunakan email yang sudah terdaftar dan password yang kami kirimkan melalui email";
$message .= "Selamat anda telah mendaftar sebagai Mitra a-Dokter , diinformasikan kepada bapak/ibu Mitra a-Dokter yang telah terdaftar diharapkan untuk dapat melengkapi data-data secara langsung dengan menggunakan email yang sudah terdaftar dan password yang kami kirimkan melalui email";
$message .= "<br>";
// $message .= "<br>";
// $message .= "Login a-Dokter : https://a-dokter.id/form_login.php";
$message .= "<br>";
$message .= "Username      			: " . $emailUser;
$message .= "<br>";
$message .= "Password             	: " . $password;
$message .= "<br>";
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
/****************************************************************************************/