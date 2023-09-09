<?php
function parampaging_hidden()
{
global $HTTP_POST_VARS,$HTTP_GET_VARS;

reset ($HTTP_POST_VARS);
$nama_var="";
while (list ($key, $val) = each ($HTTP_POST_VARS)) 
	{
	if($key!='hal')
		{
	$valnya=trim($val);
	$valnya=stripslashes($valnya);
   	//$valnya=ereg_replace("'","''",$valnya); # if pake access
	?>
	<INPUT TYPE="hidden" name="<?echo $key?>" value="<?echo $valnya?>">
	<?php
		}
	}
reset ($HTTP_GET_VARS);
while (list ($kuncinya, $isinya) = each ($HTTP_GET_VARS)) 
	{
	if($kuncinya!='hal')
		{

		$isinyajuga=trim($isinya);
		$isinyajuga=stripslashes($isinyajuga);
	   	//$isinyajuga=ereg_replace("'","''",$isinyajuga); # if pake access
    ?>
	<INPUT TYPE="hidden" name="<?echo $kuncinya?>" value="<?echo $isinyajuga?>">
	<?php
		}
	}

}

#======================================================================
function parampaging_kirim()
{

global $HTTP_POST_VARS,$HTTP_GET_VARS;

if (!isset($HTTP_POST_VARS)) {
	$HTTP_POST_VARS = $_POST;
}

if (!isset($HTTP_GET_VARS)) {
	$HTTP_GET_VARS = $_GET;
}

reset ($HTTP_POST_VARS);
$nama_var="";
while (list ($key, $val) = each ($HTTP_POST_VARS)) 
	{
	if($key!='hal')
		{
	$valnya=trim($val);
	$valnya=stripslashes($valnya);
   	//$valnya=ereg_replace("'","''",$valnya); # if pake access
    $nama_var=$nama_var."&".$key."=".urlencode($valnya);
		}
	}
reset ($HTTP_GET_VARS);
while (list ($kuncinya, $isinya) = each ($HTTP_GET_VARS)) 
	{
	if($kuncinya!='hal')
		{
		$isinyajuga=trim($isinya);
		$isinyajuga=stripslashes($isinyajuga);
	   	//$isinyajuga=ereg_replace("'","''",$isinyajuga); # if pake access
    $nama_var=$nama_var."&".$kuncinya."=".urlencode($isinyajuga);
		}
	}
$tambah_param=$nama_var;
return $tambah_param;
}
#=======================================================================================================
function paging_bawah($obj_paging,$lebartabelpaging="100%",$parampaging="",$namarecordpaging="Record",$cetak_yah="")
{

	global $hal,$PHP_SELF;
	
	global $judul_form_general,$ada_nomer_form_general,$sql_form_general,$kolom_utama_form_general,$kolom_isi_form_general,$lebar_form_general,$kanan_form_general,$tengah_form_general,$hal_pertama_form_general,$hal_selanjutnya_form_general,$fungsi_form_general,$nomor_fungsi_form_general;

$kiriman_cetak="judul_form_general=".urlencode($judul_form_general)."&ada_nomer_form_general=".urlencode($ada_nomer_form_general)."&sql_form_general=".urlencode($sql_form_general)."&kolom_utama_form_general=".urlencode($kolom_utama_form_general)."&kolom_isi_form_general=".urlencode($kolom_isi_form_general)."&lebar_form_general=".urlencode($lebar_form_general)."&kanan_form_general=".urlencode($kanan_form_general)."&tengah_form_general=".urlencode($tengah_form_general)."&hal_pertama_form_general=".urlencode($hal_pertama_form_general)."&hal_selanjutnya_form_general=".urlencode($hal_selanjutnya_form_general)."&fungsi_form_general=".urlencode($fungsi_form_general)."&nomor_fungsi_form_general=".urlencode($nomor_fungsi_form_general);

$banyaknyahalaman = $obj_paging->pagingVars["lastpage"];

if(($banyaknyahalaman=="") or ($banyaknyahalaman<1) )
	{
	$banyaknyahalaman="1";
	}

if($lebartabelpaging=='')
		{
		$lebartabelpaging="100%";
		}

$tambah_param=parampaging_kirim();

if($hal=="")
	{
	$hal=1;
	}

?>

	<table border="0" cellpadding="0" cellspacing="0" width="100%" class="paging">
	  <tr>
		<td width="225" class="pagingKiri">
			<table cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td>
						<?php If ($hal >0) {$hal_awal=1;} else {$hal_awal=0;}?>
						<?php If ($hal >1 ){?>
						<button class="submit02" onClick="window.location.href='<? echo $PHP_SELF?>?hal=<? echo $hal_awal?><? echo $tambah_param?>'"><img src="/_images/btn_first.gif"></button>
						<?php }else{ ?>
						<button class="submit03" disabled><img src="/_images/btn_first.gif"></button>
						<?php }# end of if hal=1?>
					</td>
					<td>
						<?php If ($hal >1 ){?>
						<button class="submit02" onClick="window.location.href='<? echo $PHP_SELF?>?hal=<? echo $hal-1 ?><? echo $tambah_param?>'"><img src="/_images/btn_prev.gif"></button>
						<?php }else{ ?>
						<button class="submit03" disabled><img src="/_images/btn_prev.gif"></button>
						<?php }# end of if hal=1?>
					</td>
					<td>
						<div class="navHal">Halaman <b><?php echo $hal?></b> dari <?php echo ($banyaknyahalaman)?></div>
					</td>
					<td>
						<?php If ($hal <($banyaknyahalaman)) {?>
						<button class="submit02" onClick="window.location.href='<?echo $PHP_SELF?>?hal=<? echo $hal+1 ?><? echo $tambah_param?>'"><img src="/_images/btn_next.gif"></button>
						<?php }else{?>
						<button class="submit03" disabled><img src="/_images/btn_next.gif"></button>
						<?php }#end of $hal=$banyaknyahalaman ?>
					</td>
					<td>
						<?php If ($hal <($banyaknyahalaman)) {?>
						<button class="submit02" onClick="window.location.href='<?php echo $PHP_SELF?>?hal=<?php echo $banyaknyahalaman ?><?php echo $tambah_param?>'"><img src="/_images/btn_last.gif"></button>
						<?php }else{?>
						<button class="submit03" disabled><img src="/_images/btn_last.gif"></button>
						<?php }#end of $hal=$banyaknyahalaman ?>
					</td>
				</tr>
			</table>
		</td>
		<td align="left" style="color:white; font-size:10px; padding-left:20px;" class="pagingTengah">Terdapat <B><span id="_total_record"><?=total_record($obj_paging)?></span></B> Record</td>
		<td align="right" class="pagingKanan">
		<form action="<?php echo $PHP_SELF?>" method="get" name="formpagingy" onsubmit='return fungsiy()' >
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td style="color:white; font-size:10px; padding-right:3px;">Ke Halaman</td>
					<td style="padding:0px 2px ">
					<input name="hal" type="text" size="2" style="width:25px; height:16px;">
					<?php parampaging_hidden()?>
					</td>
					<td><button class="submit02" onclick="javascript: if (validatey(this.form.hal)) form.submit();"><img src="/_images/btn_go.gif"></button></td>
				</tr>
			</table>
		</form>
		</td>
	  </tr>
	</table>

<script language="JavaScript">
	

	function fungsiy() {
		if (document.formpagingy.hal.value><?php echo ($banyaknyahalaman) ?> || document.formpagingy.hal.value<=0 || document.formpagingy.hal.value==""){ 
			window.alert("Angka yang anda isikan harus valid");
			return false;
		}
	}

	function validatey(field) {
		var valid = "0123456789"
		var temp;
		var ok;

		if (field.value.length == 0) {
			alert("Pengisian form ini hanya berlaku angka");
			field.focus();
			field.select();
			return false;
		}

		ok = "yes";

		for (var i = 0; i < field.value.length; i++) {
			temp = "" + field.value.substring(i, i + 1);
			if (valid.indexOf(temp) == "-1") ok = "no";
		}

		if (ok == "no") {
			alert("Pengisian Form ini Hanya Berlaku Angka");
			field.focus();
			field.select();
			return false;
		} else if (<?= $banyaknyahalaman ?> < field.value) {
			alert("Halaman tujuan tidak sesuai dengan jumlah halaman");
			field.focus();
			field.select();
			return false;
		}

		return true;
	}
</script>

<?php
}

function total_record($obj_paging) {
	return $obj_paging->pagingVars["maxrecords"];
}

function awal_record($obj_paging) {
	return $obj_paging->records["start"];
}

function akhir_record($obj_paging) {
	return $obj_paging->records["end"];
}




function paging_nomor($obj_paging) {
	global $hal, $PHP_SELF;

	$banyaknyahalaman = $obj_paging->pagingVars["lastpage"];

if(($banyaknyahalaman=="") or ($banyaknyahalaman<1) )
	{
	$banyaknyahalaman="0";
	}


$tambah_param=parampaging_kirim();
		?>

		<TABLE align="center" width="<?echo $lebartabelpaging?>" border="0" cellspacing="0" cellpadding="0">
<tr><td align="center" >Halaman :


<?php
for ($i=1; $i<=$banyaknyahalaman;$i++){

?>

<a href="<?=$PHP_SELF?>?hal=<? echo $i ?><?echo $tambah_param?>" style="text-decoration:none">
	<?php
	if ($i==$hal)
	{
	echo"<b>".$i."</b>";
	}
	else
	{
	echo $i;
	}
	?>  </a>

&nbsp;
<?php

}
?>
</td></tr>
</TABLE>
<?php
}# end of function nomor_paging;

function jumlah_paging($obj_paging) {
	global $hal, $PHP_SELF;

	$banyaknyahalaman = $obj_paging->pagingVars["lastpage"];

	return $banyaknyahalaman;
}# end of function nomor_paging;

?>