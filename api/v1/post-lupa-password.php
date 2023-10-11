<?php

include 'cek-no-token.php';

//email

$password = baca_tabel('user', 'password', "where email='$email'");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($password) {
    $nama = baca_tabel('user', 'nama', "where email='$email' and password='$password'");
    $pw = randomString();
    $pw_baru = enkrip($pw);

    $data['password'] = $pw_baru;

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
    // $subject = 'RESET PASSWORD OWLANCE';
    // $message = $keterangan;

    $mail->isHTML(true);
    $subject = 'RESET PASSWORD Owlance';
    $message = "Dear " . $nama;
    $message .= "<br>";
    $message .= "<br>";
    $message .= "Halo " . $nama;
    $message .= "<br>";
    $message .= "Berikut kami kirimkan kata sandi yang baru untuk login ke aplikasi Owlance";
    $message .= "<br>";
    $message .= "<br>";
    $message .= "Username      			: " . $email;
    $message .= "<br>";
    $message .= "Password             	: " . $pw;
    $message .= "<br>";
    $message .= "<br>";
    $message .= "Login Owlance : https://owlance.metir.my.id/#/login";
    $message .= "<br>";

    $message .= "Adapun untuk Mitra Owlance yang ingin melakukan trial aplikasi, Mitra Owlance dapat login melalui link berikut : https://demo.Owlance.id/form_login.php dengan menggunakan username dan password seperti diatas.";
    $message .= "<br>";
    $message .= "Jika bapak/ibu Mitra Owlance belum mendaftarkan diri ke Satu Sehat Kemenkes RI, bapak/ibu Mitra Owlance dapat mengakses melalu link berikut : https://satusehat.kemkes.go.id/platform/welcome";
    $message .= "<br>";
    $message .= "Kami berharap bapak/ibu langsung menganti password untuk menjaga kerahasiaan, apabila ada kesulitan dalam menggunakan aplikasi silahkan hubungi kami";

    $message .= "<br>";

    $message .= "<br>";


    $message .= "Terimakasih";
    $message .= "<br>";
    $message .= "Salam Owlance";
    /****************************************************************************************/
    $mail->Subject = $subject;
    $mail->Body = nl2br($message); //isi email
    $mail->AltBody = "PHP mailer"; //body email
    $result = $mail->send();

    if ($result) {
        $result = update_tabel('user', $data, "where email='$email' and password='$password'");
        if ($result) {
            $datax['code'] = 200;
            $datax['msg'] = 'Kami akan mengirimkan password baru ke alamat email anda. Silahkan periksa kotak masuk atau di folder spam email';
        } else {
            $datax['code'] = 500;
            $datax['msg'] = 'Maaf, Gagal mengirimkan password baru ke alamat email anda';
        }
    } else {
        $datax['code'] = 500;
        $datax['msg'] = 'Gagal Reset Password';
    }
} else {
    $datax['code'] = 500;
    $datax['msg'] = 'Email tidak terdaftar';
}

echo encryptData($datax);