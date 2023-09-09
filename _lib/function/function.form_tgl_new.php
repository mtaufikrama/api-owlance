<?
function form_tgl_new($txt_nama="txt_tgl",$default="",$disabled="")
{
if($default!=""):
?>
<div class="kalender"><script>DateInput('<?=$txt_nama?>',true,'YYYYMMDD','<?=$default?>')</script></div>
<?
else:
?>
<div class="kalender"><script>DateInput('<?=$txt_nama?>',true,'YYYYMMDD')</script></div>
<?
endif;
}
?>
