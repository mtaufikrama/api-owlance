<?php

include "cek-token.php";
include "../../_lib/function/function.datetime.php";

// no_mr, url

$sql="SELECT no_mr, nama_pasien, almt_ttp_pasien as alamat, gol_darah, alergi, jen_kelamin, tlp_almt_ttp as telp, url_foto_pasien, nama_kelompok, tgl_lhr from mt_master_pasien as a
left join mt_nasabah as b on a.kode_kelompok = b.kode_kelompok
left join mt_perusahaan as c on a.kode_perusahaan = c.kode_perusahaan
where a.no_mr='$no_mr'";

$getPasienlama=$db->Execute($sql);

while($datapasien=$getPasienlama->fetchRow()) {

    $datapasien['umur'] = Umur($datapasien['tgl_lhr']);
    if ($datapasien['url_foto_pasien']) {
        $datapasien['url_foto_pasien'] = $url . $datapasien['url_foto_pasien'];
    } else {
        $datapasien['url_foto_pasien'] = null;
    }
    $pasien=$datapasien;
}

if($pasien) {
    $data['code']=200;
    $data['msg']='Data Pasien Ditemukan';
    $data['pasien']=$pasien;
} else {
    $data['code']=500;
    $data['msg']="Tidak ada data ditemukan";
}
echo json_encode($data);
