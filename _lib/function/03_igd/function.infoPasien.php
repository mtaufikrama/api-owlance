<?
require_once("../_lib/function/db.php");
loadlib("function","function.olah_tabel");
loadlib("function","function.max_kode_number");

function nama_keluar($no_mr,$no_registrasi,$no_kunjungan) {
$pasien_out = baca_tabel("mt_master_pasien","status_meninggal","where no_mr='$no_mr'");
//$status_out = baca_tabel("tc_trans_pelayanan","status_selesai","where no_mr='$no_mr' and no_registrasi=$no_registrasi and kode_bagian_asal='020101'");
$status_out = baca_tabel("tc_kunjungan","status_keluar","where no_mr='$no_mr' and no_registrasi=$no_registrasi and no_kunjungan=$no_kunjungan and kode_bagian_asal='020101'");
if ($pasien_out=="1"){
	$hasil = "Meninggal";
} else {
	if ($status_out=="1"){
		$hasil = "Dirujuk Ke Rawat Inap";
	} else {
		$hasil = "Pulang";
	}
}
return $hasil;
}

function status_keluar($no_mr,$no_registrasi) {
global $loginInfo;
$pasien_out = baca_tabel("mt_master_pasien","status_meninggal","where no_mr='$no_mr'");

$kode_bagian=$loginInfo["kode_bagian"];
if (trim($kode_bagian)==""){
	$kode_bagian="020101";
}//$db->debug=true;
$status_out = baca_tabel("tc_trans_pelayanan","status_selesai","where no_mr='$no_mr' and no_registrasi=$no_registrasi and kode_bagian_asal='$kode_bagian' and kode_bagian='$kode_bagian'");//$db->debug=false;
if ($pasien_out==1){
	$hasil = 0;
} else {
	switch ($status_out){
		case 0 : $hasil = 1;
			break;
		case 1 : $hasil = 2;
			break;
		case 2 : $hasil = 3;
			break;
		case 3 : $hasil = 4;
			break;
		default : $hasil=1;	
	}
}
return $hasil;
}

function nama_dokter($kode_dokter) {
$hasil = baca_tabel("mt_dokter_v","nama_pegawai","where kode_dokter=$kode_dokter");
return $hasil;
}
?>