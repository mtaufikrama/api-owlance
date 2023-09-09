<?
if (!function_exists("verticaltext")) {

function verticaltext($string)
{
       $tlen = strlen($string);
       for($i=0;$i<$tlen;$i++)
       {
            $vtext .= substr($string,$i,1)."<br />";  
       }
       return $vtext;
}
}
?>