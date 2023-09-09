<?php
session_start();
require_once("../_lib/function/db_login.php");
require_once("../_lib/function/function.olah_tabel.php");
require_once("../_contrib/privyid/api_sign.php");
$mr=base64_decode($a);
$SqlGetData="SELECT\n".
"tb_privyid_doc_sign.reference_number,\n".
"tb_privyid_doc_sign.document_token,\n".
"tb_privyid_doc_sign.info\n".
"FROM `tb_privyid_doc_sign` where reference_number='$ref'";
$RunGetData=$db->Execute($SqlGetData);
while($TplGetData=$RunGetData->fetchRow()){
	foreach($TplGetData as $key=>$val){
		$$key=$val;
	}
}
$sign=new sign();
$data['reference_number']=$reference_number;
$data['channel_id']=$channel_id;
$data['document_token']=$document_token;
$data['info']=$info;
$sign->token();
// $sign->debug=true;
$hasil=$sign->DocStatus($data);

if(is_array($hasil['error'])){		
		$feedback['code']=500;
		$feedback['msg']=$hasil['error']['errors'][0];
	}else{
		$feedback['code']=200;
		$feedback['msg']=$hasil;
		$dataDoc['doc_status']=$hasil['data']['status'];
		$dataDoc['signed_document']=$hasil['data']['signing_url'];
		$result=update_tabel("tb_privyid_doc_sign",$dataDoc,"where reference_number='$ref'");
	}
echo json_encode($feedback);
?>
