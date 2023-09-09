<?php
if (!defined("AV_LIB_LOADED") || AV_LIB_LOADED==false) {
	define("WWWROOT",$DOCUMENT_ROOT);
	require_once(WWWROOT."/lib/db.php");
} // end of if (!defined("AV_LIB_LOADED") || AV_LIB_LOADED==false)

if (!class_exists("Paging")) {

	require "../_lib/function/function.paging_bawah.php";

	class Paging {
		var $db; 	// ADODB connection object
		var $sql; 	// sql used
		var $rs;	// recordset generated

		var $pagingVars=array();

		function Paging($db,$sql,$recperpage=10) {
			$this->db=$db;
			$this->sql=$sql;
			$this->pagingVars["currpage"]=1;
			$this->pagingVars["recperpage"]=$recperpage;
		} // end of function paging($sql="",$recperpage=10)

		function ExecPage($hlm="",$ikutan="") {
			$con=$this->db;
			$rec=$this->pagingVars["recperpage"];
			if (strlen($hlm)<1) { $hlm=1; }

			//exec the queries
			$rs=&$con->PageExecute($this->sql,$this->pagingVars["recperpage"],$hlm);	# paging query

			$this->pagingVars["maxrecords"] = $rs->_maxRecordCount;
			$this->pagingVars["lastpage"] = $rs->LastPageNo();
			//if ($rs->_maxRecordCount > 0) { $this->pagingVars["lastpage"] = $rs->LastPageNo(); }
			$this->pagingVars["firstpage"] = 1;
			$this->pagingVars["currpage"] = ($hlm < 1) ? 1 : (($hlm > $this->pagingVars["lastpage"]) ? $this->pagingVars["lastpage"] : $hlm);

			if (($this->pagingVars["currpage"]+1) > $this->pagingVars["lastpage"]) {
				$this->pagingVars["nextpage"]=$this->pagingVars["lastpage"];
			} else {
				$this->pagingVars["nextpage"] = $this->pagingVars["currpage"] + 1;
			}

			if ($this->pagingVars["currpage"] < 2) {
				$this->pagingVars["prevpage"] = 1;
			} else {
				$this->pagingVars["prevpage"] = $this->pagingVars["currpage"] - 1;
			}
			$this->pagingVars["firstno"] = ($this->pagingVars["currpage"] - 1) * $this->pagingVars["recperpage"];

			// Translate Paging Variables to its corresponding URLs
			/*
			$this->pagingVars["urlfirstpage"]=$_SERVER["PHP_SELF"]."?hlm=".$this->pagingVars["firstpage"];
			$this->pagingVars["urlprevpage"]=$_SERVER["PHP_SELF"]."?hlm=".$this->pagingVars["prevpage"];
			$this->pagingVars["urlcurrpage"]=$_SERVER["PHP_SELF"]."?hlm=".$this->pagingVars["currpage"];
			$this->pagingVars["urlnextpage"]=$_SERVER["PHP_SELF"]."?hlm=".$this->pagingVars["nextpage"];
			$this->pagingVars["urllastpage"]=$_SERVER["PHP_SELF"]."?hlm=".$this->pagingVars["lastpage"];
			*/

			return $rs;
		} // end of function execpage($hal="",$ikutan="")

		function PageNav($obj_paging) {
			//include "../_inc/tpl_incPageNav.php";
			paging_bawah($obj_paging);
		}

	} // end of class paging
} // end of if (!class_exists("paging"))
?>