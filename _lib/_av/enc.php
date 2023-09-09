<?
include "../function/db.php";
include WWWROOT."/_lib/_av/password_protect.php";
include WWWROOT."/_lib/_av/function.enkrip.php";


?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE> New Document </TITLE>
<META NAME="Generator" CONTENT="EditPlus">
<META NAME="Author" CONTENT="">
<META NAME="Keywords" CONTENT="">
<META NAME="Description" CONTENT="">
</HEAD>

<BODY>

<FORM METHOD=POST ACTION="">
kata asal : <INPUT TYPE="text" NAME="kata_asal"><INPUT TYPE="submit" value="ENKRIP">
<br>
hasil enkrip : <?= enkrip($kata_asal)?>

<br>
kata hasil enkrip : <INPUT TYPE="text" NAME="kata_hasil"><INPUT TYPE="submit"  value="DEKRIP">
<br>
hasil Dekrip : <?= dekrip($kata_hasil)?>
</FORM>
</BODY>
</HTML>
