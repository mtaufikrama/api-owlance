<?php

/**
 * lib_loaded : mbuh..
 *
 * @var $lib_loaded buat ngapain yach ???
 * @access mbuh 
 */
$lib_loaded=array();

// ----------------------- FUNCTION _avregisterlib -----------------------

/**
 * _avregisterlib() : Utk bla.. bla.. bla..
 *
 * @param  string   $libtype   Tipe library (class, function, etc)
 * @param  string   $libpath   Path library
 * @param  string   $libname   Nama library
 * @param  boolean  $libonce   Apa perlu di-load satu kali saja atau tidak
 * @param  string   $libscope  Scope (GLOBAL atau LOCAL)
 */

if (!function_exists("_avregisterlib")) {
	function _avregisterlib($libtype,$libpath,$libname,$libonce,$libscope) {
		global $lib_loaded;
		$f_load=array();
		$f_load["type"]=$libtype;
		$f_load["name"]=$libname;
		$f_load["path"]=$libpath;
		$f_load["once"]=$libonce;
		$f_load["scope"]=$libscope;
		$lib_loaded[]=$f_load;
	} #function _avregisterlib($libtype,$libpath,$libname,$libonce,$libscope){
} // end of if (!function_exists("_avregisterlib"))

// ----------------------- FUNCTION loadlib -----------------------

/**
 * _avregisterlib() : Utk bla.. bla.. bla..
 *
 * @param  string   $tipe  Tipe library (class, function, etc)
 * @param  string   $nama  Nama library
 * @param  boolean  $once  Apa perlu di-load satu kali saja atau tidak
 */

if (!function_exists("loadlib")) {
	function loadlib($tipe,$nama,$once=TRUE) {
		if (strlen($tipe)>0) {
			//$lib2load=WWWROOT."/_lib/$tipe/".$tipe.".".$nama.".php";
			$lib2load=WWWROOT."/_lib/".$tipe."/".$nama.".php";

			_avregisterlib($tipe,"/_lib/$tipe/",$nama,$once,"GLOBAL");

			if (file_exists($lib2load)) {
				if ($once) {
					_avlibloader($lib2load,TRUE);
				} else {
					_avlibloader($lib2load,FALSE);
				} // end of if ($once)
				return TRUE;
			} else {
				// print error!
				die ("Library ".$lib2load." Tidak Ada.\n");
			}
		} // end of if (strlen($tipe)>0)
	} // end of function loadlib($tipe,$nama,$once=TRUE)
} // end of if (!function_exists("load"))

// ----------------------- FUNCTION loadlocallib -----------------------

if (!function_exists("loadlocallib")) {
	function loadlocallib($tipe,$locallibpath="_lib",$nama,$once=TRUE) {
		if (strlen($tipe)>0) {

			if (substr($locallibpath,-1)<>"/") {
				$locallibpath.="/";
			} // end of if(substr($locallibpath,-1)<>"/")
			//$lib2load=$locallibpath.$tipe."/".$tipe.".".$nama.".php";
			$lib2load=$locallibpath.$tipe."/".$nama.".php";

			_avregisterlib($tipe,$locallibpath,$nama,$once,"LOCAL");

			if (file_exists($lib2load)) {
				if ($once) {
					_avlibloader($lib2load,TRUE);
				} else {
					_avlibloader($lib2load,FALSE);
				} // end of if($once)
				return TRUE;
			} else {
				// print error!
				die ("Library ".$lib2load." Tidak Ada.\n");
			} // end of
		} // end of if(strlen($tipe)>0)
	} // end of function loadlocallib($tipe,$locallibpath="lib",$nama,$once=TRUE) {
} // end of if(!function_exists("load"))


// ----------------------- FUNCTION _avlibloader -----------------------

if (!function_exists("_avlibloader")) {
	function _avlibloader($lib2load,$once=TRUE) {
		// don't call this function directly, use loadlib & loadlocallib instead !!!
		if (strlen($lib2load)>0) {
			if (file_exists($lib2load)) {
				if ($once) {
					$loadsukses=@require_once($lib2load);
				} else {
					$loadsukses=@include ($lib2load);
				} // end of if($once)
				if (!$loadsukses) {
					die ("Library $lib2load Tidak Ada.\n");
				} // end of if(!$loadsukses)
				return TRUE;
			} else {
				// print error!
				die ("Library ".$lib2load." Tidak Ada.\n");
			}
		} // end of if(strlen($lib2load)>0)
	} // end of function _avlibloader($lib2load)
} // end of if(!function_exists("_avlibloader"))

// ----------------------- FUNCTION  -----------------------

/**
 * nama_fungsi() : Keterangan fungsinya
 *
 * @param  tipe_variabel  $nama_variabel  Keterangan variabelnya
 *
 * @return  tipe_variabel  Keterangan return valuenya
 *
 */


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------

?>