<?php
if(!class_exists("autoprint")):
	class autoprint{
		var $data;

		function autoprint(){  //constructor
			$this->data=array();
			global $db;
			$this->data['db']=$db;

			$this->get_printer();
		} #function autoprint(){
		
		function get_printer(){
			$this->data['local_ip']="192.168.1.14";
			$localip=$this->data['local_ip'];

			$db=$this->data['db'];

			$sqlPrint="SELECT nm_komputer, nm_printer FROM dc_printto a, dc_printer b WHERE b.kd_printer=a.kd_printer AND a.ip_address='$localip'";
			$hasilPrint=$db->Execute($sqlPrint);

			while($tampilPrint=$hasilPrint->FetchRow()){
				$nm_komputer=$tampilPrint["nm_komputer"];
				$nm_printer=$tampilPrint["nm_printer"];
			
			}
			echo $nm_komputer."|".$nm_printer;

			//$r=odbc_do($db,"SELECT nm_komputer, nm_printer FROM printto a, printer b WHERE b.kd_printer=a.kd_printer AND a.ip_address='$localip'");

			/*while(odbc_fetch_row($r)):
				$nm_komputer=odbc_result($r,"nm_komputer");
				$nm_printer=odbc_result($r,"nm_printer");
			endwhile; #while(odbc_fetch_row($r)):*/

			$this->print_to($nm_komputer,$nm_printer);
		}

		// first public method, to initiate temporary file 2 b printed
		function create_file($namafile=""){
			$ses=session_id();
			if(strlen($namafile)>0):
				$this->data["namafile"]=$ses.".".$namafile.".prn";
			else:
				$this->data["namafile"]=$ses.".prn";
			endif; #if(strlen($namafile)>0):

			$file2create=$this->data["namafile"];
			$fp=@fopen($file2create,"w");
			if($fp):
				$this->data["filepointer"]=$fp;
				$this->data["filestatus"]="open";
				return $fp;
			else:
				$this->data["error"]="Gagal Create File : ".$file2create;
				return false;
			endif; #if($fp):
		} #function create_file($namafile=""){

		function add_line($text2add=""){
			$fp=$this->data["filepointer"];
			$text2add.=" \n";

			$textadded=@fputs($fp,$text2add);
			if($textadded):
				return true;
			else:
				$this->data["error"]="Gagal create text : ".$text2add;
			endif; #if($textadded):
		} #(function add_line($text2add=""){)

		function close_file(){
			$fp=$this->data["filepointer"];
			$filestatus=$this->data["filestatus"];
			$filename=$this->data["namafile"];
			if($filestatus=="open"):
				$fclosed=@fclose($fp);
				if($fclosed):
					$this->data["filestatus"]="closed";
					unset ($this->data["filepointer"]);
					return true;
				else:
					$this->data["error"]="Gagal Menutup File : ".$namafile;
					return false;
				endif; #if($fclosed):
			else:
				$this->data["error"]="File Sudah Tertutup : ".$namafile;
				return true;
			endif; #if($filestatus=="open"):
		} #function close_file(){

		function print_to($computername="",$printername=""){
			$ok=true;
			
			

			if(strlen($computername)>0):
				$this->data["computername"]=$computername;
				$ok=true;
				
			else:
				$ok=false;
			endif; #if(strlen($computername)>0):

			if(strlen($printername)>0 && $ok):
				$this->data["printername"]=$printername;
				$ok=true;
				echo $computername."aa|".$printername;
			else:
				$ok=false;
			endif; #if(strlen($printername)>0):

			if($ok):
				$sharename="\\\\".$computername."\\".$printername;
				$this->data["sharename"]=$sharename;
				return $sharename;
			else:
				$ok=false;
				$this->data["error"]="Nama Printer Salah : ".CHR(92).CHR(92).$computername.CHR(92).'"'.$printername.'"';
				return false;
			endif; #if($ok):
		} #function print_to($computername="",$printername=""){

		function go_print(){
			if($this->data["filestatus"]=="closed"):
				return $this->_exec_print();
			else:
				if($this->close_file()):
					return $this->_exec_print();
				else:
					$this->data["error"]="File Masih Terbuka : ".$this->data["namafile"];
					return false;
				endif; #if($this->close_file()):
			endif; #if($this->data["filestatus"]=="close"):
		} #function go_print(){

		function _exec_print(){
				$com=$this->data["computername"];
				$prin=$this->data["printername"];
				//$sharename=$this->data["sharename"];
				$filename=$this->data["namafile"];
				//echo "sharename=$sharename";
				//$command='print /D:"'.$sharename.'" '.$filename;

				//$printed=@system($command);
				//$printed=@system($command);
				//$deleted=@unlink($filename);

				$aa="@echo off";
				$aa.=" \n";
				$aa.="print /D:".'"'.CHR(92).CHR(92).CHR(92).CHR(92).$com.CHR(92).CHR(92).$prin.'"'." ".$filename;
				$aa.=" \n";
				$aa.="del ".$filename;
				
				$fp = fopen (session_id().".tmp",w);
				//$printed=@system("ren test2.bat test.bat");

				$aa=stripslashes($aa);
				fputs($fp,$aa);
				fclose ($fp);
				rename(session_id().".tmp", session_id().".bat");

				//clearstatcache();
				if($printed):
					$this->data["printstatus"]=$printed;
					return $printed;
				else:
					$this->data["printstatus"]=$printed;
					$this->data["error"]="Gagal Mencetak : ".$this->data["namafile"];
					return false;
				endif; #if($printed):
		} #function _exec_print(){

		function get_file(){
			$filename=$this->data["namafile"];
			$fp=@fopen($filename,"r");
			if($fp):
				$temp=@file_get_contents($fp);
				if($temp):
					return $temp;
				else:
					$this->data["error"]="Gagal Read File : ".$this->data["namafile"];
					return false;
				endif;
			else:
				$this->data["error"]="Gagal Retrive File : ".$this->data["namafile"];
				return false;
			endif;
		} #function get_file(){

    } #class autoprint{
endif; #if(!class_exists("autoprint")):
?>