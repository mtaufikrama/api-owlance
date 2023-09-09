<?
/**
 * Function buat generate javascript utk ajax
 *
 * @param string $url URL target
 * @param string $id_target ID dari elemen yg innerHTML-nya mau diganti hasil dari ajax
 * @param string $nama_elemen_target Nama element targetnya
 * @param string $nama_parameter Nama parameter yg akan dikirim lewat ajax
 * @param string $fungsi_ajax Nama fungsi javascript utk ajax
 * @param string $fungsi_action Nama fungsi javascript utk action ajax
 * @param string $onchange javascript to execute onchange event
 */
if (!function_exists('ajax_js')) {
function ajax_js($url, $id_target, $nama_elemen_target, $nama_parameter, $fungsi_ajax, $fungsi_action, $onchange="") {
?>
<script type="text/javascript">
function <?=$fungsi_ajax?>(elm) {
	var frm = elm.form;
	var url = '<?=$url?>?<?=$nama_parameter?>=' + elm.value + '&<?=$onchange!=""?"fn_chg=".urlencode($onchange):""?>';
	if (elm.value.length>0) {
		retrieveData(url, '<?=$fungsi_action?>');
	} else {
		document.getElementById('<?=$id_target?>').innerHTML = '<select name="<?=$nama_elemen_target?>"><option value="">-- Pilih --</option></select>';
	}
}
function <?=$fungsi_action?>(obj) {
	document.getElementById('<?=$id_target?>').innerHTML = obj.responseText;
}
</script>
<?
}
}
?>
