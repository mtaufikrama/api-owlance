<?
// ================================================== mencari Pasien Masuk ===============================================
function pasien_masuk($sql_plus_1,$txt_tgl,$txt_bulan,$txt_tahun){
	
	global $db;

	$masuk = " SELECT a.no_kunjungan,a.dr_merawat, a.tgl_masuk, a.kelas_pas, a.kode_ruangan, 	c.kode_kelompok, c.no_mr, c.nama_pasien, c.jen_kelamin FROM  ri_tc_rawatinap a, mt_master_pasien c,tc_kunjungan d WHERE $sql_plus_1 a.no_kunjungan=d.no_kunjungan and  d.no_mr=c.no_mr and day(a.tgl_masuk)='$txt_tgl' and month(a.tgl_masuk)='$txt_bulan' and year(a.tgl_masuk)='$txt_tahun' and a.bag_pas='$kode_bagian' ORDER BY c.nama_pasien";

	$_masuk = & $db->Execute($masuk);



}
?>