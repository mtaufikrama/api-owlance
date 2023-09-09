<?php 
include "cek-token.php";

//no_mr, kode_dokter

if($kode_dokter != '' || $kode_dokter != null) {
    $kondisi = "and a.kode_dokter='$kode_dokter'";
}

$sql = "SELECT a.no_registrasi,a.no_kunjungan,a.no_mr,a.tgl_masuk as tgl_pemeriksaan,a.kode_dokter,kode_bagian_asal,nama_pegawai,
c.nama_bagian
from tc_kunjungan as a  left outer join
mt_karyawan as b on a.kode_dokter=b.kode_dokter
left join mt_bagian as c on a.kode_bagian_tujuan=c.kode_bagian
left join mt_bagian as d on a.kode_bagian_asal=d.kode_bagian 
left join th_icd10_pasien as e on a.no_registrasi=e.no_registrasi and a.kode_bagian_tujuan=e.kode_bagian left join mt_master_icd10 as f on e.kode_icd=f.icd_10  
where a.no_mr='$no_mr' and c.group_bag not in('Group')  and d.group_bag not in('Group') AND  kode_bagian_tujuan = kode_bagian_asal $kondisi
group by a.no_registrasi,a.no_kunjungan,a.no_mr,a.tgl_masuk,a.kode_dokter,kode_bagian_tujuan,kode_bagian_asal,nama_pegawai,c.nama_bagian,d.nama_bagian order by no_kunjungan desc";

$run = $db->Execute($sql);

while($get=$run->fetchRow()){

    $datax[] = $get;

}

if(is_array($datax)) {
    $data['code']=200;
    $data['msg']='Medical Record Ditemukan';
    $data['list_mr']=$datax;
} else {
    $data['code']=500;
    $data['msg']="Tidak ada data ditemukan";
}

echo json_encode($data);
?>