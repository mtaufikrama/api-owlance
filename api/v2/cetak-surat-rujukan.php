<?
	// require_once("../_lib/function/db.php");
	include 'cek-token.php';
	include "../../_lib/function/function.datetime.php";
	// include "../../_lib/function/function.olah_tabel.php";
	// include "../../_lib/function/function.variabel.php";
	// include "../../_lib/function/function.uang.php";
	// $db->debug=true;

	//no_registrasi

	$no_kunjungan = baca_tabel('tc_kunjungan','no_kunjungan',"where no_registrasi='$no_registrasi'");

	$sqlKunjungan=read_tabel("tc_kunjungan as a join mt_master_pasien as b on a.no_mr=b.no_mr join pl_tc_poli as c on a.no_kunjungan=c.no_kunjungan","b.nama_pasien,jen_kelamin,b.no_mr,b.tgl_lhr,pekerjaan,almt_ttp_pasien,jen_kelamin,nomor_sakit,lama_sakit,tgl_jam_poli,c.kode_dokter,pemeriksaan_penunjang,diagnosa_penunjang,kepada_penunjang"," where c.no_kunjungan=$no_kunjungan");
	
	$nama_pasien			=$sqlKunjungan->fields("nama_pasien");
	$jen_kelamin			=$sqlKunjungan->fields("jen_kelamin");
	$no_lab					=$sqlKunjungan->fields("no_lab");
	$tgl_lhr				=$sqlKunjungan->fields("tgl_lhr");
	$almt_ttp_pasien		=$sqlKunjungan->fields("almt_ttp_pasien");
	$tlp_almt_ttp			=$sqlKunjungan->fields("tlp_almt_ttp");
	$no_hp					=$sqlKunjungan->fields("no_telpon");
	$kode_kelompok			=$sqlKunjungan->fields("kode_kelompok");
	$kode_perusahaan		=$sqlKunjungan->fields("kode_perusahaan");
	$no_surat				=$sqlKunjungan->fields("no_surat");
	$tgl_input				=$sqlKunjungan->fields("tgl_input");
	$nik					=$sqlKunjungan->fields("nik");
	$instansi				=$sqlKunjungan->fields("instansi");
	$hasil					=$sqlKunjungan->fields("hasil");
	$kode_dokter			=$sqlKunjungan->fields("kode_dokter");
	$umur					=$sqlKunjungan->fields("umur");
	$no_passport			=$sqlKunjungan->fields("no_passport");
	$tgl_jam_poli			=$sqlKunjungan->fields("tgl_jam_poli");
	$tgl_pengambilan_sample	=$sqlKunjungan->fields("tgl_pengambilan_sample");
	$tgl_pelaporan			=$sqlKunjungan->fields("tgl_pelaporan");
	$warganegara			=$sqlKunjungan->fields("warganegara");
	$pemeriksaan			=$sqlKunjungan->fields("pemeriksaan");
	$hasil					=$sqlKunjungan->fields("hasil");
	$pekerjaan				=$sqlKunjungan->fields("pekerjaan");
	$pemeriksaan_penunjang	=$sqlKunjungan->fields("pemeriksaan_penunjang");
	$diagnosa_penunjang		=$sqlKunjungan->fields("diagnosa_penunjang");
	$kepada_penunjang		=$sqlKunjungan->fields("kepada_penunjang");
	$tglTtd					=date("d-m-Y",strtotime($tgl_jam_poli));
	
	if($jen_kelamin=="L"){
		$jen_kelamin="Laki -Laki";
	}else{
		$jen_kelamin="Perempuan";
	}
	if($kode_dokter!=""){
		$nama_pegawai=baca_tabel("mt_karyawan","nama_pegawai"," where kode_dokter=$kode_dokter");
		$sip=baca_tabel("mt_dokter_detail","no_izin_praktek"," where kode_dokter=$kode_dokter");
	}
	
		/******************************************************************************************/
		$r=read_tabel("dd_konfigurasi","*");
		while ($konf=$r->FetchRow()) {
			$nama_perusahaan	=$konf["nama_perusahaan"];
			$nama_aplikasi		=$konf["nama_aplikasi"];
			$alamat				=$konf["alamat"];
			$kota				=$konf["kota"];
			$kode_pos			=$konf["kode_pos"];
			$telpon				=$konf["telpon"];
			$fax				=$konf["fax"];
			$logo_small			=$konf["logo_small"];
			$html_title			=$konf["html_title"];
			$id_dd_paket		=$konf["id_dd_paket"];
		}
		/******************************************************************************************/
		$icd_10=baca_tabel("th_riwayat_pasien","icd_10"," where no_kunjungan=$no_kunjungan");
		if($icd_10!=""){
			$diagnosa_akhir=baca_tabel("mt_master_icd10","nama_icd"," where icd_10='".$icd_10."'");
		}
		/******************************************************************************************/
	
		$logo_small = '../'. $logo_small;
$content ="
<html>
<title>Surat Keterangan</title>
<head>
<style>
	body{
		
		font-family: Times;
		font-size: 12pt;
		line-height:16px;
	}
	td{
		font-family: Times;
		font-size: 12pt;
		line-height:16px;
	}
</style>
</head>
<body style='font-family: Times;'>

<table style='width:750px;' border='0'>
	<tr>
		<td rowspan='4' style='padding-top:65px;'>
			<img src='$logo_small' width='50' height='50'>
		</td>
	</tr>
	<tr>
		<td>".$nama_perusahaan."</td>
	</tr>
	<tr>
		<td>".nl2br($alamat)."</td>
	</tr>
	<tr>
		<td>".$telpon."</td>
	</tr>
		
</table>
<hr>
<div style='text-align:center;font-weight:bold;font-size:16pt;font-family: Times'><u>SURAT RUJUKAN PEMERIKSAAN PENUNJANG MEDIS</u></div>
		<br>
		<br>
		<div style='font-family: Times;font-size:12pt;' >
		Kepada Yth,<br> 
		".$kepada_penunjang."<br> 
		Di,<br> 
		Tempat<br> <br><br>
		Dengan hormat,<br><br><br>
		Mohon dilakukan <b>".$pemeriksaan_penunjang."</b> terhadap Pasien berikut :
		<table>
		<tr>
			<td>NAMA</td>
			<td>:</td>
			<td>".$nama_pasien."</td>
		</tr>
		
		<tr>
			<td>UMUR </td>
			<td>:</td>
			<td>".UmurV2($tgl_lhr)."</td>
		</tr>
		<tr>
			<td>JENIS KELAMIN  </td>
			<td>:</td>
			<td>".$jen_kelamin."</td>
		</tr>
		<tr>
			<td>ALAMAT </td>
			<td>:</td>
			<td>".$almt_ttp_pasien."</td>
		</tr>
		<tr>
			<td>DIAGNOSA  </td>
			<td>:</td>
			<td>".$icd_10." ".$diagnosa_akhir."</td>
		</tr>
		<tr>
			<td>PEMBAYARAN </td>
			<td>:</td>
			<td> Langsung tagih ke pasien </td>
		</tr>
		</table>
		
		<br>
		<br>
		
			
		Demikian surat rujukan ini kami buat, atas perhatian dan kerja samanya kami ucapkan banyak terima kasih
		<br>
		<br>
		<br>
		
		<table border='0' >		
			<tr>
				
				<td style='width:300px;' valign='top'> <div style='text-align:center;font-family: Times' > Jakarta, ".$tglTtd."  <br>   <br><br><br><br><br><br><u>".$nama_pegawai."</u></div> </td>
			</tr>
		</table>
		</div>
		";		
		
		
$content .="
	</body>
</html>
";

require_once('../../_contrib/html2pdf/html2pdf.class.php');	
$html2pdf = new HTML2PDF('P','A5','fr');
$html2pdf->WriteHTML($content);
$html2pdf->Output('example.pdf');

?>