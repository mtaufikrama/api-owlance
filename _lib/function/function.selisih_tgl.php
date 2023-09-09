<?
 function selisih_tgl($interval,$dateTimeBegin,$dateTimeEnd) {
        //Parse about any English textual datetime
        //$dateTimeBegin, $dateTimeEnd
        $dateTimeBegin=strtotime2($dateTimeBegin);
        if($dateTimeBegin === -1) {
          return("..begin date Invalid");
         }
        $dateTimeEnd=strtotime2($dateTimeEnd);
        if($dateTimeEnd === -1) {
          return("..end date Invalid");
         }
        $dif=$dateTimeEnd - $dateTimeBegin;
        switch($interval) {
          case "s"://seconds
               return($dif);
          case "n"://minutes
               return(floor($dif/60)); //60s=1m
          case "h"://hours
               return(floor($dif/3600)); //3600s=1h
          case "d"://days
               return(floor($dif/86400)); //86400s=1d
          case "ww"://Week
               return(floor($dif/604800)); //604800s=1week=1semana
          case "m": //similar result "m" dateDiff Microsoft
               $monthBegin=(date("Y",$dateTimeBegin)*12)+
                 date("n",$dateTimeBegin);
               $monthEnd=(date("Y",$dateTimeEnd)*12)+
                 date("n",$dateTimeEnd);
               $monthDiff=$monthEnd-$monthBegin;
               return($monthDiff);
          case "yyyy": //similar result "yyyy" dateDiff Microsoft
               return(date("Y",$dateTimeEnd) - date("Y",$dateTimeBegin));
          default:
               return(floor($dif/86400)); //86400s=1d
         }
       }

?>