<?
function isi_hidden($yg_tidak="")
{
	global $HTTP_POST_VARS,$HTTP_GET_VARS;

reset ($HTTP_POST_VARS);
$nama_var="";
$yg_gak_masuk=split(",",$yg_tidak);
$banyak_cekfield=count($yg_gak_masuk);


while (list ($key, $val) = each ($HTTP_POST_VARS)) 
	{
	$cek_ada=0;
	for($helmi1=0;$helmi1<$banyak_cekfield;$helmi1++)
		{
			if($yg_gak_masuk[$helmi1]==$key):
				$cek_ada++;
			endif;
		} // end of for

		if($cek_ada<1)
		{
			?>
		<INPUT TYPE="hidden" name="<?echo $key?>" value="<?echo $val?>">
	<?
			}

	} // end of while
reset ($HTTP_GET_VARS);
while (list ($kuncinya, $isinya) = each ($HTTP_GET_VARS)) 
	{
	$cek_ada=0;
    for($helmi1=0;$helmi1<$banyak_cekfield;$helmi1++)
		{
			if($yg_gak_masuk[$helmi1]==$kuncinya):
				$cek_ada++;
			endif;
		} // end of for

		if($cek_ada<1)
		{
			?>
		<INPUT TYPE="hidden" name="<?echo $kuncinya?>" value="<?echo $isinya?>">
			<?
			}

	} // end of while

} # end of function isi_hidden

?>