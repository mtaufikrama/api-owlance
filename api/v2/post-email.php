<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once "../../library/PHPMailer.php";
require_once "../../library/Exception.php";
require_once "../../library/OAuth.php";
require_once "../../library/POP3.php";
require_once "../../library/SMTP.php";

$mail->SMTPDebug = 3;
$mail = new PHPMailer;      
$mail->isSMTP();                          
//$mail->Host = "srv42.niagahoster.com"; //host mail server (sesuaikan dengan mail hosting Anda)
// $mail->Host = "smtp.gmail.com"; //host mail server (sesuaikan dengan mail hosting Anda)
$mail->Host = "mbx.averin.co.id"; //host mail server (sesuaikan dengan mail hosting Anda)
//Set this to true if SMTP host requires authentication to send email
$mail->SMTPAuth = true;     
//Provide username and password               
//$mail->Username = "saga@averin.co.id";   //nama-email smtp     
//$mail->Password = "Averin1234!";           //password email smtp  
               
$mail->Username = "adokter@averin.co.id";   //nama-email smtp  
$mail->Password = "Averin@2023!";           //password email smtp  

$mail->SMTPSecure = "ssl"; 
$mail->Port = 465;  
$mail->From = "adokter@averin.co.id"; //email pengirim
$mail->FromName = "ADOKTER"; //nama pengirim
$mail->addAddress($email, "");

$recipients = array(
'adokter@averin.co.id' => 'CC 1',
// ..
);/**/
foreach($recipients as $email => $name)
{
   $mail->AddCC($email, $name);
}

$mail->isHTML(true);
$subject='REGISTRASI A-DOKTER';
$message=$keterangan;

$mail->isHTML(true);
			$subject='PASSWORD AKTIVASI A-DOKTER';
			$message ="Dear " .$nama_pegawai;
			$message .="<br>";
			$message .="Halo ".$nama_pegawai;
			$message .="<br>";
			$message .="Selamat kami dari team A-Dokter , menginformasikan bahwa Sistem A-Dokter telah dapat digunakan dan bapak/ibu yang telah terdaftar dapat melengkapi data-data secara langsung dengan menggunakan email yang sudah terdaftar dan password yang kami kirimkan melalui email";
			$message .="<br>";
			$message .="<br>";
			$message .="Login A-Dokter : https://a-dokter.id/form_login.php";
			$message .="<br>";
			$message .="Username      			: ".$username;
			$message .="<br>";
			$message .="Password             	: ".$password;
			$message .="<br>";
			$message .="<br>"; 

			$message .="Kami berharap bapak/ibu langsung menganti password untuk menjaga kerahasiaan, apabila ada kesulitan dalam menggunakan aplikasi silahkan hubungi kami";

			$message .="<br>";  

			$message .="<br>"; 
			 

			$message .="Terimakasih";
			$message .="Salam A-Dokter";
			/****************************************************************************************/	
		$mail->Subject = $subject;
		$mail->Body = nl2br($message); //isi email
		$mail->AltBody = "PHP mailer"; //body email
		$mail->send();

			if(!$mail->send()) {
				// echo "test";
				// echo 'Message could not be sent.';
				// echo 'Mailer Error: ' . $mail->ErrorInfo;
				// $result=false;
				
			} else {
			
			} 
			
			
			/****************************************************************************************/		
	//$result=false;
	$db->CommitTrans($result !== false);
	//KIRIM LOGIN VIA EMAIL
	if($result){
		$data['code']='200';
	}else{
		$data['code']='500';
	}
	echo json_encode($data);
?>