<?php

include "cek-token.php";

//act, src_icd

switch($act) {
    case "get_icd10":
        if($src_icd==""){
            $data['code']=500;
            $data['msg']="Silahkan input icd-10 dahulu";
        }else{
            $sql_plus="WHERE nama_icd LIKE '%".$src_icd."%' or icd_10 LIKE '%".$src_icd."%'";
            $nama_icd = $db->Execute("SELECT icd_10 as kode,nama_icd as nama FROM mt_master_icd10 $sql_plus ORDER BY icd_10 ");
            while($dt=$nama_icd->fetchRow()){
                $nama_icd10[] = $dt;
            }
    
        if(is_array($nama_icd10)) {
            $data['code']=200;
            $data['list']=$nama_icd10;
        }else {
            $data['code']=500;
            $data['msg']="Data ICD-10 ditemukan"; 
        }
    }
    break;

    case "get_asterix":
        $asterik_icd = $db->Execute("SELECT a.nama_icd as nama,b.kode_asterik_icd as kode 
        FROM mt_master_icd10 a INNER JOIN mt_master_icd10_asterik b ON a.icd_10=b.kode_asterik_icd WHERE b.kode_master_icd='$src_icd' GROUP BY a.icd_10,a.nama_icd,b.kode_asterik_icd");
        while($dt=$asterik_icd->fetchRow()){
            $dt['icd_10'] = $src_icd;
            $asterik_icd10[] = $dt;
        }
        if(is_array($asterik_icd10)) {
            $data['code']=200;
            $data['list']=$asterik_icd10;
        }else {
            $data['code']=500;
            $data['msg']="Data Asterix tidak ditemukan"; 
        }
    break;
}

echo json_encode($data);