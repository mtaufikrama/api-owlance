<?
function 
max_kode_text($tabel,$field,$syarat=""){

global $db;

$cari= "SELECT 
           count($field) as kode
		 FROM
		   $tabel $syarat
		";
$res_cari=&$db->Execute($cari);
$hasil = $res_cari->fields["kode"];
$hasil=$hasil=1;
$cari2="SELECT 
           ($field) as kode
		 FROM
		   $tabel $syarat
		order by $field DESC
		";
$res_cari2 = &$db->Execute($cari2);
$hasil2 = $res_cari2->fields["kode"]+1;

if($hasil2>$hasil):
$hasil=$hasil2;
endif;



$cek="ada";
while($cek=="ada")
	{
	$selidiki="select $field as ceknya from $tabel where $field='$hasil'";
	$res_selidik=&$db->Execute($selidiki);
	$cek_hasil=$res_selidik->fields["ceknya"];
	
	if($cek_hasil==$hasil)
		{
		$hasil=$hasil+1;
		$cek="ada";
		}
	else
		{
		$cek="Tidak ada boooooo ";
		}

	}


return($hasil);
}
#=============================================================================================
?>