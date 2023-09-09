<?php 
include "cek-token.php";

// $input = json_decode(file_get_contents('php://input'),TRUE);
// foreach($input as $key=>$val){
// 	$$key=$val;
// }

if($tgl==""){
    $tgl_mr = "";

}else{
    $year	=date("Y",strtotime($tgl));
    $month	=date("m",strtotime($tgl));
    $day	=date("d",strtotime($tgl));
    $tgl_mr = "AND YEAR(a.tgl_masuk)='$year' AND MONTH(a.tgl_masuk)='$month' AND DAY(a.tgl_masuk)='$day'";

}

$nom = 1;
$get_px = "select no_mr,no_ktp,nama_pasien, jen_kelamin, gol_darah, tgl_lhr from mt_master_pasien where no_ktp='$ktp'";
$dt_px = $db->Execute($get_px);
$nomr = $dt_px->Fields('no_mr');

$qry_mr = "SELECT a.no_registrasi,a.no_kunjungan,a.no_mr,a.tgl_masuk,a.kode_dokter,
    kode_bagian_tujuan,kode_bagian_asal,nama_pegawai,
    c.nama_bagian,d.nama_bagian AS nama_bagian_asal
    FROM tc_kunjungan AS a
    LEFT OUTER JOIN mt_karyawan AS b ON a.kode_dokter=b.kode_dokter
    LEFT JOIN mt_bagian AS c ON a.kode_bagian_tujuan=c.kode_bagian
    LEFT JOIN mt_bagian AS d ON a.kode_bagian_asal=d.kode_bagian
    WHERE a.no_mr='$nomr' $tgl_mr AND c.group_bag NOT IN('Group')  AND d.group_bag NOT IN('Group') AND kode_bagian_tujuan=kode_bagian_asal
    GROUP BY a.no_registrasi,a.no_kunjungan,a.no_mr,a.tgl_masuk,a.kode_dokter,kode_bagian_tujuan,kode_bagian_asal,nama_pegawai,c.nama_bagian,d.nama_bagian
    ORDER BY a.tgl_masuk DESC";
$dt_mr = $db->Execute($qry_mr);
$no_reg = $dt_mr->Fields('no_registrasi');

    while($px=$dt_px->fetchRow()){

        if($px['tgl_lhr']==""){
            $umur_px = "0 Tahun";
        }else{
            $umur_px = umur($px['tgl_lhr'])." Tahun";
        }

        if($px['jen_kelamin']=="L"){
            $gender = "Laki-laki";
        }else if($px['jen_kelamin']=="P"){
            $gender = "Perempuan";
        }else{
            $gender = "Unknow";
        }

        $dpx['nama_px']    = $px['nama_pasien'];
        $dpx['nomr_px']    = $nomr;
        $dpx['ktp_px']     = $px['no_ktp'];
        $dpx['gender']     = $gender; 
        $dpx['gol_darah']  = $px['gol_darah'];
        $dpx['umur']       = $umur_px;

        $data['px'][] = $dpx;
            
    }
    if($no_reg==""){
        $data['code']=500;
        $data['msg']="Tidak ada data";
    }else{
        while($hsl=$dt_mr->fetchRow()){

            $tgl_masuk				= $hsl["tgl_masuk"];
            $nama_pegawai			= $hsl["nama_pegawai"];
            $fungsi_dokter			= $hsl["fungsi_dokter"];
            $no_registrasi			= $hsl["no_registrasi"];
            $no_kunjungan			= $hsl["no_kunjungan"];
            $tgl_input				= $hsl["tgl_input"];
            $kode_bagian_asal		= $hsl["kode_bagian_asal"];
            $kode_bagian_tujuan		= $hsl["kode_bagian_tujuan"];
            $tgl_input_masuk		= $hsl["tgl_masuk"];
            
            $nama_bagian_asal		=baca_tabel("mt_bagian","nama_bagian","WHERE kode_bagian='".$kode_bagian_asal."'");
            $kode_bag_tujuan		=baca_tabel("mt_bagian","nama_bagian","WHERE kode_bagian='".$kode_bagian_tujuan."'");
            $tgl_input				=baca_tabel("gd_th_rujuk_ri","tgl_input","WHERE no_registrasi='".$no_registrasi."'");
            
            
            if($tgl_input!="" ){
                $tgl_input=$tgl_input;
                $tgl_masuk = $tgl_input;
            }else{
                if($kode_bag_tujuan <>AV_LABORATORIUM || $kode_bag_tujuan<>AV_RADIOLOGI){
                    $tgl_input=$tgl_input_masuk;
                    $tgl_masuk = $tgl_input_masuk;
                }else{
                    // Belum VItal Sign
                    $tgl_masuk = "2";
                }
                
            }


            $mr['wkt_periksa']   = date("H:i", strtotime($hsl['tgl_masuk']));
            $mr['stat_regist']   = 1;
            $mr['no_urut']       = $nom++;
            $mr['no_mr']         = $hsl['no_mr'];
            $mr['idReg']         = $hsl['no_registrasi'];
            $mr['no_kunjungan']  = $hsl['no_kunjungan'];
            $mr['kode_bag_asal'] = $hsl['kode_bagian_asal'];
            $mr['tgl_periksa']   = $hsl['tgl_masuk'];
            $mr['nama_bagian']   = $hsl['nama_bagian'];
            $mr['nama_dokter']   = $hsl['nama_pegawai'];
            $mr['url_rs']        = $url_rs;

            $data['res'][] = $mr;

        }

        if(is_array($data['res'])) {
            $data['code']=200;
        }else {
            $data['code']=500;
            $data['msg']="Tidak ada data ditemukan";
        }
    }

echo json_encode($data);
?>