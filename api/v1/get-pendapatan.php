<?php

include "cek-token.php";

//kode_dokter

$no_induk = baca_tabel('mt_karyawan','no_induk',"where kode_dokter=$kode_dokter");
$id_dd_user = baca_tabel('dd_user','id_dd_user',"where no_induk='$no_induk'");

$sql = "SELECT DISTINCT a.no_registrasi, a.no_mr, a.nama_pasien, a.tgl_jam, a.seri_kuitansi, a.no_kuitansi, a.bill 
FROM tc_trans_kasir a JOIN tc_registrasi b on a.no_registrasi=b.no_registrasi 
where id_dd_user=$id_dd_user ORDER BY a.tgl_jam DESC";

$run=$db->Execute($sql);

while($get=$run->fetchRow()){
	$pendapatan[]=$get;
}

if (is_array($pendapatan)){
    $data['code'] = 200;
    $data['pendapatan'] = $pendapatan;
} else {
    $data['code'] = 500;
    $data['msg'] = 'Tidak ada data ditemukan';
}

?>