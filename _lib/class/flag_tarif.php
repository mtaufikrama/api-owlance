<?
if(!class_exists("flag_tarif")){
	class flag_tarif{
		function flag_tarif($db,$kd_bagian,$flag_tarif){
			switch($flag_tarif){
				case="":
					$sqlplus="AND nama_tarif not like'%lama%'";
					break;
				case="0":
					 $sqlplus="AND nama_tarif like'%lama%'";
					break;
				case="1":
					$sqlplus="AND nama_tarif not like'%lama%'";
					break;

			}
			switch($kd_bagian){
				$kodeBagian = substr($kd_bagian,0,4);
			}
			$sql_tin="SELECT * FROM mt_master_tarif where kode_bagian='030001' AND kode_tindakan IS NOT NULL";

		}
	}
}

?>