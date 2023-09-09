<?
function 
max_kode_number_hr($tabel,$field,$syarat=""){
global $db;
$cari= "SELECT 
           max($field) as kode
		 FROM
		   $tabel $syarat
		";
$res_cari = &$db_hr->Execute($cari);
$hasil = $res_cari->fields["kode"]+1;


return($hasil);
}
?>