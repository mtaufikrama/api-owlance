<?
$AV_CONF=array();

$AV_CONF["db"]["type"]="mysqli";
$AV_CONF["db"]["user"]="root";
$AV_CONF["db"]["pass"]="qluhyd0q4u6y7";
$AV_CONF["db"]["name"]="dev_adokter";
$AV_CONF["db"]["host"]="192.168.38.3";

// $AV_CONF["db"]["type"]="mysqli";
// $AV_CONF["db"]["user"]="root";
// $AV_CONF["db"]["pass"]="";
// $AV_CONF["db"]["name"]="a-dokter";
// $AV_CONF["db"]["host"]="127.0.0.1";

// $AV_CONF["db"]["type"]="mssqlnative";
// $AV_CONF["db"]["user"]="sa";
// $AV_CONF["db"]["pass"]="qluhyd0q4u6y7";
// $AV_CONF["db"]["name"]="bayangkara_sirs_trn";
//$AV_CONF["db"]["host"]="103.8.79.52";
// $AV_CONF["db"]["host"]="192.168.1.20";


$AV_CONF["etc"]["login_satu_saja"]=true;
$AV_CONF["etc"]["session_time_out"]=15;
$AV_CONF["etc"]["password_expired"]=true;
$AV_CONF["etc"]["development"]=true;		// development flag, to track whether in development mode
$AV_CONF["etc"]["log_history"]=true;	//log history query utk function olah_tabel (update,delete,insert);


$AV_CONF["url"]["ws"]="https://tel.d-medis.id/";

$AV_CONF["skin"]["name"]="default";

$AV_CONF["free_page"][]="/login.php";
$AV_CONF["free_page"][]="/login_act.php";
$AV_CONF["free_page"][]="/login1.php";
$AV_CONF["free_page"][]="/login1_act.php";



/*
$AV_CONF["dir"][""]="";
$AV_CONF["dir"][""]="";
$AV_CONF["dir"][""]="";
$AV_CONF["dir"][""]="";
*/

//echo "di dalam /_configs/global.php<br>\n";

// FTP
$AV_CONF["ftp"]["fModem"] = false;
$AV_CONF["ftp"]["strModemCon"] = "telkom";
$AV_CONF["ftp"]["strModemUsr"] = "telkomnet@instan";
$AV_CONF["ftp"]["strModemPas"] = "telkom";
$AV_CONF["ftp"]["strServer"] = "192.168.1.1";
$AV_CONF["ftp"]["numPort"] = "21";
$AV_CONF["ftp"]["numTimeOut"] = "90";
$AV_CONF["ftp"]["strFTPUser"] = "rsjiwa";
$AV_CONF["ftp"]["strFTPPass"] = "averin";
$AV_CONF["ftp"]["fFTPPasive"] = true;

$mtr["type"]="mysqli";
$mtr["user"]="root";
$mtr["pass"]="87654";
$mtr["name"]="adokter";
$mtr["host"]="127.0.0.1";

foreach($mtr as $key=>$val) {
    $$key=$val;
}

?>
