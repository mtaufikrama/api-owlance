<?session_start();
  require_once("../_lib/function/db.php");
  loadlib("function","function.date2str");
  loadlib("function","function.olah_tabel");
  $user_dtg=$loginInfo["no_induk"];
  if($user_dtg!=""){
	$nama_user=baca_tabel("dd_user","username","WHERE id_dd_user=$user_dtg");
  }
	$nama_user = $loginInfo["nama_user"];
	//Perusahaan :
	$sqlPr = "SELECT * FROM dd_konfigurasi";
	$hasil=&$db->Execute($sqlPr);
	$nama_perusahaan=$hasil->fields["nama_perusahaan"];
	$telpon=$hasil->fields["telpon"];
	$alamat=$hasil->fields["alamat"];
	$fax=$hasil->fields["fax"];

	if($dokter==""){
	$dokter=0;
	}

	if(trim($bagian)==""){
	$bagian=0;
	}
	
  // Informasi Registrasi
 
  $sql_kunjungan = read_tabel("tc_kunjungan","*","WHERE no_kunjungan=$no_kunjungan AND no_mr='$no_mr' AND tgl_keluar IS NULL");
	$tgl_jam_masuk = $sql_kunjungan->fields["tgl_masuk"];
	list($tgl_masuk, $jam_masuk) = split("[ ]",$tgl_jam_masuk);
	
  // Informasi Pasien
 
  $sql_pasien=read_tabel("mt_master_pasien","*","where no_mr='$no_mr'");
  $nama_pasien=$sql_pasien->fields["nama_pasien"];
  $nama_kel_pasien=$sql_pasien->fields["nama_kel_pasien"];
  $kode_kelompok=$sql_pasien->fields["kode_kelompok"];
  $kode_perusahaan=$sql_pasien->fields["kode_perusahaan"];
  $kode_agama = $sql_pasien->fields["kode_agama"];
  if (trim($kode_agama)!=""){
	$agama = baca_tabel("dc_agama","agama","WHERE id_dc_agama=$kode_agama");
  }
  $nama_dokter=baca_tabel("mt_dokter_v","nama_pegawai","where kode_dokter='$dokter'");
  $nama_bagian=baca_tabel("mt_bagian","nama_bagian","where kode_bagian='$bagian'");

	if($no_kunjungan==""){
		$no_antrian=0;
	}
	$no_antrian=baca_tabel("pl_tc_poli","no_antrian","WHERE no_kunjungan=$no_kunjungan");
	if($kode_kelompok!=2){
		$nama_kelompok=baca_tabel("mt_nasabah","nama_kelompok","where kode_kelompok=$kode_kelompok");
		$nasabah =  $nama_kelompok;
	}else{
		$nama_company=baca_tabel("mt_perusahaan","nama_perusahaan","where kode_perusahaan=$kode_perusahaan");
		$nasabah =  $nama_company;
	}
	$nama_hari=array("Minggu","Senin","Selasa","Rabu","Kamis","Jum'at","Sabtu")
?>
<html>
<head>
<title>Cetak Tracer</title>
<? include("../_inc/tpl_incHtmlHead.php"); ?>
	<link rel="stylesheet" href="/_css/print.css" type="text/css" media="print">
	<style type="text/css" media="screen">
		#headNamaPerusahaan {
			width:100%;
			text-align:center;
			font:bolder 18px arial;
			padding:5px
		}
		#headAlamat {
			width:100%;
			text-align:center;
			font:10px arial
		}
		#headTracer {
			width:100%;
			text-align:center;
			font:bolder 20px arial;
			letter-spacing:5px;
			padding-top:5px
		}
		#content {
			width:90%;
			padding:3px
		}
		.fieldname {
			font:12px verdana
		}
		.isiname {
			font:12px verdana
		}
		.isinameBig {
			font:bolder 14px verdana
		}
		#boxAntrianKiri {
			border:2px double black;
			position:absolute;
			left:375px;
			top:120px;
			width:70px;
			height:50px;
			text-align:center;	
		}
		#boxAntrianKanan {
			border:2px double black;
			position:absolute;
			left:850px;
			top:120px;
			width:70px;
			height:50px;
			text-align:center;	
		}
		#boxAntrianKiri #headAntrian, #boxAntrianKanan #headAntrian{
			background:black;
			color:white;
			width:100%;
			font:bold 11px verdana;
			height:15px;
			padding:2px
		}
		#boxAntrianKiri #isiAntrian, #boxAntrianKanan #isiAntrian{
			font:bold 24px verdana;
			padding:5px 5px 5px 5px
		}
	</style>
	<style type="text/css" media="print">
		#headNamaPerusahaan {
			width:100%;
			text-align:center;
			font:bolder 18px arial;
			padding:5px
		}
		#headAlamat {
			width:100%;
			text-align:center;
			font:10px arial
		}
		#headTracer {
			width:100%;
			text-align:center;
			font:bolder 20px arial;
			letter-spacing:5px;
			padding-top:5px
		}
		#content {
			width:90%;
			padding:3px
		}
		.fieldname {
			font:12px verdana
		}
		.isiname {
			font:12px verdana
		}
		.isinameBig {
			font:bolder 14px verdana
		}
		#boxAntrianKiri {
			border:2px double black;
			position:absolute;
			left:260px;
			top:100px;
			width:70px;
			height:50px;
			text-align:center;	
		}
		#boxAntrianKanan {
			border:2px double black;
			position:absolute;
			left:625px;
			top:100px;
			width:70px;
			height:50px;
			text-align:center;	
		}
		#boxAntrianKiri #headAntrian, #boxAntrianKanan #headAntrian{
			background:black;
			color:white;
			width:100%;
			font:bold 11px verdana;
			height:15px;
			padding:2px
		}
		#boxAntrianKiri #isiAntrian, #boxAntrianKanan #isiAntrian{
			font:bold 24px verdana;
			padding:5px 5px 5px 5px
		}
	</style>
</head>

<body>
<div id="topLayer" class="loading"></div>
<!-- ========================================================================================= -->
	<div id="isiAtas">
		<div id="barPrint">
			<span class="judul"><b>CETAK TRACER</b></span>
			<button class="submit01" onclick="window.close()">Tutup</button>
			<button class="submit01" onclick="print()">Cetak</button>
		</div>

	</div>
	<!-- ========================================================================================= -->

	<!-- ========================================================================================= -->

	<table cellspacing="0" cellpadding="0" width="100%">
		<tr>
			<td style="border-right:1px dashed black;float:left;vertical-align:top">
				<?include('cetak_tracer_print_kiri.php');?>
			</td>
			<td style="float:left;vertical-align:top">
				<?include('cetak_tracer_print_kanan.php');?>
			</td>
		</tr>
	</table>
	<? if (substr($bagian,0,2)=="01"){?>
	<div id="boxAntrianKiri">
		<div id="headAntrian">Antrian</div>
		<div id="isiAntrian">
			<?=$no_antrian?>
		</div>
	</div>
	<div id="boxAntrianKanan">
		<div id="headAntrian">Antrian</div>
		<div id="isiAntrian">
			<?=$no_antrian?>
		</div>
	</div>
	<?}?>
<!-- ############################################################################################# -->
<script language="JavaScript" type="text/javascript">

window.onload = function()
{
	initHalaman()
}

</script>
</body>

</html>
