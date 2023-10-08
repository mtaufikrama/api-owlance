<?php
if (!defined("AV_LIB_LOADED")):
	define("WWWROOT", $DOCUMENT_ROOT);
	require_once(WWWROOT . "/lib/db.php");
endif; #if(!defined("AV_LIB_LOADED")):

#===============================================================================
if (!function_exists("baca_tabel")):
	function baca_tabel($tbl = "", $fld = "", $opt = "")
	{
		if (strlen($fld) > 0):

			global $db;
			global $loginInfo;
			global $PHP_SELF;
			global $AV_CONF;
			$sqlnya = "SELECT $fld AS nilai FROM $tbl $opt";
			$r =& $db->Execute($sqlnya);

			// if(($db->ErrorMsg())!=""){
			// 	$status_eksekusi="Error : ".$db->ErrorMsg();
			// 	$tabel_log="log_history_".date("m");
			// 				$tgl=date("Y-m-d H:i:s");
			// 				$id_dd_user=$loginInfo["id_dd_user"];
			// 				$ip_address=USER_IP_ADDRESS;
			// 				$kode_bagian=$loginInfo["kode_bagian"];
			// 				$session_id=session_id();
			// 				$sql_command=$db->Quote($sqlnya);
			// 				$tabel=$db->Quote($tbl);
			// 				$field=$db->Quote($fld);
			// 				$kondisi=$db->Quote($opt);
			// 				$jenis_sql=0;
			// 				$nama_file=$PHP_SELF;
			// 				$status_eksekusi=$db->Quote($status_eksekusi);
			// 				$sqlLog="insert into $tabel_log(tgl,id_dd_user,ip_address,kode_bagian,session_id,nama_file,sql_command,tabel,field,kondisi,jenis_sql,status_eksekusi) values('$tgl','$id_dd_user','$ip_address','$kode_bagian','$session_id','$nama_file',$sql_command,$tabel,$field,$kondisi,0,$status_eksekusi)";
			// 		if($AV_CONF["etc"]["log_history"]==true){
			// 				$db->Execute($sqlLog);
			// 		}
			// 	}

			//$r=read_tabel($tbl,$fld,$opt);
			while ($rs = $r->FetchRow()):
				$hasil = $rs["nilai"];
				break;
			endwhile; #while($rs=$r->FetchRow()):
			if (isset($hasil))
				return $hasil;
			else
				return false;
		else:
			return false;
		endif; #if(strlen($fld)>0):

	} #function baca_tabell($tbl="",$fld="*",$opt=""){
endif; #if(!function_exists("baca_tabel")):
#===============================================================================
if (!function_exists("read_tabel")):
	function read_tabel($tbl = "", $fld = "*", $opt = "", $limit = "", $offset = "")
	{
		global $db;
		global $loginInfo;
		global $PHP_SELF;
		global $AV_CONF;
		global $sql_read_tabel;
		if (strlen($tbl) > 0):
			if (strlen($limit) < 1):
				$sql = "SELECT $fld FROM $tbl $opt";
				$r =& $db->Execute($sql);

			else:
				$sql = "SELECT $fld FROM $tbl $opt";
				$r =& $db->SelectLimit($sql, $limit, $offset);
			endif; #if(strlen($limit)<1):

			// if(($db->ErrorMsg())!=""){
			// $status_eksekusi="Error : ".$db->ErrorMsg();
			// $tabel_log="log_history_".date("m");
			// 			$tgl=date("Y-m-d H:i:s");
			// 			$id_dd_user=$loginInfo["id_dd_user"];
			// 			$ip_address=USER_IP_ADDRESS;
			// 			$kode_bagian=$loginInfo["kode_bagian"];
			// 			$session_id=session_id();
			// 			$sql_command=$db->Quote($sql);
			// 			$tabel=$tbl;
			// 			$field=$db->Quote($fld);
			// 			$kondisi=$db->Quote($opt);
			// 			$jenis_sql=0;
			// 			$nama_file=$PHP_SELF;
			// 			$status_eksekusi=$db->Quote($status_eksekusi);
			// 			$sqlLog="insert into $tabel_log(tgl,id_dd_user,ip_address,kode_bagian,session_id,nama_file,sql_command,tabel,field,kondisi,jenis_sql,status_eksekusi) values('$tgl','$id_dd_user','$ip_address','$kode_bagian','$session_id','$nama_file',$sql_command,'$tabel',$field,$kondisi,0,$status_eksekusi)";
			// 	if($AV_CONF["etc"]["log_history"]==true){
			// 			$db->Execute($sqlLog);
			// 	}
			// }

			$sql_read_tabel = $sql;
			return $r;



		endif; #if(strlen($tbl)>0):
	}
	; #function read_tabel($tbl="",$fld="",$opt="",$limit=""){
endif; #if(!function_exists("read_tabel")):
#===============================================================================
if (!function_exists("select_tabel")):
	function select_tabel($tbl = "", $fld = "*", $opt = "", $limit = "", $offset = "")
	{
		return read_tabel($tbl, $fld, $opt, $limit, $offset);
	} #function select_tabel($tbl="",$fld="*",$opt="WHERE -1",$limit="",$offset=""){
endif; #if(!function_exists("select_tabel")):
#===============================================================================
if (!function_exists("insert_tabel")):
	function insert_tabel($tbl = "", $fld_n_values = array())
	{
		global $db, $ADODB_FETCH_MODE1;
		global $db;
		global $loginInfo;
		global $PHP_SELF;
		global $AV_CONF;
		$hasil = false;
		if (strlen($tbl) > 0):

			// input dulu ke log_history================


			// $tabel_log="log_history_".date("m");
			// $tgl=date("Y-m-d H:i:s");
			// $id_dd_user=$loginInfo["id_dd_user"];
			// $ip_address=USER_IP_ADDRESS;
			// $kode_bagian=$loginInfo["kode_bagian"];
			// $session_id=session_id();
			// $sql_command=$db->Quote($sqlInsert);
			// $tabel=$tbl;
			// $field=$db->Quote((implode(",", array_keys($fld_n_values))));
			// $kondisi=$db->Quote($opt);
			// $jenis_sql=2;
			// $nama_file=$PHP_SELF;
			// $status_eksekusi=$db->Quote(' Eksekusi Insert ');
			// $sqlLog="insert into $tabel_log(tgl,id_dd_user,ip_address,kode_bagian,session_id,nama_file,sql_command,tabel,field,kondisi,jenis_sql,status_eksekusi) values('$tgl','$id_dd_user','$ip_address','$kode_bagian','$session_id','$nama_file',$sql_command,'$tabel',$field,$kondisi,1,$status_eksekusi)";
			// if($AV_CONF["etc"]["log_history"]==true){
			// $db->Execute($sqlLog);
			// }

			//============================================


			$meta = $db->MetaColumnNames($tbl);
			$trans = $meta;
			$i = 0;
			foreach ($trans as $key => $value) {

				$meta[$i] = $value;
				$i++;
			}
			$firstfield = $meta[0];
			$emptyRec =& $db->Execute("SELECT * FROM $tbl WHERE $firstfield IS NULL");
			$sqlInsert =& $db->GetInsertSQL($emptyRec, $fld_n_values);
			if ($sqlInsert):
				$hasil =& $db->Execute($sqlInsert);
			endif; #if($sqlInsert):						




		endif; #if(strlen($tbl)>0):
		return $hasil;
	}
	;
endif; #if(!function_exists("insert_tabel")):
#===============================================================================
if (!function_exists("update_tabel")):
	function update_tabel($tbl = "", $fld_n_values = array(), $opt = "", $forceUpdate = true)
	{
		global $db;
		global $loginInfo;
		global $PHP_SELF;
		global $AV_CONF;
		$hasil = false;
		if (strlen($tbl) > 0):
			$updRec =& $db->Execute("SELECT * FROM $tbl $opt");
			$sqlUpdate =& $db->GetUpdateSQL($updRec, $fld_n_values, $forceUpdate);
			$hasil = true;
			if ($sqlUpdate):
				$hasil =& $db->Execute($sqlUpdate);
			endif; #if($sqlUpdate):	

			if (($hasil) and ($sqlUpdate)) {
				$status_eksekusi = "Ok";
			} else {
				$status_eksekusi = "Error : " . $db->ErrorMsg();
			}
			// 		$tabel_log="log_history_".date("m");
			// 		$tgl=date("Y-m-d H:i:s");
			// 		$id_dd_user=$loginInfo["id_dd_user"];
			// 		$ip_address=USER_IP_ADDRESS;
			// 		$kode_bagian=$loginInfo["kode_bagian"];
			// 		$session_id=session_id();
			// 		$sql_command=$db->Quote($sqlUpdate);
			// 		$tabel=$tbl;
			// 		$field=$db->Quote((implode(",", array_keys($fld_n_values))));
			// 		$kondisi=$db->Quote($opt);
			// 		$jenis_sql=2;
			// 		$nama_file=$PHP_SELF;
			// 		$status_eksekusi=$db->Quote($status_eksekusi);
			// 		$sqlLog="insert into $tabel_log(tgl,id_dd_user,ip_address,kode_bagian,session_id,nama_file,sql_command,tabel,field,kondisi,jenis_sql,status_eksekusi) values('$tgl','$id_dd_user','$ip_address','$kode_bagian','$session_id','$nama_file',$sql_command,'$tabel',$field,$kondisi,2,$status_eksekusi)";
			// if($AV_CONF["etc"]["log_history"]==true){
			// 		$db->Execute($sqlLog);
			// }

		endif; #if(strlen($tbl)>0):
		return $hasil;
	}
	;
endif; #if(!function_exists("update_tabel")):
#===============================================================================
if (!function_exists("delete_tabel")):
	function delete_tabel($tbl = "", $opt = "")
	{
		global $db;
		global $loginInfo;
		global $PHP_SELF;
		global $AV_CONF;
		$delRec = false;
		if (strlen($tbl) > 0):
			$delRec =& $db->Execute("DELETE FROM $tbl $opt");
		endif; #if(strlen($tbl)>0):

		if ($delRec) {
			$status_eksekusi = "Ok";
		} else {
			$status_eksekusi = "Error : " . $db->ErrorMsg();
		}

		// 		$tabel_log="log_history_".date("m");
		// 		$tgl=date("Y-m-d H:i:s");
		// 		$id_dd_user=$loginInfo["id_dd_user"];
		// 		$ip_address=USER_IP_ADDRESS;
		// 		$kode_bagian=$loginInfo["kode_bagian"];
		// 		$session_id=session_id();
		// 		$sql_command=$db->Quote("DELETE FROM $tbl $opt");
		// 		$tabel=$tbl;
		// 		$field='';
		// 		$kondisi=$db->Quote($opt);
		// 		$jenis_sql=3;
		// 		$nama_file=$PHP_SELF;
		// 		$status_eksekusi=$db->Quote($status_eksekusi);
		// 		$sqlLog="insert into $tabel_log(tgl,id_dd_user,ip_address,kode_bagian,session_id,nama_file,sql_command,tabel,field,kondisi,jenis_sql,status_eksekusi) values('$tgl','$id_dd_user','$ip_address','$kode_bagian','$session_id','$nama_file',$sql_command,'$tabel','$field',$kondisi,3,$status_eksekusi)";
		// if($AV_CONF["etc"]["log_history"]==true){
		// 		$db->Execute($sqlLog);
		// }

		return $delRec;
	}
	;
endif; #if(!function_exists("delete_tabel")):


#===============================================================================
if (!function_exists("autonumber")):
	function autonumber($an_tbl, $an_fld, $an_opt = "")
	{
		global $db;

		$rA = $db->Execute("SELECT MAX($an_fld) as maxnum FROM $an_tbl $an_opt");
		while ($a = $rA->FetchRow()):
			$maxnum = $a["maxnum"];
		endwhile; //while($a=$rA->FetchRow()):
		if (strlen($maxnum) < 1):
			$maxnum = 0;
		endif; //if(strlen($maxnum)<1):
		$maxnum++;

		return $maxnum;
	} //end function autonumber
endif; #if(!function_exists("autonumber")):
#===============================================================================
if (!function_exists("lastnumber")):
	function lastnumber($gl_tbl, $gl_fld, $gl_opt = "")
	{
		global $db;

		$rA = $db->Execute("SELECT MAX($gl_fld) AS maxnum FROM $gl_tbl $gl_opt");
		while ($a = $rA->FetchRow()):
			$maxnum = $a["maxnum"];
		endwhile; //while($a=$rA->FetchRow()):
		if (strlen($maxnum) < 1):
			$maxnum = 0;
		endif; //if(strlen($maxnum)<1):

		return $maxnum;
	} //end function lastnumber
endif; #if(!function_exists("lastnumber")):
#-------------------------------------------------------------------------------------

if (!function_exists("isi_kirim")):
	function isi_kirim($yg_tidak = "")
	{
		//global $_POST,$_GET;

		reset($_POST);
		$nama_var = "";
		$yg_gak_masuk = split(",", $yg_tidak);
		$banyak_cekfield = count($yg_gak_masuk);

		while (list($key, $val) = each($_POST)) {
			$cek_ada = 0;
			for ($helmi1 = 0; $helmi1 < $banyak_cekfield; $helmi1++) {
				if ($yg_gak_masuk[$helmi1] == $key):
					$cek_ada++;

				endif;
			} // end of for
			if ($cek_ada < 1) {
				$nama_var = $nama_var . "&" . $key . "=" . urlencode($val);
			} // end of if
		} // end of while
		reset($_GET);
		while (list($kuncinya, $isinya) = each($_GET)) {
			$cek_ada = 0;
			for ($helmi1 = 0; $helmi1 < $banyak_cekfield; $helmi1++) {
				if ($yg_gak_masuk[$helmi1] == $kuncinya):
					$cek_ada++;

				endif;
			} // end of for

			if ($cek_ada < 1) {
				$nama_var = $nama_var . "&" . $kuncinya . "=" . urlencode($isinya);
			} // end of if
		} // end of while

		$nilai_lempar = substr($nama_var, 1);

		return $nilai_lempar;
	} # end of function isi_kirim
endif; #if(!function_exists("isi_kirim")):
#===============================================================================

if (!function_exists("isi_hidden")):
	function isi_hidden($yg_tidak = "")
	{
		//global $_POST,$_GET;

		reset($_POST);
		$nama_var = "";
		$yg_gak_masuk = split(",", $yg_tidak);
		$banyak_cekfield = count($yg_gak_masuk);


		while (list($key, $val) = each($_POST)) {
			$cek_ada = 0;
			for ($helmi1 = 0; $helmi1 < $banyak_cekfield; $helmi1++) {
				if ($yg_gak_masuk[$helmi1] == $key):
					$cek_ada++;
				endif;
			} // end of for

			if ($cek_ada < 1) {
				?>
				<INPUT TYPE="hidden" name="<?php echo $key ?>" value="<?php echo $val ?>">
			<?php
			}

		} // end of while
		reset($_GET);
		while (list($kuncinya, $isinya) = each($_GET)) {
			$cek_ada = 0;
			for ($helmi1 = 0; $helmi1 < $banyak_cekfield; $helmi1++) {
				if ($yg_gak_masuk[$helmi1] == $kuncinya):
					$cek_ada++;
				endif;
			} // end of for

			if ($cek_ada < 1) {
				?>
				<INPUT TYPE="hidden" name="<?php echo $kuncinya ?>" value="<?php echo $isinya ?>">
				<?php
			}

		} // end of while

	} # end of function isi_hidden
endif; #if(!function_exists("isi_hidden")):

#=================================================================================

if (!function_exists("data_tabel")):
	function data_tabel($nama_tabel = "", $syarat = "")
	{
		global $db;

		$eksekusi = $db->Execute("SELECT * FROM $nama_tabel $syarat");

		$hasil = $eksekusi->fields;

		return $hasil;
	} //end function data_tabel
endif; #if(!function_exists("data_tabel")):
#=================================================================================

#===============================================================================

#=====================================================================================

?>