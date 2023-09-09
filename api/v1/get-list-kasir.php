<?php

include "cek-token.php";
include "../../_lib/function/biaya_kartu.php";

//kode_dokter

$sql = "SELECT a.*, b.nama_bagian, b.kode_bagian,b.nama_pasien_layan, b.kode_bagian_asal FROM 
			( SELECT no_registrasi, no_mr, nama_pasien, kode_kelompok, 
			SUM((CASE WHEN status_kredit = 1 THEN (-1) ELSE 1 END) * bill_rs) AS bill_rs, 
            SUM((CASE WHEN status_kredit = 1 THEN (-1) ELSE 1 END) * bill_dr1) AS bill_dr1, 
            SUM((CASE WHEN status_kredit = 1 THEN (-1) ELSE 1 END) * jasa_dr_asisten) AS jasa_dr_asisten, 
            SUM((CASE WHEN status_kredit = 1 THEN (-1) ELSE 1 END) * bill_dr2) AS bill_dr2, 
            SUM((CASE WHEN status_kredit = 1 THEN (-1) ELSE 1 END) * bill_dr3) AS bill_dr3, 
			SUM((CASE WHEN status_kredit = 1 THEN (-1) ELSE 1 END) * lain_lain) AS lain_lain, 
            MAX(kode_trans_pelayanan) AS kode_trans_pelayanan
			FROM ks_antrian_loket_v
			WHERE  kode_dokter1=$kode_dokter and kode_bagian not like'03%'
			GROUP BY no_registrasi, no_mr, nama_pasien,kode_kelompok ) a 
			LEFT JOIN ks_antrian_loket_v b
			ON a.kode_trans_pelayanan = b.kode_trans_pelayanan
			WHERE kode_dokter1=$kode_dokter and  ( a.bill_rs > 0 or a.bill_dr1 >0 ) and a.no_registrasi <> 0
			ORDER BY a.no_registrasi DESC";

$i = 1;
$rsPaging=$db->Execute($sql);
while ($dataSend=$rsPaging->FetchRow()) {
    $tampil["no"]=$i++;
    foreach($dataSend as $key=>$val) {
        $$key=$val;
    }

    if (trim($kode_kelompok)!="") {
        $nama_kelompok = baca_tabel("mt_nasabah", "nama_kelompok", "WHERE kode_kelompok=$kode_kelompok");
        if($kode_kelompok=='2') {
            $kode_perusahaan= baca_tabel("mt_master_pasien", "kode_perusahaan", "WHERE no_mr='$no_mr'");
            if($kode_perusahaan!="") {
                $nama_kelompok =baca_tabel("mt_perusahaan", "nama_perusahaan", "WHERE kode_perusahaan=$kode_perusahaan");
            }
        }
    } else {
        $nama_kelompok = "Pasien Luar";
    }
    $tampil["no_registrasi"]=$no_registrasi;
    $tampil["nama_pasien"]=$nama_pasien;
    $tampil["nama_kelompok"]=$nama_kelompok;
    $billing = $bill_rs + $bill_dr1 + $bill_dr2 + $bill_dr3 + $lain_lain+$jasa_dr_asisten;
    $biayaKartu=biaya_kartu($no_registrasi);
    if ($biayaKartu>0) {
        $billing += $biayaKartu;
    }

    if($kode_bagian_asal!="") {
        $nama_bagian= baca_tabel("mt_bagian", "nama_bagian", "WHERE kode_bagian='$kode_bagian_asal'");
    }

    if ($billing=="0") {
        continue;
    }

    $sqlBilling="SELECT a.kode_bagian, b.nama_bagian, a.status_selesai, 
    SUM((CASE WHEN a.status_kredit = 1 THEN (-1) ELSE 1 END) * a.bill_rs) AS bill_rs, 
    SUM((CASE WHEN a.status_kredit = 1 THEN (-1) ELSE 1 END) * a.bill_dr1) AS bill_dr1, 
    SUM((CASE WHEN a.status_kredit = 1 THEN (-1) ELSE 1 END) * a.bill_dr2) AS bill_dr2, 
    SUM((CASE WHEN a.status_kredit = 1 THEN (-1) ELSE 1 END) * a.bill_dr3) AS bill_dr3, 
    SUM((CASE WHEN a.status_kredit = 1 THEN (-1) ELSE 1 END) * a.bill_rs_askes) AS bill_rs_askes, 
    SUM((CASE WHEN a.status_kredit = 1 THEN (-1) ELSE 1 END) * a.bill_dr1_askes) AS bill_dr1_askes, 
    SUM((CASE WHEN a.status_kredit = 1 THEN (-1) ELSE 1 END) * a.bill_dr2_askes) AS bill_dr2_askes, 
    SUM((CASE WHEN a.status_kredit = 1 THEN (-1) ELSE 1 END) * a.lain_lain) AS lain_lain 
    FROM ks_antrian_loket_v a LEFT JOIN mt_bagian b ON a.kode_bagian = b.kode_bagian 
    WHERE a.no_registrasi=$no_registrasi and (a.bill_rs > 0 OR  a.bill_dr1 > 0) 
    GROUP BY a.kode_bagian, b.nama_bagian";

    $runBilling=$db->Execute($sqlBilling);

    while($getBilling=$runBilling->fetchRow()) {
        $getBilling['total']=$getBilling['bill_rs'] + $getBilling['bill_dr1'] + 
        $getBilling['bill_dr2'] + $getBilling['bill_dr3'] + $getBilling['bill_rs_askes'] + 
        $getBilling['bill_dr1_askes'] + $getBilling['bill_dr2_askes'] + $getBilling['lain_lain'];
        $tampil["harga"][]=$getBilling;
    }

    $billing = uang($billing, true);
    $potongKobag=substr($kode_bagian_asal, 0, 2);
    $jam_masuk=baca_tabel('tc_registrasi', 'tgl_jam_masuk', " where no_registrasi='$no_registrasi'");
    $jam_keluar=baca_tabel('tc_kunjungan', 'tgl_keluar', " where no_registrasi='$no_registrasi'");
    if($jam_keluar=="") {
        $jam_masuk_r	=date('d-m-Y H:i', strtotime($jam_masuk));
        $jam_keluar_r	=null;
    } else {
        $jam_masuk_r	=date('d-m-Y H:i', strtotime($jam_masuk));
        $jam_keluar_r	=date('d-m-Y H:i', strtotime($jam_keluar));
    }
    $tampil["jam_masuk"]=$jam_masuk_r;
    $tampil["jam_keluar"]=$jam_keluar_r;

    $tampil["nama_bagian"]=$nama_bagian;

    $tampil["billing"]=$billing;
    $data[]=$tampil;
}

if (is_array($data)) {
    $datax['code'] = 200;
    $datax['msg'] = 'Data ditemukan';
    $datax['kasir'] = $data;
} else {
    $datax['code'] = 500;
    $datax['msg'] = 'Data tidak ditemukan';
}

echo json_encode($datax);
