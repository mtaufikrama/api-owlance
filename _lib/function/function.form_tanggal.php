<?
/*
PUNK-07/06/2012-15:11:13 
PERHATIAN:
definisi nama_from(variabel pertama) name harus ditentukan terpisah bila menggunakan fungsi ini lebih dari 1x dalam 1 form yg sama ! 
 */

if (!function_exists("form_tanggal")) {
	function form_tanggal($nama_form='txt_form',$nama_tgl='txt_tanggal',$nama_bln='txt_bulan',$nama_thn='txt_tahun',$default_tgl="",$default_bln="",$default_thn="") {

	if(trim($default_tgl)!=''){
		$default_tgl=trim($default_tgl);
	} else {
		$default_tgl=date('d');
	}
	
	if(trim($default_bln)!=''){
		$default_bln=trim($default_bln);
	} else {
		$default_bln=date('n');
	}
	
	if(trim($default_thn)!=''){
		$default_thn=trim($default_thn);
	} else {
		$default_thn=date('Y');
	}
?>
	<script language="JavaScript" type="text/JavaScript" src="/_js/js_tanggal.js"></script>
<?
	//START KOLOM TANGGAL:
?>
	<select name="<?=$nama_tgl?>">
<?

	for ($i_tgl=1;$i_tgl<=31;$i_tgl++)
	{
?>
		<option value="<?=$i_tgl?>" <?=($i_tgl==$default_tgl)?'selected':''?>><?=$i_tgl?></option>
<?
	} 
?>
	</select>
	&nbsp;
<?
	//END KOLOM TANGGAL:
?>
<?
	//START KOLOM BULAN
?>
	<select name="<?=$nama_bln?>" onchange="tanggalJS('<?=$nama_form?>','<?=$nama_tgl?>','<?=$nama_bln?>','<?=$nama_thn?>',this);">
<?
	$arr_bulan=array("Jan","Feb","Mar","Apr","Mei","Jun","Jul","Agt","Sep","Okt","Nov","Des");

	for ($i_bln=1;$i_bln<=12;$i_bln++)
	{
?>
		<option value="<?=$i_bln?>" <?=($i_bln==$default_bln)?'selected':''?>><?=$arr_bulan[$i_bln-1]?></option>
<?
	}
?>
	</select>
	&nbsp;
<?
	//END KOLOM BULAN:
?>
<?
	//START KOLOM TAHUN:
?>
<input type="text" name="<?=$nama_thn?>" value="<?=$default_thn?>" maxlength="4" size="4" onKeypress="if (event.keyCode < 48 || event.keyCode > 57) event.returnValue = false;" onblur="tanggalJS('<?=$nama_form?>','<?=$nama_tgl?>','<?=$nama_bln?>','<?=$nama_thn?>',this);">
<?
	//END KOLOM TAHUN:
?>

<?
	} // end of if(!function_exists("form_tanggal"))
} // end of function form_tanggal()

?>