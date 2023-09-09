<?php

include "cek-token.php";

//tanggal, kode_dokter

$arrtgl 	= explode('-', $tanggal);
$tahun 		= $arrtgl[0];
$bulan 		= $arrtgl[1];
$tanggal 	= $arrtgl[2];

$kondisi = "AND YEAR(tgl_jam_poli)='$tahun' AND MONTH(tgl_jam_poli)='$bulan' AND DAY(tgl_jam_poli)='$tanggal'";

if($kode_dokter!="") {
    $kondisi= $kondisi . "AND tc_registrasi.kode_dokter='$kode_dokter'";
}

$sql="SELECT
tc_registrasi.no_mr,
tc_registrasi.flag_bayar,
mt_bagian.nama_bagian,
tc_registrasi.flag_layanan,
tc_registrasi.nomor_antrian,
tc_registrasi.no_registrasi,
tc_registrasi.kode_bagian_masuk,
tc_kunjungan.no_kunjungan,
tc_kunjungan.status_keluar,
tc_kunjungan.kode_bagian_asal,
tc_kunjungan.kode_bagian_tujuan as kode_bagian,
pl_tc_poli.tgl_jam_poli,
pl_tc_poli.kode_dokter,
pl_tc_poli.no_antrian,
pl_tc_poli.id_pl_tc_poli,
pl_tc_poli.kode_poli,
pl_tc_poli.kode_bagian as kode_bagian_poli,
mt_master_pasien.nama_pasien,
mt_master_pasien.jen_kelamin,
mt_master_pasien.almt_ttp_pasien,
mt_master_pasien.url_foto_pasien,
mt_master_pasien.gol_darah,
mt_master_pasien.tgl_lhr,
mt_master_pasien.alergi,
mt_master_pasien.no_hp
FROM
mt_bagian
INNER JOIN pl_tc_poli ON mt_bagian.kode_bagian = pl_tc_poli.kode_bagian
INNER JOIN tc_kunjungan ON pl_tc_poli.no_kunjungan = tc_kunjungan.no_kunjungan
INNER JOIN tc_registrasi ON tc_kunjungan.no_registrasi = tc_registrasi.no_registrasi
INNER JOIN mt_master_pasien ON tc_registrasi.no_mr = mt_master_pasien.no_mr
WHERE tc_kunjungan.status_keluar is null and tc_kunjungan.status_batal is null $kondisi";

$no = 1;
$RunGetAntrianPasien=$db->Execute($sql);
while($TplGetAntrianPasien=$RunGetAntrianPasien->fetchRow()) {
    $TplGetAntrianPasien['no'] = $no++;
    $TplGetAntrianPasien['nama_dokter']=baca_tabel('mt_karyawan', 'nama_pegawai', "where kode_dokter=$kode_dokter");
    $no_mr = $TplGetAntrianPasien['no_mr'];
    $TplGetAntrianPasien['foto_pasien']=baca_tabel("mt_master_pasien_img", "foto_pasien", " where no_mr='$no_mr'");
    $no_registrasi = $TplGetAntrianPasien['no_registrasi'];
    $cek_pelayanan=baca_tabel("tc_trans_pelayanan", "kode_trans_pelayanan", " where kode_dokter1=$kode_dokter and no_registrasi=" . $no_registrasi);
    $no_kunjungan = $TplGetAntrianPasien['no_kunjungan'];
    if($cek_pelayanan <1) {
        $cek_pelayanan=baca_tabel("tc_status_pasien", "id_tc_status_pasien", " where no_kunjungan=" . $no_kunjungan);
        if($cek_pelayanan <1) {
            $cek_pelayanan=baca_tabel("tc_soap", "id_tc_soap", " where no_kunjungan=".$no_kunjungan);
        }
    }
    $TplGetAntrianPasien['cek_pelayanan'] = $cek_pelayanan;
    $kode_bagian_poli = $TplGetAntrianPasien['kode_bagian_poli'];
    $TplGetAntrianPasien['klinik']=baca_tabel("mt_bagian", "nama_bagian", "where kode_bagian=" .$kode_bagian_poli);
    $kode_bagian_asal = $TplGetAntrianPasien['kode_bagian_asal'];
    $kode_bagian_poli = $TplGetAntrianPasien['kode_bagian_poli'];
    if ($kode_bagian_asal == $kode_bagian_poli) {
        $TplGetAntrianPasien['bagian_asal']="Registrasi";
    } else {
        $TplGetAntrianPasien['bagian_asal']=baca_tabel("mt_bagian", "nama_bagian", "where kode_bagian=" . $kode_bagian_asal);
    }
    $antrian['no_mr'] = $TplGetAntrianPasien['no_mr'];
    $antrian['no_registrasi'] = $no_registrasi;
    $antrian['no_kunjungan'] = $no_kunjungan;
    $antrian['no_antrian'] = $TplGetAntrianPasien['no_antrian'];
    $antrian['kode_dokter'] = $kode_dokter;
    $antrian['nama_dokter'] = $TplGetAntrianPasien['nama_dokter'];
    $antrian['kode_bagian'] = $TplGetAntrianPasien['kode_bagian'];
    $antrian['alamat'] = $TplGetAntrianPasien['almt_ttp_pasien'];
    if($TplGetAntrianPasien['url_foto_pasien']) {
        $antrian['foto_pasien'] = $url . $TplGetAntrianPasien['url_foto_pasien'];
    } else {
        $antrian['foto_pasien'] = null;
    }
    $antrian['kode_bagian'] = $TplGetAntrianPasien['kode_bagian'];
    $antrian['nama_pasien'] = $TplGetAntrianPasien['nama_pasien'];
    $antrian['jenis_kelamin'] = $TplGetAntrianPasien['jen_kelamin'];
    $antrian['tgl_jam_poli'] = $TplGetAntrianPasien['tgl_jam_poli'];
    $antrian['gol_darah'] = $TplGetAntrianPasien['gol_darah'];
    $antrian['alergi'] = $TplGetAntrianPasien['alergi'];
    $antrian['no_hp'] = $TplGetAntrianPasien['no_hp'];
    $antrian['umur'] = umur($TplGetAntrianPasien['tgl_lhr']);
    $data[] = $antrian;
}

if(is_array($data)) {
    $datax['code']=200;
    $datax['msg']='Antrian Pasien Ditemukan';
    $datax['antrian']=$data;
} else {
    $datax['code']=500;
    $datax['msg']="Tidak Ada Antrian";
}
echo json_encode($datax);
?>