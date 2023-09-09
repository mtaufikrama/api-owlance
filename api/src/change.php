<?php 

$dataSend = json_decode(file_get_contents("php://input"),TRUE);

$keyCode = $dataSend['KeyCode'];
$v = $dataSend['v'];

if ($keyCode == 'MeTiRs' && $v == '1.0') {
    $SqlGetToken="SELECT IDApi,KodeApi,KeyApi,KeyCode from ref_api_dmedis where KeyCode='d40f936a3c8b8d077aae49fe8046c647822f4d692891de690ea4cfb24fa27d97'";
    
    $RunGetToken=$db->Execute($SqlGetToken);
    while($TplGetToken=$RunGetToken->fetchRow()){
        foreach($TplGetToken as $key=>$val){
            $$key=$val;
        }
    }
} else {
    $data['code'] = 500;
    $data['msg'] = 'Aplikasi harus diupdate';
    echo json_encode($data);
    die;
}
?>