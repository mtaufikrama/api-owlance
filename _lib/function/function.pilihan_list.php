<?php
function pilihan_list($sql_f,$option_tampil_f,$isi_option_f,$nilai_1_f="",$nilai_2_f="",$tambahan="")
{
	global $db;
	
	$res_tabel_f_h = &$db->Execute($sql_f);
while($res_tabel_f=$res_tabel_f_h->FetchRow())
			{
	if(($nilai_1_f!="")and($nilai_2_f!=""))
				{
				if($res_tabel_f[$nilai_1_f]==$nilai_2_f)
					{
					$selected_f="selected";
					}
					else
					{
					$selected_f="";
					} # end of if odbc_result;
				}
				else
				{
				$selected_f="";
				} #end of $nilai_1_f;
?>
<option value="<?echo $res_tabel_f[$isi_option_f] ?>" <?echo $selected_f?>>
<?php
$cek_field=split(",",$option_tampil_f);
$banyak_cekfield=count($cek_field);
for ($i=0; $i<$banyak_cekfield; $i++)
	{	
	$tampilin_f=$cek_field[$i];
	if($i==1)
		{
	echo "...(".$res_tabel_f[$tampilin_f].")";
		}
		else
		{
	echo $res_tabel_f[$tampilin_f]." ";
		}
	};
?>	
<?php
if($tambahan=="2"):

global $ngecek_dikit_ana_beli;
	
	if($ngecek_dikit_ana_beli!="wis_euy"):
	?>
	<SCRIPT LANGUAGE="JavaScript"><!-- 
		var helmi_anwar=new Array();//--></SCRIPT>
	<?php
		$ngecek_dikit_ana_beli="wis_euy";
	endif;
?>
<SCRIPT LANGUAGE="JavaScript"><!-- 
	helmi_anwar["<?echo $res_tabel_f[$isi_option_f]?>"]="<?= $res_tabel_f[$tampilin_f]?>";//--></SCRIPT>
<?php
endif;

?>
</option>
<?php			}
#end of while odbc_fetch_row;
}
#end of function pilihan_list;
?>