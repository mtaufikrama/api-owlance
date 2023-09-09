<?
if (!function_exists("jamPesan")) {
	function jamPesan($txt_hour="txt_jam",$default="") {
?>
<select name="<?=$txt_hour?>">
<?
    if ($default!="") {
		$jam_patokan=$default;
	} elseif ($$txt_nama!="") {
		$jam_patokan=$$txt_hour;
	} else {
		$jam_patokan=date("H");
	} 

   for( $a = 0 ; $a <= 23 ; $a++ ) {
?>
    <option value="<?=$a?>" <?=($jam_patokan==$a)?"selected":""?>><?=$a?></option>
<? } // end of for ($a=1;$a<=24;$a++) ?>
</select>
<?

}
}

/////////////////////////////////////////////////////////////////////////////////////

if (!function_exists("mntPesan")) {
	function mntPesan($txt_menit="txt_mnt",$default="") {
?>
<select name="<?=$txt_menit?>">
<?
    if ($default!="") {
		$menit_patokan=$default;
	} elseif ($$txt_nama!="") {
		$menit_patokan=$$txt_menit;
	} else {
		$menit_patokan=date("i");
	} 

   for( $x = 0 ; $x <= 59 ; $x++ ) {
	  
	  if ( $x < 10 ) {
		$x = "0".$x;
	  }
?>
    <option value="<?=$x?>" <?=($menit_patokan==$x)?"selected":""?>><?=$x?></option>
<? } ?>
</select>
<?
	}
	}

/////////////////////////////////////////////////////////////////////////////////////

if (!function_exists("dtkPesan")) {
	function dtkPesan($txt_detik="txt_dtk",$default="") {
?>
<select name="<?=$txt_detik?>">
<?
    if ($default!="") {
		$detik_patokan=$default;
	} elseif ($$txt_nama!="") {
		$detik_patokan=$$txt_detik;
	} else {
		$detik_patokan=date("s");
	} 

   for( $y = 0 ; $y <= 24 ; $y++ ) {
?>
    <option value="<?=$y?>" <?=($detik_patokan==$y)?"selected":""?>><?=$y?></option>
<? } ?>
</select>
<?
	}
} 
?>