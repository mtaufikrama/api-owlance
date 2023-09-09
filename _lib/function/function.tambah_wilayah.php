<?
if (!function_exists("tambah_wilayah")) {
	function tambah_wilayah($param_wilayah,$id_wilayah) {

		if($param_wilayah=='' || $id_wilayah=='')echo "<script language=javascript>alert('PARAMETER KURANG !')</script>";

		$param_wilayah=strtoupper(trim($param_wilayah));
		switch ($param_wilayah){
			case 'PROPINSI':
				$judul="Propinsi";
			break;
			case 'KOTA':
				$judul="Kota";
			break;
			case 'KECAMATAN':
				$judul="Kecamatan";
			break;
			case 'KELURAHAN':
				$judul="Kelurahan";
			break;
			default:
				$judul="Propinsi";
		}
?>
<html>
	<head>
		<title>Averin Intranet Application Framework - Form Input DB</title>
		<? include("../_inc/tpl_incHtmlHead.php"); ?>	</head>
	<body scroll="no">
		<div id="topLayer" class="loading"></div>
		<!-- ========================================================================================= -->
		<div id="isiAtas">
			<div id="barJudul">Tambah <?=$judul?></div>
		</div>
		<!-- ========================================================================================= -->

		<!-- ========================================================================================= -->
		<div id="isiUtama">
				<table cellpadding="0" cellspacing="0" class="formInput">
					<tr>
		<!-- --------------------------------------------------------------------------------- -->
						<td class="kiri">
							<table cellpadding="0" cellspacing="0">
								<tr>
									<td class="field">Propinsi</td>
									<td class="input">
										<select name="id_dc_propinsi">
										<?
										$sql_kelompok = "select * from dc_propinsi";
										pilihan_list($sql_kelompok,"nama_propinsi","id_dc_propinsi","id_dc_propinsi",$id_dc_propinsi);
										?>
										</select>
									</td>
								</tr>
								<tr>
									<td class="field">Nama Kota</td>
									<td class="input"><input type="text" name="nama_kota" value="<?= $nama_kota ?>"/></td>
								</tr>
								<tr>
									<td class="field">Inisial Kota</td>
									<td class="input"><input type="text" name="inisial_kota" value="<?= $inisial_kota ?>"/></td>
								</tr>
								
							</table>
						</td>
		<!-- --------------------------------------------------------------------------------- -->

		<!-- --------------------------------------------------------------------------------- -->
						
								<!-- --------------------------------------------------------------------------------- -->
					</tr>
				</table>
				<div class="formInputSubmit"><input type="submit" name="Submit" value="Submit" class="submit01" onclick="javascript: return validasiForm(this);"></div>
			</form>
		</div>
		<!-- ========================================================================================= -->

		<!-- ############################################################################################# -->
		<script language="JavaScript" type="text/javascript">
			window.onload = function() {
				initHalaman();
			}
		</script>
	</body>
</html>
<?
	} //function tambah_wilayah() {
} //if (!function_exists("tambah_wilayah")) {
?>