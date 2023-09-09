<?
if($cek_abcde_f=='BETUL')
{
include "lib-head.php";


$cek_field=split(",",$ket_f);

$banyak_cekfield=count($cek_field);

?>
<TABLE height="350" width="100%" align="center">
<TR>
	<TD><CENTER>Terdapat <?echo $banyak_cekfield?> form yang belum diisi :</CENTER><BR><BR>

<CENTER>
<?
for ($i=0; $i<$banyak_cekfield; $i++)
	{	
      ?>

	- <?echo $cek_field[$i]?><BR>
	<?
	} # end of for $i
	?>
</CENTER>
<BR><BR>
<CENTER><A HREF="javascript:history.go(-2)" class="box02"><< BACK >></A></CENTER></TD>
</TR>
</TABLE>
<?

include "lib-foot.php";

}
else
{

#***************************************************************************************************

function periksa_variabel($nama_var_f,$ket_var_f="",$header_atas_f="",$header_bawah_f="")
{
$cek_field=split(",",$nama_var_f);
if($ket_var_f!='')
	{
	$nama_field=split(",",$ket_var_f);
	};
$banyak_cekfield=count($cek_field);

for ($i=0; $i<$banyak_cekfield; $i++)
	{	
	global $$cek_field[$i];
	};

$yg_kosong=0;

for ($i=0; $i<$banyak_cekfield; $i++)
	{	
      if($$cek_field[$i]=='')
		{
			if($ket_var_f!='')
			{
			$ket_f=$ket_f.$nama_field[$i].",";
			}
			else
			{
			$ket_f=$ket_f.$cek_field[$i].",";
			}
			
			$yg_kosong++;

		}#end of if $$cek_field;

	
	} # end of for $i

$ket_f=substr ($ket_f,0,-1);

if ($yg_kosong>0)
	{
	?>
		<HTML><HEAD><TITLE> PERIKSA VARIABEL</TITLE></HEAD><BODY onload=javascript:location.href='../lib/periksa_variabel.php?cek_abcde_f=BETUL&ket_f=<?echo urlencode($ket_f);?>&head=<?echo urlencode($header_atas_f);?>&foot=<?echo urlencode($header_bawah_f);?>'> 

</BODY>
</HTML>
	<?
	exit;
	}
return "OKE";

}#end of function periksa_variabel;

#***********************************************************************************************

function kasih_nilai($nama_var_f)
{
/*$cek_field=split(",",$nama_var_f);

$banyak_cekfield=count($cek_field);

for ($i=0; $i<$banyak_cekfield; $i++)
	{	
	global $$cek_field[$i];
	};

for ($i=0; $i<$banyak_cekfield; $i++)
	{	
      if($$cek_field[$i]=='')
		{
			$$cek_field[$i]=0;
		}#end of if $$cek_field;

	
	} # end of for $i;
*/

} # end of function kasih_nilai;

#************************************************************************************************

function lihat_nilai($nama_var_f)
{
$cek_field=split(",",$nama_var_f);

$banyak_cekfield=count($cek_field);
for ($i=0; $i<$banyak_cekfield; $i++)
	{	
	global $$cek_field[$i];
	};

for ($i=0; $i<$banyak_cekfield; $i++)
	{	
      echo "<CENTER>".$cek_field[$i]." = ".$$cek_field[$i]." <br> </CENTER>";
		
	} # end of for $i;


} # end of function kasih_nilai;


}# end of if abcd_e_f='betul';
?>