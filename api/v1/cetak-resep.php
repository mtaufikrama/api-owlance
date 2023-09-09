<?
	// require_once("../_lib/function/db.php");
	include 'cek-token.php';
	// $db->debug=true;

	//no_registrasi
	$kode_pesan_resep_dr=baca_tabel("fr_tc_pesan_resep_dr","kode_pesan_resep_dr"," where no_registrasi=$no_registrasi");
	$no_kunjungan=baca_tabel("tc_kunjungan","no_kunjungan"," where no_registrasi=$no_registrasi");

	$sql_utama = "SELECT * FROM fr_tc_pesan_resep_dr as a, mt_master_pasien as b  where a.no_mr=b.no_mr and kode_pesan_resep_dr=" . $kode_pesan_resep_dr . " order by a.kode_pesan_resep_dr";
	$hasil = $db->Execute($sql_utama);
	while ($row = $hasil->FetchRow()) {
		$tanggal_resep = $row['tgl_pesan'];
		$old_date_timestamp = strtotime($tanggal_resep);
		$tanggal = date('d-m-Y', $old_date_timestamp); 
		$kode_dokter = $row['kode_dokter'];
		$no_resep = $row['no_resep'];
		if ($kode_dokter != "") {
			$nama_dokter = baca_tabel("mt_karyawan", "nama_pegawai", "where kode_dokter='" . $kode_dokter . "'");
		}
		$no_mr = $row['no_mr'];
		$nama_pasien = $row['nama_pasien'];
		$tgl_lhr = $row['tgl_lhr'];
		$umur_a = umur($tgl_lhr);
		if (is_string($no_mr)) {
			$alamat = baca_tabel("mt_master_pasien", "almt_ttp_pasien", "where no_mr='" . $no_mr . "'");
		}
		$umur = UmurV2($tgl_lhr);
	}



$sql_obat = "SELECT * FROM fr_tc_far_dr WHERE kode_pesan_resep_dr=" . $kode_pesan_resep_dr;
$hasil_obat = $db->Execute($sql_obat);

$sql_detail_obat = "SELECT * FROM fr_tc_far_detail_dr WHERE kode_pesan_resep_dr=" . $kode_pesan_resep_dr;
$hasil_detail_obat = $db->Execute($sql_detail_obat);


$kode_bagian_asal=baca_tabel('tc_registrasi','kode_bagian_masuk',"where no_registrasi=$no_registrasi");
if ($kode_bagian_asal != "") {
    $nama_poli = baca_tabel("mt_bagian", "nama_bagian", "where kode_bagian=" . $kode_bagian_asal);
}
	
$content="

<page backleft='10mm' backright='10mm' backtop='25mm'>

<style >
   .left    { text-align: left;}
   .right   { text-align: right;}
   .center  { text-align: center;}
   .justify { text-align: justify;}
</style>

<table border='0' width='100%' border='0'>
<tr>
		<td style='font-size:30px;font-family:times;vertical-align: middle;text-align:center;'></td>
		<td style='font-size:30px;font-family:times;vertical-align: middle;text-align:center;width:250px'><b>Resep Dokter</b></td>
</tr>
</table><br>
<hr>
<br>
<table border='0'>
<tr>
		<td style='font-size:14px;font-family:times;text-align:left;'>Nama Dokter</td>
		<td style='font-size:14px;font-family:times;text-align:left;'>:</td>
		<td style='font-size:14px;font-family:times;text-align:left;'>$nama_dokter</td>
</tr>                         
<tr>                          
		<td style='font-size:14px;font-family:times;text-align:left;'>Tanggal Resep</td>
		<td style='font-size:14px;font-family:times;text-align:left;'>:</td>
		<td style='font-size:14px;font-family:times;text-align:left;'>$tanggal</td>
</tr>                         
<tr>                          
		<td style='font-size:14px;font-family:times;text-align:left;'>Nomer Resep Dokter</td>
		<td style='font-size:14px;font-family:times;text-align:left;'>:</td>
		<td style='font-size:14px;font-family:times;text-align:left;'>$no_resep</td>
</tr>                         
<tr>                          
		<td style='font-size:14px;font-family:times;text-align:left;'>Unit</td>
		<td style='font-size:14px;font-family:times;text-align:left;'>:</td>
		<td style='font-size:14px;font-family:times;text-align:left;'>$nama_poli</td>
</tr>
<tr >
	<td style='height: 50px;'></td>
</tr> 

</table>";


$content.="
<table>";
$sql_detail_obat = "SELECT * FROM fr_tc_far_detail_dr WHERE kode_pesan_resep_dr=" . $kode_pesan_resep_dr;
$hasil_detail_obat = $db->Execute($sql_detail_obat);
 while ($row_detail_obat = $hasil_detail_obat->FetchRow()) {
	$kode_brg = $row_detail_obat ['kode_brg'];
	$id_tc_far_racikan = $row_detail_obat ['id_tc_far_racikan'];
	if($id_tc_far_racikan > 0){
		$nama_obat = baca_tabel("tc_far_racikan", "nama_racikan", "where id_tc_far_racikan='" . $id_tc_far_racikan . "'");
	}else{
		$nama_obat = baca_tabel("mt_barang", "nama_brg", "where kode_brg='" . $kode_brg . "' and flag_aktif=1");
	}
	
	$vol = $row_detail_obat ['angka_romawi'];
	$jml_tebus = $row_detail_obat ['jumlah_tebus'];
	$nama_dosis = $row_detail_obat ['nama_dosis'];
	$flag_dosis = $row_detail_obat ['flag_dosis'];
	$id_dc_kesediaan_obat = $row_detail_obat ['id_dc_kesediaan_obat'];
	if ($id_dc_kesediaan_obat != "") {
		$nama_kesediaan_obat_det = baca_tabel("dc_kesediaan_obat_det", "nama_kesediaan_obat_det", " where id_dc_kesediaan_obat=" . $id_dc_kesediaan_obat);
	}

	$note = $row_detail_obat ['note'];
	if ($flag_dosis == 1) {
		$ket = "Sebelum Makan";
	} else if ($flag_dosis == 2) {
		$ket = "Sesudah Makan";
	} else if ($flag_dosis == 3) {
		$ket = "Saat Makan";
	} else if ($flag_dosis == 4) {
		$ket = "Tetes";
	} else if ($flag_dosis == 5) {
		$ket = "Oles";
	} else if ($flag_dosis == 6) {
		$ket = "Sprey";
	} else if ($flag_dosis == 7) {
		$ket = "UC";
	}
$content.="
<tr>                          
		<td><b><img src='../../_images/Icon_R1.png' ></b></td>
		<td>$nama_obat &nbsp;&nbsp;&nbsp; no $vol</td>
		<td>&nbsp; </td>
		<td colspan='3' > </td>
</tr> ";

$query_romawi="select * from dd_romawi";
$hasil_romawi=$db->Execute($query_romawi);
while($tampil_romawi=$hasil_romawi->fetchRow())
{
$id_dd_romawi=$tampil_romawi['id_dd_romawi'];
$angka_romawi=$tampil_romawi['angka_romawi'];
$arr_romawi[$id_dd_romawi]=$angka_romawi;
}
$content.="
<tr>
	<td>&nbsp;</td>
	<td>$nama_dosis $nama_kesediaan_obat_det &nbsp;&nbsp;&nbsp; $ket ( $note )</td>
	
</tr>
";

if($id_tc_far_racikan > 0){
	$SqlRacik="select b.nama_brg from tc_far_racikan_detail a join mt_barang b on a.kode_brg=b.kode_brg where id_tc_far_racikan='$id_tc_far_racikan';";
	$RunRacik=$db->Execute($SqlRacik);
	while($TplRacik=$RunRacik->fetchRow()){
		$nama_brgRacik=$TplRacik['nama_brg'];
	
			$content.="
			<tr>                          
					<td>&nbsp;</td>
					<td> - $nama_brgRacik &nbsp;&nbsp;&nbsp; </td>
					<td>&nbsp; </td>
					<td colspan='3' > </td>
			</tr> ";
			}
}
}
$content.="
</table>";


$content.="
<table>
<tr >
	<td style='height: 70px;'></td>
</tr>
<tr>                          
		<td style='font-size:14px;font-family:times;text-align:left;'>( Ttd Dokter )</td>
</tr>
<tr >
	<td style='height: 70px;'></td>
</tr> 
<tr>                          
		<td style='font-size:14px;font-family:times;text-align:left;'>$nama_dokter</td>
</tr>
</table>

</page>

";

require_once('../../_contrib/html2pdf/html2pdf.class.php');	
$html2pdf = new HTML2PDF('P','A5','fr');
$html2pdf->WriteHTML($content);
$html2pdf->Output('exemple.pdf');

?>