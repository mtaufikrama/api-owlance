<?
function selisih_jam($time_in,$time_out)
{
	ereg ("([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})",$time_in,$in);
    ereg ("([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})",$time_out,$out);
    $thn = date("Y");
	$month = date("m");
	$date_now = "23";
	$date_d = "22";

    $sec_in = mktime($in[1],$in[2],$in[3],$month,$day_d,$thn);
    $sec_out = mktime($out[1],$out[2],$out[3],$month,$day_now,$thn);
    
	if(($sec_out - $sec_in) <= 24):
	 $a =true;
	else:
	 $a =false;
	endif;

    return $a; 
}
?>