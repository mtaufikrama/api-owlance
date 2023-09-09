<?
function array2table($arr,$mode="0")
{
?>
	<style>
	td {	
		font: 11px/normal tahoma,verdana;
		margin:0px 0px 0px 0px;
		/*background-color:#F2F5FA;*/
		/*visibility:hidden;*/
		}
	</style>
<?
if($mode=="0")
	{
		$arr_trans=$arr;	
	}
elseif($mode=="1")
	{
		foreach ($arr as $xxx => $arr_yyy) 
		{
			foreach ($arr_yyy as $yyy => $isi_cell) {
				$arr_trans[$yyy][$xxx]=$isi_cell;
			}
		}
	}
	
if(is_array($arr_trans)){	
	echo "<TABLE align='center' border='1' cellpadding='3' cellspacing='0' width='95%'>";
	$nomernya=0;
	foreach ($arr_trans as $key => $value) 
	{
		if($nomernya==0)
		{
			?>
				<TR bgcolor='#99FF99'>
					<TD width="15"> <B>No.</B> </TD>						
					<? 
						if(is_array($value))
						{
							foreach ($value as $nama_field => $isi_field)
								{?>
							<TD align="center"> &nbsp;<B><?= strtoupper($nama_field);?></B>&nbsp; </TD>
								<?}
						}?>						
				</TR>
			<?
			$nomernya=$nomernya+1;
		}
		if($nomernya>0)
		{
				if(($nomernya % 2) == 0)
				{
					$bgcolor="#E5E5E5";
				}
				else
				{
					$bgcolor="#FDFDFD";
				}
					
					

					echo "<TR BGCOLOR='$bgcolor'>";
					echo "<TD width='15'> <B> $nomernya. </B> </TD>";	
				if(is_array($value))
				{
					foreach ($value as $nama_field => $isi_field) 
					{	
						?>	
						<TD><?=$isi_field?>&nbsp;</TD>
						<?		
					}
				}
					echo "</TR>";
				$nomernya=$nomernya+1;
		}
	}
	echo "</TABLE>";
	
}


return $hasil;
}

?>