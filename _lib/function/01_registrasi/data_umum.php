<?
session_start();
require_once("../_lib/function/db.php");
loadlib("function","function.olah_tabel");
loadlib("function","function.date2str");
loadlib("function","function.datetime");


    $sql = &$db->Execute("SELECT * FROM mt_master_pasien where no_mr='$no_mr'");
	$no_mr = $sql->fields["no_mr"];
	$nama_pasien = $sql->fields["nama_pasien"];
	$gol_darah = $sql->fields["gol_darah"];
	$jen_kelamin = $sql->fields["jen_kelamin"];
	$tgl_lhr = $sql->fields["tgl_lhr"];
	$alergi = $sql->fields["alergi"];
	$nama_panggilan = $sql->fields["nama_panggilan"];
	$nama_kel_pasien = $sql->fields["nama_kel_pasien"];
	$tempat_lahir = $sql->fields["tempat_lahir"];
	$kode_agama = $sql->fields["kode_agama"];
	$kebangsaan = $sql->fields["kebangsaan"];
	$suku = $sql->fields["suku"];
	$almt_ttp_pasien=$sql->fields["almt_ttp_pasien"];
	$tlp_almt_ttp=$sql->fields["tlp_almt_ttp"];
	$alamat_lokal=$sql->fields["alamat_lokal"];
	$tlp_almt_lkl=$sql->fields["tlp_almt_lkl"];
	$kode_kelompok=$sql->fields["kode_kelompok"];
	$kode_perusahaan=$sql->fields["kode_perusahaan"];
	$kode_pendidikan=$sql->fields["kode_pendidikan"];


	if($kode_kelompok==""){
	$kode_kelompok=0;
	}

	if($kode==""){
		$bagian="Poli";
	}elseif($kode==1){
		$bagian="Penunjang Medis";
	}elseif($kode==2){
		$bagian="Instalasi Gawat Darurat";
	}elseif($kode==3){
	$bagian="Rawat Inap";
	}

	// Identifikasi Agama :
	if($kode_agama==""){
		$kode_agama=0;
		}
	$agama=baca_tabel("dc_agama","agama","where id_dc_agama=$kode_agama");

	//Identifikasi Sex :

	if($jen_kelamin=="P"){
	$sex="PEREMPUAN";
	}else{
	$sex="LAKI-LAKI";
	}


?>
<html>

<head>
	<title>Averin Intranet Application Framework - Interface</title>
	<? include("../_inc/tpl_incHtmlHead.php"); ?>
</head>

<body scroll="no">
	<div id="topLayer" class="loading"></div>

	<!-- ========================================================================================= -->
	<div id="isiAtas">

		<div id="barJudul">Layout Model Detail</div>
		
		<div id="barTools">
		<?
			if($loginInfo["modul"]==2){
		?>
			<?if ($bayi==""){?>
			<a href="edit_data_umum.php?no_mr=<?=$no_mr?>&kode=<?=$kode?>&bayi=<?=$bayi?>" class="tool">Edit</a>
			<?}else{?>
			<a href="data_umum_edit.php?no_mr=<?=$no_mr?>&kode=<?=$kode?>&bayi=<?=$bayi?>" class="tool">Edit</a>
			<?}?>
			<a href="cetak_identitas_print.php?no_mr=<?=$no_mr?>&kode<?=$kode?>" class="tool">Cetak Identitas</a>
			<a href="cetak_kartu_print.php?no_mr=<?=$no_mr?>&kode<?=$kode?>" class="tool">Cetak Kartu</a>
			<a href="edit_penanggung.php?no_mr=<?=$no_mr?>&kode<?=$kode?>" class="tool">Penanggung</a>
		<?}?>&nbsp;
		</div>
		

	</div>
	<!-- ========================================================================================= -->

	<!-- ========================================================================================= -->
	<div id="isiUtama">

		<table cellpadding="0" cellspacing="0" class="formView">
		<tr>
			<!-- --------------------------------------------------------------------------------- -->
			<td class="kiri">

				<table cellpadding="0" cellspacing="3">
				<tr>
					<td class="field">No. MR</td>
					<td class="input"><?=$no_mr?>&nbsp;</td>
				</tr>
				<tr>
					<td class="field">Nama Pasien</td>
					<td class="input"><?=str_replace("\\","",$nama_pasien)?>&nbsp;</td>
				</tr>
				<tr>
					<td class="field">Panggilan </td>
					<td class="input"><?=$nama_panggilan?>&nbsp;</td>
				</tr>
				<tr>
					<td class="field">Nama Keluarga</td>
					<td class="input"><?=str_replace("\\","",$nama_kel_pasien)?>&nbsp;</td>
				</tr>
				<tr>
					<td class="field">Tempat, Tgl Lahir </td>
					<td class="input"><?=$tempat_lahir." , " . date2str($tgl_lhr)?>&nbsp;</td>
				</tr>
				<tr>
					<td class="field">Nasabah </td>
					<td class="input">
						<?
				
					if($kode_kelompok!=2){
						$nama_kelompok=baca_tabel("mt_nasabah","nama_kelompok","where kode_kelompok=$kode_kelompok");
						echo $nama_kelompok;
					}else{
						$nama_perusahaan=baca_tabel("mt_perusahaan","nama_perusahaan","where kode_perusahaan=$kode_perusahaan");
						echo $nama_perusahaan;
					}
				
				
				?>
					&nbsp;</td>
				</tr>
				<tr>
					<td class="field">Umur </td>
					<td class="input"><?=umur($tgl_lhr)?>&nbsp;Th</td>
				</tr>
				<tr>
					<td class="field">Jenis Kelamin </td>
					<td class="input">
					<?=$sex?>&nbsp;</td>
				</tr>
				<tr>
					<td class="field">Agama /Kepercayaan </td>
					<td class="input"><?=$agama?>&nbsp;</td>
				</tr>
				<tr>
					<td class="field">Kebangsaan </td>
					<td class="input"><?=$kebangsaan?>&nbsp;</td>
				</tr>
				<tr>
					<td class="field">Suku  </td>
					<td class="input"><?=$suku?>&nbsp;</td>
				</tr>
				<tr>
					<td class="field">Pendidikan   </td>
					<td class="input">
					<?
					if($kode_pendidikan==""){
					$kode_pendidikan=0;
					}

						$pendidikan=baca_tabel("dc_pendidikan","pendidikan","Where id_dc_pendidikan=$kode_pendidikan");

						echo $pendidikan;

					?>
					&nbsp;</td>
				</tr>
				<tr>
					<td class="field">Alamat Tetap</td>
					<td class="input"><?=$almt_ttp_pasien?>&nbsp;</td>
				</tr>
				<tr>
					<td class="field">Telepon 1</td>
					<td class="input"><?=$tlp_almt_ttp?>&nbsp;</td>
				</tr>
				<tr>
					<td class="field">Alamat Lokal </td>
					<td class="input"><?=$alamat_lokal?>&nbsp;</td>
				</tr>
				<tr>
					<td class="field">Telepon 2</td>
					<td class="input"><?=$tlp_almt_lkl?>&nbsp;</td>
				</tr>
				<tr>
					<td class="field">Alergi</td>
					<td class="input"><font color="red"><?=$alergi?></font>&nbsp;</td>
				</tr>

				</table>

			</td>
			<!-- --------------------------------------------------------------------------------- -->

			<!-- --------------------------------------------------------------------------------- -->
			<!-- <td class="kanan">

				<table cellpadding="0" cellspacing="3">
				<tr>
					<td class="field">Tempat Lahir</td>
					<td class="input">Jakarta</td>
				</tr>
				<tr>
					<td class="field">Tanggal Lahir</td>
					<td class="input">12-5-1978</td>
				</tr>
				<tr>
					<td class="field">Agama/Kepercayaan</td>
					<td class="input">Islam</td>
				</tr>
				</table>

			</td> -->
			<!-- --------------------------------------------------------------------------------- -->
		</tr>
		</table>

	</div>
	<!-- ========================================================================================= -->
		<div id="isiBawah">&nbsp;</div>
	<!-- ========================================================================================= -->

<!-- ############################################################################################# -->
<script language="JavaScript" type="text/javascript">

window.onload = function()
{
	initHalaman()
}

</script>
</body>

</html>