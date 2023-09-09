<?
function tgltominute($a= "")
{
	global $db;
	$b=$db->UserTimeStamp($a,"Y-m-d H:i:s");
   list ($fulltgl, $wkt) = split ('[ ]',$b);
   if(strlen($wkt)=="60")
	{
   $wkt=substr($wkt, 3, -3); // jika pake sql_server
	}
   return $wkt;
}
?>