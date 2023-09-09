<?
function form_bln($txt_nama="txt_bln",$default="",$disabled="",$mode="")
{
?>
<select name="<?=$txt_nama?>" size="1" <?=$disabled?> >
			  <?
			  $nama_bulan=array("Jan","Feb","Mar","Apr","Mei","Jun","Jul","Agt","Sep","Okt","Nov","Des");

			if($default!=""):
			   $bln_patokan=$default;
			elseif($$txt_nama!=""):
			   $bln_patokan=$$txt_nama;
			else :
				$bln_patokan=date("n");
			endif;

			if($mode==""):
				for ($i=1;$i<=12;$i++)
				{
			  ?>
			  
                <option value="<? echo $i?>" <? if ($bln_patokan==$i) echo 'selected'?> ><?echo $nama_bulan[$i-1]?></option>
               
				<?}?>
              </select>
<?
			else :
			for ($i=1;$i<=12;$i++)
				{
 ?>
			  
                <option value="<? echo $i?>" <? if ($bln_patokan==$i) echo 'selected'?> ><?echo $i?></option>
               
				<?}?>
              </select>
<?
			
			endif; // end of if($mode==""):
}
?>