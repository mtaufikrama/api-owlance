<?php
require_once("../_contrib/privyid/api_sign.php");
$sign=new sign();
$sign->debug=true;
$hasil=$sign->token();
print_r($hasil);
?>