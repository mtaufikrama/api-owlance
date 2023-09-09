<?
if (!function_exists("cek_hp")) { 
	function cek_hp($ts1, $ts2) {
	 /* 
	 $ts1 = "2007-01-05 10:30:45";
	 $ts2 = "2007-01-06 10:31:46";
	 echo date_diff_as_text($ts1, $ts2);
	 */

	 $ts1 = strtotime2($ts1);
	 $ts2 = strtotime2($ts2);
	 $diff = abs($ts1-$ts2);
	 
	 $sec_min = 60;
	 $sec_hour = $sec_min*60;
	 $sec_days = $sec_hour*24;
	 
	 $days = intval($diff/$sec_days);
	 $hours = intval($diff/$sec_hour)%24;
	 $minutes = intval($diff/$sec_min)%60;
	 $seconds = $diff%60;
	 
	 $result = (int)$days."-".(int)$hours."-".(int)$minutes."-".(int)$seconds;
	 return $result;
	}
}
?>