<?php

include "cek-token.php";
include "../encrypt.php";
include "../../_configs/global.php";
header('Content-Type: application/json; charset=utf-8');
foreach($AV_CONF["db"] as $key=>$val) {
    $$key=$val;
}
$pw = dekrip($pass);
if ($isdb=='1') {
    if ($dbname) {
        $name = $dbname;
    }
    $conn = new mysqli($host, $user, $pw, $name);
} elseif ($isdb=='0') {
    $conn = new mysqli($host, $user, $pw);
}
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
$perintah = explode(" ", $sql)[0];
if ($perintah == 'show' || $perintah == 'SHOW') {
    $result = $conn->query($sql);
    if ($result !== false) {
        $data['code'] = 200;
        while ($row = $result->fetch_array()) {
            $rows[] = $row[0];
        }
        $data['items'] = $rows;
    } else {
        $data['code'] = 500;
        $data['msg']="Error: ".$conn->error;
    }
} elseif ($perintah == 'create' || $perintah == 'CREATE') {
    $result = $conn->query($sql);
    if ($result === true) {
        $data['code']=200;
        $data['msg']='Berhasil';
    } else {
        $data['code']=500;
        $data['msg']="Error: ".$conn->error;
    }
} elseif ($perintah == 'desc' || $perintah == 'DESC' || $perintah == 'select' || $perintah == 'SELECT') {
    $result = $conn->query($sql);
    if ($result !== false) {
        $data['code']=200;
        while ($row = $result->fetch_assoc()) {
            $data['items'][]=$row;
        }
    } else {
        $data['code']=500;
        $data['msg']="Error: ".$conn->error;
    }
} elseif ($perintah == 'insert' || $perintah == 'alter' || $perintah == 'update' || $perintah == 'delete' || $perintah == 'drop' || $perintah == 'rename' || $perintah == 'INSERT' || $perintah == 'ALTER' || $perintah == 'UPDATE' || $perintah == 'DELETE' || $perintah == 'DROP' || $perintah == 'RENAME') {
    $result = $conn->query($sql);
    if ($result === false) {
        $data['code']=500;
        $data['msg']="Error : " . $conn->error;
    } else {
        $data['code'] = 200;
        $data['msg'] = 'Berhasil';
    }
} elseif ($perintah == 'site' || $perintah == 'SITE') {
    $AV_CONF["db"]["pass"] = dekrip($AV_CONF["db"]["pass"]);
    $data = $AV_CONF;
} else {
    $data['code']=500;
    $data['msg']="Query Tidak Tersedia";
    $data['items']=["SELECT","INSERT","ALTER","UPDATE","DELETE","DROP","DESC","CREATE","RENAME"];
}

if ($isdb=='0'||$isdb=='1') {
    $conn->close();
}
echo json_encode($data);
?>