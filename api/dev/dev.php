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
switch ($method) {
    case "sdb":
        $sql = "SHOW DATABASES";
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
        break;

    case "st":
        $sql = "SHOW TABLES";
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
        break;

    case "sf":
        if($fld=='') {
            $fld = "*";
        }
        $sql = "SELECT $fld FROM $tbl";
        $result = $conn->query($sql);
        if ($result !== false) {
            $data['code']=200;
            while ($row = $result->fetch_assoc()) {
                $rows[]=$row;
            }
            $data['items']=$rows;
        } else {
            $data['code']=500;
            $data['msg']="Error: ".$conn->error;
        }
        break;

    case "cdb":
        $sql = "CREATE DATABASE $dbname";
        if ($conn->query($sql) === true) {
            $data['code']=200;
            $data['msg']='Berhasil';
        } else {
            $data['code']=500;
            $data['msg']="Error: ".$conn->error;
        }
        break;

    case "iiv":
        $columns = implode(', ', array_keys($fld));
        $values = implode(', ', array_fill(0, count($fld), '?'));
        $sql = "INSERT INTO $tbl ($columns) VALUES ($values)";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            $data['code']=500;
            $data['msg']="Error preparing the statement: " . $conn->error;
            $conn->close();
            die;
        }
        $types = str_repeat('s', count($fld));
        $stmt->bind_param($types, ...array_values($fld));
        $result = $stmt->execute();
        if (!$result) {
            $data['code']=500;
            $data['msg']="Error executing the statement: " . $stmt->error;
        } else {
            $data['code']=200;
            $data['msg']="Berhasil";
        }
        $stmt->close();
        break;

    case "dt":
        $sql = "DESC $tbl";
        $result = $conn->query($sql);
        if ($result !== false) {
            $data['code']=200;
            while ($row = $result->fetch_assoc()) {
                $rows[]=$row;
            }
            $data['items']=$rows;
        } else {
            $data['code']=500;
            $data['msg']="Error: ".$conn->error;
        }
        break;

    case "cud":
        $sql = $query;
        $result = $conn->query($sql);
        if ($result === true) {
            $data['code'] = 200;
            $data['msg'] = 'Berhasil';
        } else {
            $data['code']=500;
            $data['msg']="Error : " . $conn->error;
        }
        break;

    case "ddb":
        $sql = "DROP DATABASE $dbname";
        $result = $conn->query($sql);
        if ($result === true) {
            $data['code'] = 200;
            $data['msg'] = 'Berhasil';
        } else {
            $data['code']=500;
            $data['msg']="Error : " . $conn->error;
        }
        break;

    case "cs":
        $AV_CONF["db"]["pass"] = dekrip($AV_CONF["db"]["pass"]);
        $data = $AV_CONF;
        break;

    default:
        $data['code']=500;
        $data['msg']="Method Tidak Tersedia";
        $data['item']=["sdb","st","sf","cdb","iiv","dt","cud","cs","ddb"];
        break;
}
if ($isdb=='0'||$isdb=='1') {
    $conn->close();
}
echo json_encode($data);
?>