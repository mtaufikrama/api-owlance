<div id="isiUtama">
	<div id="headNamaPerusahaan">
		<?=$nama_perusahaan?>
	</div>
	<div id="headAlamat">
		<?=$alamat?><br/><?=$telpon?>&nbsp;&nbsp;(HUNTING)&nbsp;&nbsp;FAX.<?=$fax?>
	</div>
	<div id="headTracer">
		TRACER
	</div>
	<hr style="width:95%;border:1px solid black"/>
	<div style="content" style="padding-left:10px">
		<table cellspacing="0" cellpadding="0" width="70%" align="left">
			<tr>
				<td width="120" class="fieldname">No Rekam Medis</td>
				<td class="isiname">: <?=$no_mr?></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td width="120" class="fieldname">Nama Pasien</td>
				<td class="isinameBig">: <?=$nama_pasien?></td>
			</tr>
			<tr>
				<td width="120" class="fieldname">Nama Keluarga</td>
				<td class="isiname">: <?=$nama_kel_pasien?></td>
			</tr>
			<tr>
				<td width="120" class="fieldname">Agama</td>
				<td class="isiname">: <?=$agama?></td>
			</tr>
			<tr>
				<td width="120" class="fieldname">Nasabah</td>
				<td class="isiname">: <?=$nasabah?></td>
			</tr>
			<tr>
				<td width="120" class="fieldname">Bagian / Ruang</td>
				<td class="isiname">: <?=$nama_bagian?></td>
			</tr>
			<tr>
				<td width="120" class="fieldname">Nama Dokter</td>
				<td class="isiname">: <?=$nama_dokter?></td>
			</tr>
			<tr>
				<td width="120" class="fieldname">Tanggal</td>
				<td class="isiname">: <?=$nama_hari[date("w")]?>,<?=date2str($tgl_jam_masuk)?></td>
			</tr>
			<tr>
				<td width="120" class="fieldname">Jam</td>
				<td class="isiname">: <?=$jam_masuk?></td>
			</tr>
			<tr>
				<td width="120" class="fieldname">Petugas</td>
				<td class="isiname">: <?=$nama_user?></td>
			</tr>
			<?if($pasien!=""){?>
			<tr>
				<td width="120" class="fieldname">Pasien</td>
				<td class="isiname">: <?=$pasien?></td>
			</tr>
			<?}?>
		</table>
	</div>
</div>
