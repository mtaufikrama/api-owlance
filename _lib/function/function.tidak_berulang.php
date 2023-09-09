<?
function tidak_berulang($value=""){
	$variabel=split(",",$value);

	foreach ($variabel as $kunci => $nilai) 
	{
		global $$nilai;
		$nilai2=$nilai."_lama";
		global $$nilai2;

		if ($$nilai!=$$nilai2):
				$$nilai2=$$nilai;
			else:
				$$nilai="";
			endif;
	}
}
?>