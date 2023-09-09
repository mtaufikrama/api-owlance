<?
/**
 * db.php : file untuk blah.. blah.. blah..
 * 
 * PHP versions 4 and 5 (Rencana ke depan buat versi 5 doang)
 *
 * @category   mbuh
 * @package    mbuh
 * @author     yoekriz, et al
 * @copyright  2005 yoekriz, et al
 * @license    restricted
 * @version    any idea???
 * @link       http://www.averin-tech.com
 * @see        not yet
 * @since 	   now
 * @todo       belom ada
 * @filesource
 */

if (!defined("AV_LIB_LOADED") || AV_LIB_LOADED==false) {

	// load session
	session_start();	// aktifken kalo udah selesai

	if (!defined("DIR_SEPARATOR")) define("DIR_SEPARATOR","\\");

	if (!defined("WWWROOT")) {
		$fname=dirname(__FILE__);
		$wwwroot=substr($fname,0,-14);
		define("WWWROOT",$wwwroot);

		// unset all unused local variables
		unset($wwwroot,$fname);
	}

	// Load configuration & constants
	include WWWROOT."/_configs/constants.php";
	include WWWROOT."/_configs/global.php";

	// define development flag constant
	if (isset($AV_CONF["etc"]["development"]) && $AV_CONF["etc"]["development"]) define("DEVELOPMENT",true);

	// initiate database
	if (!isset($db)) {
		require_once "function.dbconn.php";

		$db_type=$AV_CONF["db"]["type"];
		$db_host=$AV_CONF["db"]["host"];
		$db_user=$AV_CONF["db"]["user"];
		$db_pass=dekrip($AV_CONF["db"]["pass"]);
		$db_name=$AV_CONF["db"]["name"];

		if (defined("WWWROOT")) {
			$db=dbconn($db_type,$db_host,$db_user,$db_pass,$db_name);
		} else {
			die("konstanta WWWROOT tidak terdefinisi");
		}
	}

	// security method

	// Kalo bukan halaman yg diperbolehkan tidak login, boleh masuk
	if (!in_array($_SERVER["SCRIPT_NAME"],$AV_CONF["free_page"])) {

		// Kalo belom login or session udah abis, $db di-unset
		require_once substr(dirname(__FILE__),0,-8)."class/AvSecurity.php";
		$sec=new AvSecurity($db,session_id());
		if (!$sec->isLoggedIn()) {
			unset($db);
			$sec->invalidPage();
		} elseif ($sec->isSessionExpire()) {
			unset($db);
			$sec->invalidPage();
		}

		// ------- ngeset info ttg login di session -------
		if (!session_is_registered("loginInfo")) {
			session_register("loginInfo");
		}
	}

	// library-related functions
	include "function.library-related.php";

	// unset all unused local variables
	unset($db_type,$db_host,$db_user,$db_pass,$db_name);

	// define constant to prevent multi-call of db.php
	define("AV_LIB_LOADED",true);

} // end of if (!defined("AV_LIB_LOADED") || AV_LIB_LOADED==false)

?>
