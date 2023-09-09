<?php

include "cek-token.php";

//act, src_obat, src_racikan, id_kesediaan_obat
//act = get_jenis_obat, get_nama_obat, get_racikan, get_aturan_pakai

$kode_bagian_far=AV_FARMASI;
switch($act) {
    case "get_jenis_obat":
        $jenis_obat = &$db->Execute("SELECT * from dc_kesediaan_obat where nama_kesediaan<>'ALKES' order by nama_kesediaan");
        while($dt=$jenis_obat->fetchRow()){
            $jns_obat[] = $dt;
        }
        if(is_array($jns_obat)) {
            $data['code']=200;
            $data['jenis_obat']=$jns_obat;
        }else {
            $data['code']=500;
            $data['msg']="Tidak ada data ditemukan"; 
        }
    break; 

    case "get_nama_obat":
        if($src_obat != "") {
            $sql_plus = "AND a.nama_brg LIKE '%".$src_obat."%'";
        }
        $getobat = &$db->Execute("SELECT a.kode_brg,a.nama_brg,b.jml_sat_kcl FROM mt_barang a JOIN mt_depo_stok b ON a.kode_brg = b.kode_brg where b.kode_bagian = $kode_bagian_far AND b.jml_sat_kcl > 0 $sql_plus");
        while($dt=$getobat->fetchRow()){
            $list_obat[] = $dt; 
        }
        if(is_array($list_obat)) {
            $data['code'] = 200;
            $data['list_obat'] = $list_obat;
        }else {
            $data['code'] = 500;
            $data['msg']="Tidak ada data ditemukan"; 
        }
    break;

    case "get_racikan":
        if($src_racikan == "") {
            $sql_plus = "";
        }else{
            $sql_plus = "WHERE nama_racikan LIKE '%".$src_racikan."%'";
        }
        $getRacikan = &$db->Execute("SELECT id_mt_racikan,nama_racikan FROM mt_racikan $sql_plus");
        while($dt=$getRacikan->fetchRow()){
            $id_racikan = $dt['id_mt_racikan'];
            $getDetail = $db->Execute("SELECT kode_brg,jumlah FROM mt_racikan_detail where id_mt_racikan = $id_racikan");
            while($dtl=$getDetail->fetchRow()){
                $kode_brg	=$dtl['kode_brg'];
                $jumlah		=$dtl['jumlah'];
                
                $jml_brg = baca_tabel("mt_barang as a JOIN mt_depo_stok as b ON b.kode_brg = a.kode_brg", "b.jml_sat_kcl", "where b.kode_bagian =$kode_bagian_far AND b.jml_sat_kcl > 0 and b.kode_brg='$kode_brg'");
                
                if($jumlah > $jml_brg){
                    $racikan['id_racikan']    = $id_racikan;
                    $racikan['nama_racikan']  = $dt['nama_racikan'];
                    $racikan['kode_obat']     = $kode_brg;
                    $racikan['jumlah_obat']   = $jumlah;
                    $racikan1[] = $racikan; 
                }
            }
        }

        if(is_array($racikan1)) {
            $data['code'] = 200;
            $data['list_racikan'] = $racikan1;
        }else{
            $data['code'] = 500;
            $data['msg']="Tidak ada data ditemukan"; 
        }
    break;

    case "get_aturan_pakai":
        // $aturan="$satu x $dua";
        // if ($id_kesediaan_obat != "") {
        //     $satuan = baca_tabel("dc_kesediaan_obat_det", "nama_kesediaan_obat_det", "where id_dc_kesediaan_obat=" . $id_kesediaan_obat);
        //     $sql_kelompok = "SELECT * FROM mt_layanan_obat ORDER BY nama_layanan";
            // if($satu!=""){
            //     $cek_kesediaan=baca_tabel('dd_dosis','id_dd_dosis',"where nama_dosis like '$aturan' and id_dc_kesediaan_obat=" . $id_kesediaan_obat);
            //     if($cek_kesediaan==""){
            //         $result = true;
            //         $db->BeginTrans();
                    
            //         unset($insertDdDosis);
            //         $insertDdDosis["nama_dosis"] = $aturan;
            //         $insertDdDosis["id_dc_kesediaan_obat"] = $id_kesediaan_obat;
            //         $result = insert_tabel("dd_dosis", $insertDdDosis);

            //         $db->CommitTrans($result !== false);
            //     }     
            // }

        $getdosis =&$db->Execute("SELECT id_dd_dosis as kode, nama_dosis as nama FROM dd_dosis WHERE id_dc_kesediaan_obat=$id_kesediaan_obat");
        // if($satu==""){
            while($dt=$getdosis->fetchRow()){
                $dosis[] = $dt;
            }
            if ($id_kesediaan_obat){
                if(is_array($dosis)) {
                    $data['code'] = 200;
                    $data['list'] = $dosis;
                }else{
                    $data['code'] = 500;
                    $data['msg']="Tidak ada data ditemukan"; 
                }
            }else{
                $data['code'] = 500;
                $data['msg']="ID Kesediaan Obat tidak ditemukan"; 
            }
    break;

}

echo json_encode($data);