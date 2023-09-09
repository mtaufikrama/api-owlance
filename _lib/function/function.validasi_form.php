<?
function validasi_form($nama_form,$field_form_f,$ket_form_f="",$nama_fungsi_f="validasi_form"){
$cek_field=split(",",$field_form_f);
$nama_field=split(",",$ket_form_f);
$banyak_cekfield=count($cek_field);

?>



<script language="JavaScript">
<!--

function <?echo $nama_fungsi_f?>() {
	<?for ($i=0; $i<$banyak_cekfield; $i++)
	{	
	?>
	if(document.<? echo $nama_form ?>.<?echo $cek_field[$i]?>.value==''){
	window.alert("Form <? echo $nama_field[$i] ?> belum diisi");
	document.<? echo $nama_form ?>.<? echo $cek_field[$i] ?>.focus();
	return false;
    }
	<?
	}
	?>
	}

	//-->
</script>

<?
}
?>

<script language="JavaScript">
<!--
function cek_angka(field,nama_form) {
	var valid = "0123456789"
	var ok = "yes";
	var temp;
	var nama_form;
	for (var i=0; i<field.value.length; i++) {
	temp = "" + field.value.substring(i, i+1);
	if (valid.indexOf(temp) == "-1") ok = "no";
	}
	if (ok == "no") {
		alert("Pengisian Field Ini Hanya Berlaku Angka");
		field.focus();
		//field.select();
		return false;
		}
	}


function cek_angka_kar(field2) {
	var valid = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ@ "
	var ok = "yes";
	var temp;
	for (var i=0; i<field2.value.length; i++) {
	temp = "" + field2.value.substring(i, i+1);
	if (valid.indexOf(temp) == "-1") ok = "no";
	}
	if (ok == "no") {
		alert("Pengisian Form ini Hanya Berlaku Angka dan karakter");
		field.focus();
		//field.select();
		return false;
		}
	}




//-->
</script>
