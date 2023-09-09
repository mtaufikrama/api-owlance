<?
if (!function_exists("dicetak_oleh")) {
	function dicetak_oleh($tampil_pa_nggak=true,$lebar_report="650",$posisi_report="300",$adaTag="1"){
		global $db;
		global $loginInfo;

		if ($tampil_pa_nggak==true){
		?>
		<div style="width:<?=$lebar_report?>px;">
			<div style="text-align:right;padding-left:<?=$posisi_report?>px">
				<? if ($adaTag==1){?> Dicetak Oleh : <?=$loginInfo["nama_user"]?>,<?=date("d-m-Y H:i:s")?> <?}?>Averin SIRs
			</div>
		</div>
		<?
		}
	}
}
?>