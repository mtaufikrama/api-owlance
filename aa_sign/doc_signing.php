<?php
session_start();
require_once("../_lib/function/db_login.php");
require_once("../_lib/function/function.olah_tabel.php");
require_once("../_contrib/privyid/api_sign.php");
// $db->debug=true;
$SqlGetData="SELECT\n".
"tb_privyid_reg.no_mr,\n".
"tb_privyid_reg.reference_number,\n".
"tb_privyid_reg.register_token,\n".
"tb_privyid_reg.privyid,\n".
"tb_privyid_reg.enterpriseToken,\n".
"tb_privyid_reg.`status`\n".
"FROM `tb_privyid_reg` where no_mr='$mr';";
$RunGetData=$db->Execute($SqlGetData);
while($TplGetData=$RunGetData->fetchRow()){
	$reference_number=$TplGetData['reference_number'];
	$register_token=$TplGetData['register_token'];
	$privyid=$TplGetData['privyid'];
	// $enterpriseToken=$TplGetData['enterpriseToken'];	
	//$enterpriseToken=$register_token;	
}
/* -- channel id -- */
/* $SqlGetKode="select CONCAT(jenis_app,kode_rs) as kode from dd_konfigurasi;";
$RunGetKode=db->Execute($SqlGetKode);
while($TplGetKode=$RunGetKode->fetchRow()){
	$channel_id=$TplGetKode['kode'];
} */
/* -- channel id -- */
$AddRef=$AddRef;
$arrReceipt['user_type']="0";//0 = user internal. 1 = user eksternal.
$arrReceipt['autosign']="0";//If 1 = auto sign on,
$arrReceipt['id_user']=$privyid;
$arrReceipt['signer_type']="Signer";
$arrReceipt['sign_type']=1;
$arrReceipt['enterpriseToken']="";
$arrReceipt['posX']="1";
$arrReceipt['posY']="650";
$arrReceipt['signPage']="1";
$channel_id=$channel_id;
$sign=new sign();
$data['reference_number']=$AddRef;
$data['channel_id']=$channel_id;
$data['info']="";
$data['visibility']=false;
$data['doc_owner']['privyId']=$privyidown;
$data['doc_owner']['enterpriseToken']=$enterpriseToken;
$data['document']['document_file']=$document_file;
$data['document']['document_name']=$document_name;
$data['document']['sign_type']="1";//0:barcode 1:Latin Italic Name
$data['document']['notify_user']="1";//0:Link tak Kirim User 1://link kirim user
$data['document']['sign_process']="0";//0:Serial 1:pararel
$data['document']['barcode_potition']="0";//0 = top left corner first page 1 = bottom right last page
$data['recipients'][]=$arrReceipt;

$sign->token();
// $sign->debug=true;
$hasil=$sign->DocSigning($data);

if(is_array($hasil['error'])){		
		$feedback['code']=500;
		$feedback['msg']=json_encode($hasil['error']);
	}else{
		//--------------------- Cek Ada Dokumen -------------------------------------//
		$SqlCekDok="select count(reference_number) as cekJum from tb_privyid_doc_sign where reference_number='$AddRef'";
		$RunCekDok=$db->Execute($SqlCekDok);
		while($TplCekDok=$RunCekDok->fetchRow()){
			$cekJum=$TplCekDok['cekJum'];
		}
		//--------------------- Insert Dokumen -------------------------------------//
		if($info==""){
			$info=$no_registrasi;
		}
		// $db->debug=true;
		unset($dataDoc);
		$dataDoc['reference_number']=$AddRef;
		$dataDoc['channel_id']=$channel_id;
		$dataDoc['info']=$info;
		$dataDoc['doc_owner_privyId']=$privyidown;
		$dataDoc['doc_owner_enterpriseToken']=$enterpriseToken;
		$dataDoc['doc_document_file']=$document_file;
		$dataDoc['doc_document_name']=$document_name;
		$dataDoc['doc_sign_type']="0";
		$dataDoc['doc_notify_user']="0";
		$dataDoc['doc_sign_process']="0";
		$dataDoc['doc_barcode_potition']="0";
		$dataDoc['no_registrasi']=$no_registrasi;
		$dataDoc['date_reg']=date("Y-m-d H:i:s");
		$dataDoc['kode_dokter']=$kode_dokter;
		$dataDoc['document_token']=$hasil['data']['document_token'];
		$dataDoc['signing_url']=$hasil['data']['signing_url'];
		if($cekJum > 0){
			unset($dataDoc['reference_number']);
			$result=update_tabel("tb_privyid_doc_sign",$dataDoc,"where reference_number='$AddRef'");
		}else{
			$result=insert_tabel("tb_privyid_doc_sign",$dataDoc);
		}
		
		
		unset($dataDocrecip);
		$dataDocrecip['reference_number_doc']=$AddRef;
		$dataDocrecip['user_type']="0";
		$dataDocrecip['autosign']="1";
		$dataDocrecip['id_user']=$privyid;
		$dataDocrecip['signer_type']="Signer";
		$dataDocrecip['enterpriseToken']="";
		$dataDocrecip['posX']="100";
		$dataDocrecip['posY']="100";
		$dataDocrecip['signPage']="1";
		if($cekJum > 0){
			if($result) $result=update_tabel("tb_privyid_doc_sign_recipients",$dataDocrecip,"where reference_number_doc='$AddRef' AND id_user='$privyid'");
		}else{
			if($result) $result=insert_tabel("tb_privyid_doc_sign_recipients",$dataDocrecip);
		}
		//--------------------- Insert Dokumen -------------------------------------//
		
		
		$feedback['code']=200;
		$feedback['msg']=$hasil['message'];
		$feedback['ref']=$AddRef;
	}
echo json_encode($feedback);
?>