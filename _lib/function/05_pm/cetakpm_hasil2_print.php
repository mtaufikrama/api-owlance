<?
	session_start();
	require_once("../_lib/function/db.php");
	loadlib("function","function.olah_tabel");
	loadlib("function","function.datetime");
	loadlib("function","function.variabel");
	loadlib("function","function.dicetak_oleh");
	//$db->debug=true;	
	
	$r=read_tabel("dd_konfigurasi","*");
	while ($konf=$r->FetchRow()) {
		$nama_perusahaan=$konf["nama_perusahaan"];
		$alamat=$konf["alamat"];
		$kota=$konf["kota"];
		$kode_pos=$konf["kode_pos"];
		$propinsi=$konf["propinsi"];
		$telpon=$konf["telpon"];
		$fax=$konf["fax"];
		$logo_small=$konf["logo_small"];
		$html_title=$konf["html_title"];
	}

	/*
	Catatan :

	Ukuran kertas yang bisa digunakan :
	A4 Portrait			: A4P
	A4 Landscape		: A4L
	A3 Portrait			: A3P
	A3 Landscape		: A3L
	A2 Portrait			: A2P
	A2 Landscape		: A2L
	Letter Portrait		: LtP
	Letter Landscape	: LtL
	Legal Portrait		: LgP
	Legal Landscape		: LgL

	Ukuran margin yang bisa digunakan (dalam cm) :
	0.1 cm, 0.2 cm s/d ..... 
	Tergantung dukungan printer (rekomendasi : 1 cm).

	...Programming should be fun ;-P
	...Bowie @ 2005
	*/
	$title_laporan = "Hasil Pemeriksaan Pasien";
	$paperSize = "A4L";
	$marginSize = 1;

	// BEGIN : Main SQL is here.......................
		
	
	//$sql="SELECT * FROM pm_hasilpasien_v where kode_penunjang=".$kode_penunjang;
	
	if ($txt_kategori==1){
		$sql="SELECT * FROM pm_pemeriksaanpasienluar_v where kode_penunjang=".$kode_penunjang;
	} else {
		$sql="SELECT * FROM pm_pemeriksaanpasien_v where kode_penunjang=".$kode_penunjang;
	}
	//echo $sql;
	// END : Main SQL is here.......................
	$_oR =& $db->Execute($sql);

	$aAccLab =array();
	$aKelamin =array();
	$aKd_penunj =array();
	$aMR =array();
	$aResume =array();
	$aNamaTindakan=array();
	$aKodeTarif=array();
	$aTgl=array();

	while($oRS=$_oR->Fetchrow()):
		$aID=$oRS["kode_trans_pelayanan"];
		$aNamaTindakan[$aID]=$oRS["nama_tindakan"];
		$aMR[$aID]=$oRS["no_mr"];
		$aKd_penunj[$aID]=$oRS["kode_penunjang"];
		$aKelamin[$aID]=$oRS["jen_kelamin"];
		$aResume[$aID]=$oRS["catatan_hasil"];
		$aKodeTarif[$aID]=$oRS["kode_tarif"];
		$aTgl[$aID]=$oRS["tgl_transaksi"];
		$aDrPengirim[$aID] =$oRS["dr_pengirim"];
		$aDrR[$aID] = $oRS["kode_dokter1"];
	endwhile;

	$nama_bagian=baca_tabel("mt_bagian","nama_bagian","where kode_bagian='".$loginInfo["kode_bagian"]."'");

	$txt_bagian=substr($loginInfo["kode_bagian"],1,3);
	$txt_bagian=$txt_bagian*1;


	list ($sKey, $sVal) = each ($aMR);
	$no_mr=$sVal;
	list ($sKey, $sVal) = each ($aTgl);
	$tgl_transaksi=$sVal;
	list ($sKey, $sVal) = each ($aDrPengirim);
	$dr_pengirim = $sVal;
	list ($sKey, $sVal) = each ($aDrR);
	$kode_dr1 = $sVal;
	if (trim($kode_dr1)!=""){
		$nama_dokter_r = baca_tabel("mt_dokter_v","nama_pegawai","WHERE kode_dokter=$kode_dr1");
	} 
	if ($txt_kategori==1){
		$sql_plu = "SELECT * FROM mt_pasien_penunjang WHERE no_pm='$noMr'";
		$hasil_plu =& $db->Execute($sql_plu);
		
		$umur = $hasil_plu->fields["tgl_lahir"];
		$nama_pasien = $hasil_plu->fields["nama_pasien"];
	} else {
		$umur = baca_tabel("mt_master_pasien","tgl_lhr","where no_mr='".$no_mr."'");
		$nama_pasien = baca_tabel("mt_master_pasien","nama_pasien","where no_mr='".$no_mr."'");
	}

	

	//require_once("../_inc/tpl_incReportA.php"); 
?>				
<html>

<head>
	<title><?= $html_title?></title>
	<? include("../_inc/tpl_incHtmlHead.php"); ?>
</head>

<body>
	
	<div id="topLayer" class="loading"></div>

	<!-- ========================================================================================= -->
	<div id="isiAtas">

		<div id="barPrint">
			<span class="judul"><b>HASIL PEMERIKSAAN <?=strtoupper($nama_bagian)?></b></span>
			<button class="submit01" onclick="window.close()">Tutup</button>
			<button class="submit01" onclick="window.print()">Cetak</button>
		</div>

	</div>
	<!-- ========================================================================================= -->

	<!-- ========================================================================================= -->
	<div id="isiUtama">
		<span id="" style="width:650px;">
			<div style="border:1px solid black;width:600px;height:50px">
				<table cellspacing="0" cellpadding="0" width="100%">
					<tr>
						<td width="30%" style="padding:10px 10px 10px 10px;border-right:1px solid black;text-align:center">
							<img src="<?= $logo_small?>" />
						</td>
						<td width="70%" style="text-align:center">
							<span style="font:bold 14px arial">
								HASIL PEMERIKSAAN <?=strtoupper($nama_bagian)?><br/><?= $nama_perusahaan?>
							</span>
						</td>
					</tr>
				</table>
			</div>
			<div style="border-bottom:1px solid black;border-left:1px solid black;border-right:1px solid black;width:600px;height:100px;padding:5px">
				<table cellspacing="0" cellpadding="5" width="100%">
					<tr class="">
						<td width="">No.Rekam Medik</td>
						<td width="5">:</td>
						<td><? echo $no_mr?></td>
					</tr>
					<tr class="">
						<td width="">Nama Pasien</td>
						<td>:</td>
						<td><? echo $nama_pasien ?>&nbsp;</td>
					</tr>
					<tr class="">
						<td width="">Umur / Jenis Kelamin</td>
						<td>:</td>
						<td><?=umur($umur); ?><span class="txt-super"> th</span>&nbsp;/&nbsp;<?=$aKelamin[$aID]=="P" ? "Perempuan" : "Laki-laki"?></td>
					</tr>
					<tr class="">
						<td width="20%">Tanggal</td>
						<td>:</td>
						<td><?=date2str($tgl_transaksi)?></td>
					</tr>
					<tr class="">
						<td width="20%">Dokter Pengirim</td>
						<td>:</td>
						<td><?=$dr_pengirim=="0" ? "-" : $dr_pengirim ?>&nbsp;</td>
					</tr>
				</table>
			</div>
			<div style="width:600px;height:300px;">
				<table border="1" bordercolor="#330000" width="100%" cellpadding="2" cellspacing="0">
					<tbody>
						<tr class="" align="center">
							<td width="25" rowspan="1" colspan="1">No.</td>
							<td rowspan="1" colspan="1">Pemeriksaan</td>
							<?
							if($txt_bagian<502)
							{
							?>
							<td rowspan="1" colspan="1">Hasil</td>
							<td rowspan="1" colspan="1">Nilai Normal</td>
							<td rowspan="1" colspan="1">Satuan</td>
							<td rowspan="1" colspan="1">Keterangan</td>
							<?
							}else{?>
							<td rowspan="1" colspan="1">Kesimpulan</td>
							<td rowspan="1" colspan="1">Kesan</td>
							<?
							}?>
							
						</tr>
						<tr class="" align="center">
							<td>1</td>
							<td>2</td>
							<?
							if($txt_bagian<502)
							{
							?>
							<td>3</td>
							<td>4</td>
							<td>5</td>
							<td>6</td>
							<?
							}else{?>
							<td>3</td>
							<td>4</td>
							<?
							}?>
							
							
						</tr>
						<?
						//	$i = 0;
						//	while ($tampil = $hasily->FetchRow()) {
						//	$i++;

						//	$kode_tarif=$tampil["kode_tarif"];
						//	$nama_tindakan=$tampil["nama_tindakan"];

						$no=0;
						$banyak_baris=0;

						while (list ($sKey, $sVal) = each ($aKodeTarif)) 
						{
							$no++;
							$kode_tarif=$sVal;
							$kode_trans_pelayanan=$sKey;
							list ($sKey, $sVal) = each ($aKelamin);
							$jen_kelamin=$sVal;
							list ($sKey, $sVal) = each ($aResume);
							$resume=$sVal;
							list ($sKey, $sVal) = each ($aNamaTindakan);
							$nama_tindakan=$sVal;

							?>
							<?
							if($txt_bagian<502)
							{
							?>
							<tr class="contentTable">
							<td align="right" width="25"><?=  $no  ?>.</td>
							<td align="left"><?=strtoupper($nama_tindakan)?>&nbsp;</td>
							<td align="left">&nbsp;</td>
							<td align="left">&nbsp;</td>
							<td align="left">&nbsp;</td>
							<td align="left">&nbsp;</td>
							</tr>
							<?
							}?>
							
							<?
							//$sQ = "SELECT * FROM pm_hasilpasien_v where kode_trans_pelayanan=".$kode_trans_pelayanan;
							if($txt_kategori==1)
							{
								$sQ = "SELECT * FROM pm_hasilpasienluar_v where kode_penunjang=".$kode_penunjang." and kode_tarif=".$kode_tarif;
							}else
							{
								$sQ = "SELECT * FROM pm_hasilpasien_v where kode_penunjang=".$kode_penunjang." and kode_tarif=".$kode_tarif;
							}
							$_hasil=&$db->Execute($sQ);

							while($hasil=$_hasil->Fetchrow())
							{

								$banyak_baris++;

								$kode_mt_hasilpm=$hasil["kode_mt_hasilpm"];
								$nama_pemeriksaan=$hasil["nama_pemeriksaan"];

								$standar_wanita=$hasil["standar_hasil_wanita"];
								$standar_pria=$hasil["standar_hasil_pria"];
								$satuan=$hasil["satuan"];

								$hasilnya=$hasil["hasil"];
								$keterangan=$hasil["keterangan"];
								$hasilnya = ereg_replace("[\]","",$hasilnya);
								if ($jen_kelamin == "L") 
								{
									if (!$sNilaiNormal = $standar_pria ) {
										$sNilaiNormal = " ";
									}
								} else {
									if (!$sNilaiNormal = $standar_wanita ) {
										$sNilaiNormal = " ";
									}
								}
								
								if (!$sSatuan = $satuan ) {
												$sSatuan = " ";

								}
						
						if(trim($hasilnya)<>"")
						{
						?>
						<tr class="">
							
							<?
							if($txt_bagian<502)
							{
							?>
							<td align="right" width="25">&nbsp;</td>
							<td align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$nama_pemeriksaan?>&nbsp;</td>
							<td align="left"><?=$hasilnya?>&nbsp;</td>
							<td align="left"><?=$sNilaiNormal?>&nbsp;</td>
							<td align="left"><?=$satuan?>&nbsp;</td>
							<td align="left"><?=$keterangan?>&nbsp;</td>
							<?
							}else{?>
							<td align="right" width="25"><?=$no?>&nbsp;</td>
							<td align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$nama_pemeriksaan?>&nbsp;</td>
							<td align="left"><?=$hasilnya?>&nbsp;</td>
							<td align="left"><?=$keterangan?>&nbsp;</td>
							<?
							}?>
						</tr>
						<?
						}  //trim hasilnya
						?>
						<?
							}
						}
						?>
						
						<?
							//	$i++;
							//}
						?>
						<tr align=left>
						<td colspan=6 align=left valign=top width="15%">&nbsp;&nbsp;&nbsp;
						</td>
						</tr>
						<tr align=left>
						<td colspan=6 align=left valign=top width="15%"><B>Catatan : </B><BR>
						<?echo $resume;?>&nbsp;
						</td>
						</tr>
						<!-- <tr align=left>
						<td colspan=6 align=left valign=top width="15%"><B>Pemeriksa : </B><BR>
						&nbsp;
						</td>
						</tr> -->
					</tbody>
				</table>
				<div style="border-left:1px solid black;border-bottom:1px solid black;border-right:1px solid black;width:600px;height:100px;padding-top:15px">
					<div style="position:absolute;left:400px;text-align:center">
						( Nama Dokter <?=$nama_bagian?> )<br/><br/><br/><br/><?=$nama_dokter_r?>
					</div>
				</div>
				<?dicetak_oleh(true,"600","300")?>
			</div>
			
			<?	//require_once("../_inc/tpl_incReportB.php"); ?>
		<br><br>
		<?//echo date("d-m-Y H:i:s")?>&nbsp;<?//echo $us?>
		<?//require_once("../_inc/tpl_incReportB.php"); ?>
		</span>
	</div>

<!-- ############################################################################################# -->
<script language="JavaScript" type="text/javascript">

window.onload = function()
{
	initHalaman()
}

</script>

</body>
</html>