<?
function form_thn($txt_nama="txt_thn",$default="",$range_mundur="10",$range_maju="10",$disabled="")
{
?>
	<select id="<?= $txt_nama?>" name="<?= $txt_nama?>" size="1" <?=$disabled?> >
                <?
			if($default!=""):
				$thn_patokan=$default;
			elseif($$txt_nama!=""):
				$thn_patokan=$$txt_nama;
			else :
				$thn_patokan=date("Y");
			endif;

				
				$mulai=date("Y")-$range_mundur;
				$akhir=date("Y")+$range_maju;
				for($i=$mulai; $i<=($akhir); $i++){
					
				?>
				<option value="<?= $i?>" <? if($i==$thn_patokan)echo "selected"?>><?= $i?></option>	
				<?
	} ?> 
              </select>
<?
}
?>