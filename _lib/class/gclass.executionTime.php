<?
/*
################################

Author	: Helmi Anwar
Versi	: 1.7.1 
Tanggal	: 10-9-09 15:29

################################
*/
if(!class_exists("executionTime"))
{
	
	
	class executionTime
	{
		
//------------------------------

		var $_waktuStart= array();
		var $_waktuStop= array();
		var $_lama= array();
		var $_microtimeStart= array();
		var $_microtimeStop= array();
		var $_modeLog;
		var $_limitLog;

//------------------------------

		public function __construct($ket="",$limitLog=10,$modeLog=true)
			{	
				if($ket=="")
				{
					$ket="helmianwarnurmahfudhohsalwaaurelliaanwar";
				}

				$this->_waktuStart["$ket"]=date("Y-m-d H:i:s");						
				$this->_microtimeStart["$ket"]=microtime(true);
				$this->_limitLog=$limitLog;
				$this->_modeLog=$modeLog;					
			}

//------------------------------
		function start($ket="")
			{								
				if($ket=="")
				{
					$ket="helmianwarnurmahfudhohsalwaaurelliaanwar";
				}

				$this->_waktuStart["$ket"]=date("Y-m-d H:i:s");						
				$this->_microtimeStart["$ket"]=microtime(true);
										
			}
//------------------------------
		function stop($ket="")
			{
				if($ket=="")
				{
					$ket="helmianwarnurmahfudhohsalwaaurelliaanwar";
				}

				$this->_waktuStop["$ket"]=date("Y-m-d H:i:s");						
				$awal=$this->_microtimeStart["$ket"];
				$akhir=$this->_microtimeStop["$ket"]=microtime(true);
				$lama=$akhir-$awal;
				
				$limitLog=$this->_limitLog;
				$modeLog=$this->_modeLog;

				if(($lama>=$limitLog) && ($modeLog==true))
				{
					$this->tulisFile($lama,$ket);
				}

				return $lama;
												
			}
//------------------------------
		function tulisFile($lama="",$ket)
			{	
			global $PHP_SELF;
			global $usrtmp;

				$content=$PHP_SELF."	$lama	".USER_IP_ADDRESS."	".$usrtmp["id_dd_user"]."	".date("Y-m-d H:i:s")."	".$this->_waktuStart["$ket"]."	".$this->_waktuStop["$ket"]."\n";
				$handle = fopen(WWWROOT."/_log/executionTime/executionTimeLog".date("Ym").".txt", "a+");
				fwrite($handle,$content);
				fclose($handle);

				
			}
	}
}

/*
cara penggunaan :

$hitung=new executionTime();

 --- coding
 --- coding
 --- coding
 --- coding
 --- coding

$lamanya=$hitung->stop();

echo $lamanya;

*/
?>