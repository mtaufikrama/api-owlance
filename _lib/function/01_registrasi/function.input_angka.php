<?
function input_angka($mode="") {
	?>onkeypress="javascript:if (event.keyCode > 57 || ((event.keyCode < 48) && (event.keyCode != 46) 
	<? if ($mode!="0") {?> && (event.keyCode !=44)<? if ($mode=="1"){?> && (event.keyCode !=45) <?} }?>)) event.returnValue = false;" onkeyup="var str=this.value;
<?}?>