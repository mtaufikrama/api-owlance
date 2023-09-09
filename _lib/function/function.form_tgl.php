<?
function form_tgl($txt_nama="txt_tgl",$default="",$disabled="")
{
?>
<select name="<?= $txt_nama?>" <?=$disabled?>>
			  <?
			  
			  if($default!=""):
			   $tgl_patokan=$default;
			  elseif($$txt_nama!=""):
			   $tgl_patokan=$$txt_nama;
			  else :
				$tgl_patokan=date("d");
			  endif;
			 
			  for ($i=1;$i<=31;$i++)
			  {
			  ?>
               <option value="<?echo $i?>" <? if ($i==$tgl_patokan) echo 'selected'?>><?echo $i?></option>
               <?
			  } 
			  ?>
             
              </select>
<?
}
?>