<?
	session_start();
	/**
	 *
	 * Mendeklarasikan librari-librari dasar
	 *
	 */	 
	require_once("../_lib/function/db.php");
	loadlib("function","variabel");
	loadlib("class","Paging");
	loadlib("function","function.olah_tabel");
	loadlib("function","function.datetime");
	
	/**
	 *
	 * $sqlPlus, query tambahan untuk proses penelusuran
	 * Bagian ini hanya contoh...disesuaikan dengan kondisi pencarian yang ada
	 *
	 */

	switch ($tipeCari) {
		case "nama" :
			$sqlPlus = "AND nama_pasien LIKE '$filter%'";
			break;
		case "mr" :
			//$filter = (int)$filter;
			$sqlPlus = "AND no_mr like '%$filter%'";
			break;
		case "lahirTgl";
			$filter = $filter;
			$sqlPlus = "AND tgl_lahir = $filter";
			break;
		case "ktp";
			$filter = $filter;
			$sqlPlus = "AND no_ktp like '%$filter%'";
			break;
		case "telp";
			$filter = $filter;
			$sqlPlus = "AND tlp_almt_ttp like '%$filter%'";
			break;
		case "alamat";
			$filter = $filter;
			$sqlPlus = "AND almt_ttp_pasien like '%$filter%'";
			break;
		default :
			$sqlPlus = "";
	}

	/**
	 *
	 * $sql, query utama
	 *
	 */

	$sql = "select * from gd_daftar_antrian_v WHERE tgl_keluar is not null $sqlPlus  order by tgl_keluar DESC";

	/**
	 *
	 * Proses pembuatan pagging
	 * $recperpage		: Berisikan jumlah baris untuk tiap halaman
	 *
	 */
	
	$recperpage = 18;

	$pagenya = new Paging($db, $sql, $recperpage);
	$rsPaging = $pagenya->ExecPage($hal);
	$NoAwal = ($hal == "" || $hal < 1) ? 0 : ($rsPaging->_currentPage - 1) * $recperpage;

	/**
	 *
	 * Akhir proses pembuatan pagging
	 *
	 */
?>
<html>
	<head>
		<title>Averin Intranet Application Framework - Pagging Template</title>
		<? 
			include("../_inc/tpl_incHtmlHead.php"); 
		?>
	</head>
	<body scroll="no">
		<div id="topLayer" class="loading"></div>
		<!-- ========================================================================================= -->
		<div id="isiAtas">
			<div id="barJudul">Instalasi Gawat Darurat</div>
			<div id="barTools">
				<form method="get" action="<?= $PHP_SELF ?>">
					<table cellpadding="0" cellspacing="0" class="singleRow">
						<tr>
							<td><b>Cari  </b></td>
							<td>
								<select name="tipeCari">
									<option value="nama" <?= ($tipeCari == "nama") ? ("selected") : ("") ?>>Nama</option>
									<option value="mr" <?= ($tipeCari == "mr") ? ("selected") : ("") ?>>MR</option>
									<option value="lahirTgl" <?= ($tipeCari == "lahirTgl") ? ("selected") : ("") ?>>Lahir Tgl</option>
									<option value="ktp" <?= ($tipeCari == "ktp") ? ("selected") : ("") ?>>KTP</option>
									<option value="telp" <?= ($tipeCari == "telp") ? ("selected") : ("") ?>>Telp</option>
									<option value="alamat" <?= ($tipeCari == "alamat") ? ("selected") : ("") ?>>Alamat</option>
								</select>
							</td>
							<td><input type="text" size="20" value="<?= $filter ?>" name="filter"></td>
							<td><input type="submit" name="cari" value="Cari" class="submit01"></td>
						</tr>
					</table>
				</form>
			</div>
		</div>
		<!-- ========================================================================================= -->

		<!-- ========================================================================================= -->
		<div id="isiUtama">
			<table cellpadding="0" cellspacing="0" class="tblUtama">
				<thead>
					<tr>
						<th class="thno">No.</th>
						<th width="10%">No Mr</th>
						<th width="5%">No Registrasi</th>
						<th width="15%">Tgl Masuk</th>
						<th width="15%">Tgl Keluar</th>
						<th>Nama</th>
						<th>Status</th>
					</tr>
				</thead>
				<tbody>
		<!-- ========================================================================================= -->
		<? 
			$i = $pagenya->pagingVars["firstno"];
		
			while ($tampil=$rsPaging->FetchRow()) {
				$i++;
				$no_mr = $tampil["no_mr"];
				$no_registrasi = $tampil["no_registrasi"];
				$no_kunjungan = $tampil["no_kunjungan"];
				$nama_pasien = $tampil["nama_pasien"];
				$almt_ttp_pasien = $tampil["almt_ttp_pasien"];
				$nama_pegawai = $tampil["nama_pegawai"];
				$kode_gd = $tampil["kode_gd"];
				$tgl_keluar = $tampil["tgl_keluar"];
				$tgl_masuk = $tampil["tgl_masuk"];


				$pasien_out = baca_tabel("mt_master_pasien","status_meninggal","where no_mr='$no_mr'");
				//$status_out = baca_tabel("tc_trans_pelayanan","status_selesai","where no_mr='$no_mr' and no_registrasi='$no_registrasi'");
				$status_out = baca_tabel("tc_kunjungan","status_keluar","where no_mr='$no_mr' and no_registrasi='$no_registrasi' and no_kunjungan=$no_kunjungan");
				if ($pasien_out=="1"){
					$hasil = "Meninggal";
				} else {
					if ($status_out=="1"){
						$hasil = "Dirujuk Ke Rawat Inap";
					} else if ($status_out=="3") {
						$hasil = "Pulang";
					} else {
						$hasil = "Meninggal";
					}
				}
				



				
		?>
					<tr>
						<td class="tdno"><?= $i ?>.</td>
						<td align="center"><?= $no_mr ?>&nbsp;</td>
						<td><?= $no_registrasi ?>&nbsp;</td>
						<td><?=date2str($tgl_masuk)?>&nbsp;<?=date2hour($tgl_masuk)?></td>
						<td><?=date2str($tgl_keluar)?>&nbsp;<?=date2hour($tgl_keluar)?></td>
						<td><a href="detail_pasien_keluar_view.php?no_mr=<?=$no_mr?>&kode=2&no_kunjungan=<?=$no_kunjungan?>&no_registrasi=<?=$no_registrasi?>&kode_gd=<?=$kode_gd?>" onclick=""><b><?= str_replace("\\","",$nama_pasien) ?></b></a>&nbsp;</td>
						<td><?= $hasil?>&nbsp;</td>
					</tr>
		<?
			}  //end of while ($rsPaging->FetchRow())
		?>  
					<!-- Dummy Data test -->
					<!-- <tr>
						<td class="tdno">1</td>
						<td align="center">000011&nbsp;</td>
						<td align="center">01&nbsp;</td>
						<td align="center">18-04-2006 16:46:30&nbsp;</td>
						<td><a href="detail_pasien_keluar_view.php?no_mr=000028&no_kunjungan=3" onclick=""><b>Ismail Haniyya</b></a>&nbsp;</td>
						<td><?= $almt_ttp_pasien ?>&nbsp;</td>
					</tr> -->
	<!-- ========================================================================================= -->
				</tbody>
			</table>
		</div>
	<!-- ========================================================================================= -->
		<div id="isiBawah">
		<?
			$pagenya->PageNav($pagenya); 
		?>
		</div>
	<!-- ========================================================================================= -->
		<script language="JavaScript" type="text/javascript">
			window.onload = function() {
				initHalaman();
			}
		</script>
	</body>
</html>