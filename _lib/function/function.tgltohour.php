<?
function tgltohour($a= "")
{
	global $db;
	$b=$db->UserTimeStamp($a,"Y-m-d H:i:s");
   list ($fulltgl, $wkt) = split ('[ ]',$b);
   if(strlen($wkt)=="12")
	{
   $wkt=substr($wkt, 0, -4); // jika pake sql_server
	}
   return $wkt;
}
?>