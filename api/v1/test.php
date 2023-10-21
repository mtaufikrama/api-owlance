<?php

include '../encrypt.php';

header('Content-Type: application/json');

$message = "Dear [nama_pengguna]";
$message .= "<br>";
$message .= "<br>";
$message .= "Halo [nama_pengguna]";
$message .= "<br>";
$message .= "Berikut kami kirimkan kata sandi yang baru untuk login ke aplikasi Owlance";
$message .= "<br>";
$message .= "<br>";
$message .= "Username      			: [email_pengguna]";
$message .= "<br>";
$message .= "Password             	: [password_pengguna]";
$message .= "<br>";
$message .= "<br>";
$message .= "Login Owlance : https://owlance.metir.my.id/ubahpass?otp=";
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

echo $message;
