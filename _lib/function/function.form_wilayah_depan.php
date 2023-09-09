<?
require_once("db_login.php");
loadlib("function","function.olah_tabel");
loadlib("function","function.mandatory");
/*
PUNK-15/06/2012-11:12:36 
BASE DEVELOPMENT: framework RSUD averin
DEPENDENCIES:
1. jquery.js
2. jquery.autocomplete.js
3. jquery.autocomplete.css
4. indicator.gif
5. main.js
6. dc_wilayah_v (DATABASE VIEW)
7. icokecil_tambah.gif
 */
switch($param){
	case "AUTOCOMPLETE":
	
		$filter = strtoupper(trim($_GET["q"]));

		switch ($tipe_cari){
			case "PROPINSI":
				$sql = "SELECT nama_propinsi,id_dc_propinsi FROM dc_propinsi WHERE id_dc_negara=1 AND UPPER(nama_propinsi) LIKE '%".$filter."%' ORDER BY nama_propinsi";
			break;
			case "KOTA":
				if($id_dc_propinsi!='')$sql_plis="id_dc_propinsi=".$id_dc_propinsi." AND";
				//$sql = "SELECT (CONCAT(nama_kota,(case when  flag_kab = 0  then 'kab. '  else 'kota ' end))) as nama_kota, id_dc_kota FROM dc_kota WHERE ".$sql_plis." UPPER(nama_kota) LIKE '%".$filter."%' ORDER BY nama_kota";
				$sql = "SELECT (nama_kota+''+(case when  flag_kab = 0  then 'kab. '  else 'kota ' end)) as nama_kota, id_dc_kota FROM dc_kota WHERE ".$sql_plis." UPPER(nama_kota) LIKE '%".$filter."%' ORDER BY nama_kota";
				

			break;
			case "KECAMATAN":
				if($id_dc_kota!='')$sql_plis="id_dc_kota=".$id_dc_kota." AND";
				$sql = "SELECT nama_kecamatan,id_dc_kecamatan FROM dc_kecamatan WHERE ".$sql_plis." UPPER(nama_kecamatan) LIKE '%".$filter."%' ORDER BY nama_kecamatan";
			break;
			case "KELURAHAN":
				if($id_dc_kecamatan!='')$sql_plis="id_dc_kecamatan=".$id_dc_kecamatan." AND";
				$sql = "SELECT nama_kelurahan,id_dc_kelurahan,kode_pos FROM dc_kelurahan WHERE ".$sql_plis." UPPER(nama_kelurahan) LIKE '%".$filter."%' ORDER BY nama_kelurahan";
			break;
		}

		$hasil =& $db->Execute($sql);
		$cnt_sql = $hasil->RecordCount();

		if($cnt_sql > 0){

			while ($tampil=$hasil->FetchRow()) {
				$i++;
				$id_dc_negara		= $tampil["id_dc_negara"];
				$nama_negara		= $tampil["nama_negara"];
				$id_dc_propinsi		= $tampil["id_dc_propinsi"];
				$nama_propinsi		= $tampil["nama_propinsi"];
				$id_dc_kota			= $tampil["id_dc_kota"];
				$nama_kota			= $tampil["nama_kota"];
				$flag_kab			= $tampil["flag_kab"];
				$id_dc_kecamatan	= $tampil["id_dc_kecamatan"];
				$nama_kecamatan		= $tampil["nama_kecamatan"];
				$id_dc_kelurahan	= $tampil["id_dc_kelurahan"];
				$nama_kelurahan		= $tampil["nama_kelurahan"];
				$kode_pos			= $tampil["kode_pos"];

				switch ($tipe_cari){
					case "PROPINSI":
						echo "$nama_propinsi|$id_dc_propinsi\n";
					break;
					case "KOTA":
						echo "$nama_kota|$id_dc_kota\n";
					break;
					case "KECAMATAN":
						echo "$nama_kecamatan|$id_dc_kecamatan\n";
					break;
					case "KELURAHAN":
						echo "$nama_kelurahan|$id_dc_kelurahan|$kode_pos\n";
					break;
				}

			}

		} else {

			echo "-- Data Tidak Ditemukan --||".$_GET['q'];

		} //if($cnt_sql > 0){

	break; //END case "AUTOCOMPLETE":
	case "AJAX":

		switch($tipe_cari){
			case "PROPINSI":
				if(trim($filter)!=""){
					$sql_plas = "AND UPPER(nama_propinsi) = '".strtoupper(trim($filter))."'";
				} else {
					$sql_plas = "AND id_dc_propinsi=".$id_dc_propinsi;
				}
				$sql_plus = "WHERE id_dc_negara=1 ".$sql_plas." ORDER BY nama_kota";
			break;
			case "KOTA":
				if(trim($filter)!=""){
					$sql_plas = "AND UPPER(nama_kota) = '".strtoupper(trim($filter))."'";
				} else {
					$sql_plas = "AND id_dc_kota=".$id_dc_kota;
				}
				$sql_plus = "WHERE id_dc_negara=1 ".$sql_plas." ORDER BY nama_kecamatan";
			break;
			case "KECAMATAN":
				if(trim($filter)!=""){
					$sql_plas = "AND UPPER(nama_kecamatan) = '".strtoupper(trim($filter))."'";
				} else {
					$sql_plas = "AND id_dc_kecamatan=".$id_dc_kecamatan;
				}
				$sql_plus = "WHERE id_dc_negara=1 ".$sql_plas." ORDER BY nama_kelurahan";
			break;
			case "KELURAHAN":
				if(trim($filter)!=""){
					$sql_plas = "AND UPPER(nama_kelurahan) = '".strtoupper(trim($filter))."'";
				} else {
					$sql_plas = "AND id_dc_kelurahan=".$id_dc_kelurahan;
				}
				$sql_plus = "WHERE id_dc_negara=1 ".$sql_plas." ORDER BY nama_kelurahan";
			break;
		}

		$r_wilayah = read_tabel("dc_wilayah_v","*",$sql_plus);

		echo $tipe_cari;												//[0]
		echo "^";
		echo $nama_propinsi = $r_wilayah->fields["nama_propinsi"];		//[1]
		echo "^";
		echo $id_dc_propinsi = $r_wilayah->fields["id_dc_propinsi"];	//[2]
		echo "^";
		echo $nama_kota = $r_wilayah->fields["kota_kab"];				//[3]
		echo "^";
		echo $id_dc_kota = $r_wilayah->fields["id_dc_kota"];			//[4]
		echo "^";
		echo $nama_kecamatan = $r_wilayah->fields["nama_kecamatan"];	//[5]
		echo "^";
		echo $id_dc_kecamatan = $r_wilayah->fields["id_dc_kecamatan"];	//[6]
		echo "^";
		echo $nama_kelurahan = $r_wilayah->fields["nama_kelurahan"];	//[7]
		echo "^";
		echo $id_dc_kelurahan = $r_wilayah->fields["id_dc_kelurahan"];	//[8]
		echo "^";
		echo $kode_pos = $r_wilayah->fields["kode_pos"];				//[9]
		echo "^";
		echo $nama_kota = $r_wilayah->fields["nama_kota"];				//[10]

	break; //END case "AJAX":
	case "ADD_WILAYAH";

		switch($tipe_cari){
			case "PROPINSI":
				$judul="Propinsi";
				$atas="Negara"; 
			break;
			case "KOTA":
				$judul="Kota";
				$atas="Propinsi"; 
			break;
			case "KECAMATAN":
				$judul="Kecamatan";
				$atas="Kota"; 
			break;
			case "KELURAHAN":
				$judul="Kelurahan";
				$atas="Kecamatan"; 
			break;
		}
?>
<html>
	<head>
		<title>Averin Intranet Application Framework - Form Input DB</title>
		<? include(WWWROOT."/_inc/tpl_incHtmlHead.php"); ?>
	</head>
	<body scroll="no">
		<div id="topLayer" class="loading"></div>
		<!-- ========================================================================================= -->
		<div id="isiAtas">
			<div id="barJudul">Tambah&nbsp;<?=$judul?></div>
		</div>
		<!-- ========================================================================================= -->
		<div id="isiUtama">		
			<form method="post" name="PUNK" action="<?WWWROOT?>/_lib/function/function.form_wilayah_depan.php">
				<table cellpadding="0" cellspacing="0" class="formInput">
					<tr>
			<!-- --------------------------------------------------------------------------------- -->
						<td class="kiri">
							<table cellpadding="0" cellspacing="0">
								<tr>
									<td class="field"><?=$atas?></td>
									<td class="input"><?=$nama_cari?></td>
								</tr>
								<?if($tipe_cari=="KOTA"):?>
								<tr>
									<td class="field">Jenis&nbsp;<?mandatory()?></td>
									<td class="input">
										<input type="radio" name="flag_kab" value="1" checked>&nbsp;Kota
										<input type="radio" name="flag_kab" value="2">&nbsp;Kabupaten
									</td>
								</tr>
								<?endif; //if($tipe_cari=="KOTA"):?>
								<tr>
									<td class="field">Nama&nbsp;<?=$judul?>&nbsp;<?mandatory()?></td>
									<td class="input"><input type="text" name="nama_wilayah" id="idNamawilayah" onblur="cekDulu('<?=$tipe_cari?>',this)" onclick="select()" value="<?=$data_baru?>"/></td>
								</tr>
								<tr>
									<td class="field">Inisial&nbsp;<?=$judul?></td>
									<td class="input"><input type="text" name="inisial_wilayah"/></td>
								</tr>
								<?if($tipe_cari=="KELURAHAN"):?>
								<tr>
									<td class="field">Kode Pos&nbsp;<?mandatory()?></td>
									<td class="input"><input type="text" name="kode_pos"/></td>
								</tr>
								<?endif; //if($tipe_cari=="KELURAHAN"):?>
								<input type="hidden" name="id_atas" value="<?=$id_atas?>">
								<input type="hidden" name="param" value="ACT_WILAYAH">
								<input type="hidden" name="tipe_cari" value="<?=$tipe_cari?>">
								<input type="hidden" name="id_pisah" value="<?=$id_pisah?>">
							</table>
						</td>
			<!-- --------------------------------------------------------------------------------- -->
					</tr>
				</table>
				<div class="formInputSubmit"><input type="submit" name="Submit" value="Submit" class="submit01" onclick="javascript: return validasiForm(this,'inisial_wilayah');" id="idSubmit"></div>
			</form>
		</div>
		<!-- ############################################################################################# -->
		<script language="JavaScript" type="text/javascript">
			window.onload = function() {
				initHalaman();
				window.resizeTo(400,350);
				if(HTTPPATH == null)var HTTPPATH=location.protocol + '//' + location.host;
			}

			function cekDulu(tipeCari,Elm){
				if (Elm.value!=""){
					var url = HTTPPATH+"/_lib/function/function.form_wilayah_depan.php?param=AJAX&tipe_cari="+tipeCari+"&filter=" + Elm.value;
					if (url!==null) retrieveDataYoe(url,"getCekdulu");
				}
			}

			function getCekdulu(obj) {
				var namaWilayah=document.getElementById('idNamawilayah').value;
				arrIsiObj = obj.responseText.split("^");
				switch(arrIsiObj[0]){
					case 'PROPINSI':
						if(strtoupperJS(arrIsiObj[1])==strtoupperJS(namaWilayah)){
							alert('Nama '+ ucfirstJS(arrIsiObj[0]) + ' ' + ucfirstJS(namaWilayah) + ' sudah ada di database');
							document.getElementById('idSubmit').disabled=true;
						} else {
							document.getElementById('idSubmit').disabled=false;
						}
					break;
					case 'KOTA':
						if(strtoupperJS(arrIsiObj[10])==strtoupperJS(namaWilayah)){
							alert('Nama '+ ucfirstJS(arrIsiObj[0]) + ' ' + ucfirstJS(namaWilayah) + ' sudah ada di database');
							document.getElementById('idSubmit').disabled=true;
						} else {
							document.getElementById('idSubmit').disabled=false;
						}
					break;
					case 'KECAMATAN':
						if(strtoupperJS(arrIsiObj[5])==strtoupperJS(namaWilayah)){
							alert('Nama '+ ucfirstJS(arrIsiObj[0]) + ' ' + ucfirstJS(namaWilayah) + ' sudah ada di database');
							document.getElementById('idSubmit').disabled=true;
						} else {
							document.getElementById('idSubmit').disabled=false;
						}
					break;
					case 'KELURAHAN':
						if(strtoupperJS(arrIsiObj[7])==strtoupperJS(namaWilayah)){
							alert('Nama '+ ucfirstJS(arrIsiObj[0]) + ' ' + ucfirstJS(namaWilayah) + ' sudah ada di database');
							document.getElementById('idSubmit').disabled=true;
						} else {
							document.getElementById('idSubmit').disabled=false;
						}
					break;
				}
			}
		</script>
	</body>
</html>
<?
	break; //END case "ADD_WILAYAH";
	case "ACT_WILAYAH";

	$result = true;

	$db->BeginTrans();

	//////////////////////////////////////////////////////////////////////

	unset($insertWilayah);

	$id_dc_negara=baca_tabel("dc_negara","id_dc_negara","WHERE nama_negara LIKE '%indonesia%'");

	switch($tipe_cari){
		case "PROPINSI":
			$tabel_db = "dc_propinsi";
			$insertWilayah["id_dc_negara"] = $id_atas;
			$insertWilayah["inisial_propinsi"] = strtoupper(trim($inisial_wilayah));
			$insertWilayah["nama_propinsi"] = ucfirst(strtolower(trim($nama_wilayah)));
		break;
		case "KOTA":
			$tabel_db = "dc_kota";
			$insertWilayah["id_dc_negara"] = ($id_dc_negara)?$id_dc_negara:'1';
			$insertWilayah["id_dc_propinsi"] = $id_atas;
			$insertWilayah["flag_kab"] = $flag_kab;
			$insertWilayah["inisial_kota"] = strtoupper(trim($inisial_wilayah));
			$insertWilayah["nama_kota"] = ucfirst(strtolower(trim($nama_wilayah)));
		break;
		case "KECAMATAN":
			$tabel_db = "dc_kecamatan";
			$r_kecamatan = read_tabel('dc_wilayah_v','id_dc_propinsi',"WHERE id_dc_kota=".$id_atas);
			$id_dc_propinsi = $r_kecamatan->fields["id_dc_propinsi"];

			$insertWilayah["id_dc_negara"] = ($id_dc_negara)?$id_dc_negara:'1';
			$insertWilayah["id_dc_propinsi"] = $id_dc_propinsi;
			$insertWilayah["id_dc_kota"] = $id_atas;
			$insertWilayah["inisial_kecamatan"] = strtoupper(trim($inisial_wilayah));
			$insertWilayah["nama_kecamatan"] = ucfirst(strtolower(trim($nama_wilayah)));
		break;
		case "KELURAHAN":
			$tabel_db = "dc_kelurahan";
			$r_kelurahan = read_tabel('dc_wilayah_v','id_dc_kota,id_dc_propinsi',"WHERE id_dc_kecamatan=".$id_atas);
			$id_dc_propinsi = $r_kelurahan->fields["id_dc_propinsi"];
			$id_dc_kota = $r_kelurahan->fields["id_dc_kota"];

			$insertWilayah["id_dc_negara"] = ($id_dc_negara)?$id_dc_negara:'1';
			$insertWilayah["id_dc_propinsi"] = $id_dc_propinsi;
			$insertWilayah["id_dc_kota"] = $id_dc_kota;
			$insertWilayah["id_dc_kecamatan"] = $id_atas;
			$insertWilayah["inisial_kelurahan"] = strtoupper(trim($inisial_wilayah));
			$insertWilayah["nama_kelurahan"] = ucfirst(strtolower(trim($nama_wilayah)));
			$insertWilayah["kode_pos"] = $kode_pos;
		break;
	}

	if($insertWilayah!='')$result = insert_tabel($tabel_db, $insertWilayah);
	$id_refresh = $db->Insert_ID();

	//////////////////////////////////////////////////////////////////////

	$db->CommitTrans($result !== false);
?>
<html>
	<head>
		<title>Konfirmasi</title>
	</head>
	<body onload="javascript:window.opener.refreshMe('<?=$tipe_cari?>','<?=$id_refresh?>','<?=$id_pisah?>');window.close();">
	</body>
</html>
<?
	break; //END case "ACT_WILAYAH";
	default: //function form_wilayah()
 
		if (!function_exists("form_wilayah")) {
			function form_wilayah($frm_name='form_punk',$id_dc_propinsi='id_dc_propinsi',$id_dc_kota='id_dc_kota',$id_dc_kecamatan='id_dc_kecamatan',$id_dc_kelurahan='id_dc_kelurahan',$kode_pos='kode_pos',$theStyle='',$default_propinsi='',$default_kota='',$default_kecamatan='',$default_kelurahan='',$default_kodepos='') {

			if(trim($default_propinsi)=='' && trim($default_kota)!="")$default_propinsi=baca_tabel("dc_kota","id_dc_propinsi","WHERE id_dc_kota=".$default_kota);
			if(trim($default_propinsi)!="")$isi_propinsi=baca_tabel("dc_propinsi","nama_propinsi","WHERE id_dc_propinsi=".$default_propinsi);
			if(trim($default_kota)!="")$isi_kota=baca_tabel("dc_kota","nama_kota","WHERE id_dc_kota=".$default_kota);
			if(trim($default_kecamatan)!="")$isi_kecamatan=baca_tabel("dc_kecamatan","nama_kecamatan","WHERE id_dc_kecamatan=".$default_kecamatan);
			if(trim($default_kelurahan)!="")$isi_kelurahan=baca_tabel("dc_kelurahan","nama_kelurahan","WHERE id_dc_kelurahan=".$default_kelurahan);

			if(trim($default_kodepos)=='' && trim($default_kelurahan)!="")$isi_kodepos=baca_tabel("dc_kelurahan","kode_pos","WHERE id_dc_kelurahan=".$default_kelurahan);


?>
	<!-- START form_wilayah #######################################################################-->
	<tr>
	<td class="field" style="<?=$theStyle?>">Propinsi</td>
	<td class="input">
		<input type="text" name="AUTO_<?=$id_dc_propinsi?>" size='43' id="IDAUTO_<?=$id_dc_propinsi?>" value="<?=$isi_propinsi?>" onclick="select()">
		<input type="hidden" name="<?=$id_dc_propinsi?>" id="ID_<?=$id_dc_propinsi?>" value="<?=$default_propinsi?>">
		<?=mandatory();?>
		&nbsp;
		<a href="#" title="Tambah Propinsi" onclick="tambah_wilayah_<?=$kode_pos?>('PROPINSI')" id="IDADD_<?=$id_dc_propinsi?>" style="display:none"><img border="none" src="/_images/icons/icokecil_tambah.gif"></a>
	</td>
	</tr>
	<tr>
	<td class="field" style="<?=$theStyle?>">Kota</td>
	<td class="input">
		<input type="text" name="AUTO_<?=$id_dc_kota?>" size='43' id="IDAUTO_<?=$id_dc_kota?>" value="<?=$isi_kota?>" onclick="select()">
		<input type="hidden" name="<?=$id_dc_kota?>" id="ID_<?=$id_dc_kota?>" value="<?=$default_kota?>">
		<?=mandatory();?>
		&nbsp;
		<a href="#" title="Tambah Kota" onclick="tambah_wilayah_<?=$kode_pos?>('KOTA')" id="IDADD_<?=$id_dc_kota?>" style="display:none"><img border="none" src="/_images/icons/icokecil_tambah.gif"></a>
	</td>
	</tr>
	<tr>
	<td class="field" style="<?=$theStyle?>">Kecamatan</td>
	<td class="input">
		<input type="text" name="AUTO_<?=$id_dc_kecamatan?>" size='43' id="IDAUTO_<?=$id_dc_kecamatan?>" value="<?=$isi_kecamatan?>" onclick="select()">
		<input type="hidden" name="<?=$id_dc_kecamatan?>" id="ID_<?=$id_dc_kecamatan?>" value="<?=$default_kecamatan?>">
		<?=mandatory();?>
		&nbsp;
		<a href="#" title="Tambah Kecamatan" onclick="tambah_wilayah_<?=$kode_pos?>('KECAMATAN')" id="IDADD_<?=$id_dc_kecamatan?>" style="display:none"><img border="none" src="/_images/icons/icokecil_tambah.gif"></a>
	</td>
	</tr>
	<tr>
	<td class="field" style="<?=$theStyle?>">Kelurahan</td>
	<td class="input">
		<input type="text" name="AUTO_<?=$id_dc_kelurahan?>" size='43' id="IDAUTO_<?=$id_dc_kelurahan?>" value="<?=$isi_kelurahan?>" onclick="select()">
		<input type="hidden" name="<?=$id_dc_kelurahan?>" id="ID_<?=$id_dc_kelurahan?>" value="<?=$default_kelurahan?>">
		<?=mandatory();?>
		&nbsp;
		<a href="#" title="Tambah Kelurahan" onclick="tambah_wilayah_<?=$kode_pos?>('KELURAHAN')" id="IDADD_<?=$id_dc_kelurahan?>" style="display:none"><img border="none" src="/_images/icons/icokecil_tambah.gif"></a>
	</td>
	</tr>
	<tr>
	<td class="field" style="<?=$theStyle?>">Kode Pos</td>
	<td class="input">
		<span id="IDTD_<?=$kode_pos?>">
			<?=($isi_kodepos)?$isi_kodepos:'&nbsp;';?>
			<input type="hidden" name="DATA_BARU_<?=$kode_pos?>" id="IDDATABARU">
		</span>
		<input type="hidden" name="<?=$kode_pos?>" id="ID_<?=$kode_pos?>" value="<?=$default_kodepos?>">
	</td>
	</tr>
	<!-- END form_wilayah #######################################################################-->
	<!-- START javascript #######################################################################-->
		<script language="JavaScript" type="text/javascript">
		
		if(HTTPPATH == null)var HTTPPATH=location.protocol + '//' + location.host;
		var AJAXPATH			= HTTPPATH+"/_lib/function/function.form_wilayah_depan.php";

		$().ready(function() {

			$("#IDAUTO_<?=$id_dc_propinsi?>").autocomplete(AJAXPATH+"?param=AUTOCOMPLETE&tipe_cari=PROPINSI", {
				width: 260,
				matchContains: true,
				selectFirst: false,
				minChars: 0, 
				cacheLength: 0,
				extraParams: {
					id_dc_negara: 1
				}
			});

			$("#IDAUTO_<?=$id_dc_kota?>").autocomplete(AJAXPATH+"?param=AUTOCOMPLETE&tipe_cari=KOTA", {
				width: 260,
				matchContains: true,
				selectFirst: false,
				minChars: 0, 
				cacheLength: 0,
				extraParams: {
					id_dc_propinsi: function() { return document.<?=$frm_name?>.elements['<?=$id_dc_propinsi?>'].value; }
				}
			});
			$("#IDAUTO_<?=$id_dc_kecamatan?>").autocomplete(AJAXPATH+"?param=AUTOCOMPLETE&tipe_cari=KECAMATAN", {
				width: 260,
				matchContains: true,
				selectFirst: false,
				minChars: 0, 
				cacheLength: 0,
				extraParams: {
					id_dc_kota: function() { return document.<?=$frm_name?>.elements['<?=$id_dc_kota?>'].value; }
				}
			});
			$("#IDAUTO_<?=$id_dc_kelurahan?>").autocomplete(AJAXPATH+"?param=AUTOCOMPLETE&tipe_cari=KELURAHAN", {
				width: 260,
				matchContains: true,
				selectFirst: false,
				minChars: 0, 
				cacheLength: 0,
				extraParams: {
					id_dc_kecamatan: function() { return document.<?=$frm_name?>.elements['<?=$id_dc_kecamatan?>'].value; }
				}
			});
		});

		$("#IDAUTO_<?=$id_dc_propinsi?>").result(function(event, data, formatted) {
			if(trimJS(data[1])!=''){
				document.<?=$frm_name?>.elements['<?=$id_dc_propinsi?>'].value = data[1];
				url = AJAXPATH+"?param=AJAX&tipe_cari=PROPINSI&id_dc_propinsi=" + escape(data[1]);
				if (url!==null) retrieveDataYoe(url, "getData_<?=$kode_pos?>");
			} else {
				document.getElementById('IDDATABARU').value = trimJS(data[2]);
				buka('IDADD_<?=$id_dc_propinsi?>');
			}
		});
		$("#IDAUTO_<?=$id_dc_kota?>").result(function(event, data, formatted) {
			if(trimJS(data[1])!=''){
				document.<?=$frm_name?>.elements['<?=$id_dc_kota?>'].value = data[1];
				url = AJAXPATH+"?param=AJAX&tipe_cari=KOTA&id_dc_kota=" + escape(data[1]);
				if (url!==null) retrieveDataYoe(url, "getData_<?=$kode_pos?>");
			} else {
				document.getElementById('IDDATABARU').value = trimJS(data[2]);
				buka('IDADD_<?=$id_dc_kota?>');
			}
		});
		$("#IDAUTO_<?=$id_dc_kecamatan?>").result(function(event, data, formatted) {
			if(trimJS(data[1])!=''){
				document.<?=$frm_name?>.elements['<?=$id_dc_kecamatan?>'].value = data[1];
				url = AJAXPATH+"?param=AJAX&tipe_cari=KECAMATAN&id_dc_kecamatan=" + escape(data[1]);
				if (url!==null) retrieveDataYoe(url, "getData_<?=$kode_pos?>");
			} else {
				document.getElementById('IDDATABARU').value = trimJS(data[2]);
				buka('IDADD_<?=$id_dc_kecamatan?>');
			}
		});
		$("#IDAUTO_<?=$id_dc_kelurahan?>").result(function(event, data, formatted) {
			if(trimJS(data[1])!=''){
				document.<?=$frm_name?>.elements['<?=$id_dc_kelurahan?>'].value = data[1];
				url = AJAXPATH+"?param=AJAX&tipe_cari=KELURAHAN&id_dc_kelurahan=" + escape(data[1]);
				if (url!==null) retrieveDataYoe(url, "getData_<?=$kode_pos?>");
			} else {
				document.getElementById('IDDATABARU').value = trimJS(data[2]);
				buka('IDADD_<?=$id_dc_kelurahan?>');
			}
		});
		function getData_<?=$kode_pos?>(obj) {
			arrIsiObj = obj.responseText.split("^");
			switch(arrIsiObj[0]){
				case 'PROPINSI':
					if(document.<?=$frm_name?>.elements['AUTO_<?=$id_dc_propinsi?>'].value=="-- Data Tidak Ditemukan --"){
						document.<?=$frm_name?>.elements['AUTO_<?=$id_dc_propinsi?>'].value = trimJS(arrIsiObj[1]);
						document.<?=$frm_name?>.elements['ID_<?=$id_dc_propinsi?>'].value = arrIsiObj[2];
						tutup("IDADD_<?=$id_dc_propinsi?>");
					}

					document.<?=$frm_name?>.elements['IDAUTO_<?=$id_dc_kota?>'].value = trimJS(arrIsiObj[3]);
					document.<?=$frm_name?>.elements['ID_<?=$id_dc_kota?>'].value = arrIsiObj[4];
					document.<?=$frm_name?>.elements['IDAUTO_<?=$id_dc_kecamatan?>'].value = trimJS(arrIsiObj[5]);
					document.<?=$frm_name?>.elements['ID_<?=$id_dc_kecamatan?>'].value = arrIsiObj[6];
					document.<?=$frm_name?>.elements['IDAUTO_<?=$id_dc_kelurahan?>'].value = trimJS(arrIsiObj[7]);
					document.<?=$frm_name?>.elements['ID_<?=$id_dc_kelurahan?>'].value = arrIsiObj[8];
					document.getElementById('IDTD_<?=$kode_pos?>').innerHTML = arrIsiObj[9];
					document.<?=$frm_name?>.elements['ID_<?=$kode_pos?>'].value = arrIsiObj[9];
				break;
				case 'KOTA':
					document.<?=$frm_name?>.elements['AUTO_<?=$id_dc_propinsi?>'].value = trimJS(arrIsiObj[1]);
					document.<?=$frm_name?>.elements['ID_<?=$id_dc_propinsi?>'].value = arrIsiObj[2];

					if(document.<?=$frm_name?>.elements['IDAUTO_<?=$id_dc_kota?>'].value=="-- Data Tidak Ditemukan --"){
						document.<?=$frm_name?>.elements['IDAUTO_<?=$id_dc_kota?>'].value = trimJS(arrIsiObj[3]);
						document.<?=$frm_name?>.elements['ID_<?=$id_dc_kota?>'].value = arrIsiObj[4];
						tutup("IDADD_<?=$id_dc_kota?>");
					}

					document.<?=$frm_name?>.elements['IDAUTO_<?=$id_dc_kecamatan?>'].value = trimJS(arrIsiObj[5]);
					document.<?=$frm_name?>.elements['ID_<?=$id_dc_kecamatan?>'].value = arrIsiObj[6];
					document.<?=$frm_name?>.elements['IDAUTO_<?=$id_dc_kelurahan?>'].value = trimJS(arrIsiObj[7]);
					document.<?=$frm_name?>.elements['ID_<?=$id_dc_kelurahan?>'].value = arrIsiObj[8];
					document.getElementById('IDTD_<?=$kode_pos?>').innerHTML = arrIsiObj[9];
					document.<?=$frm_name?>.elements['ID_<?=$kode_pos?>'].value = arrIsiObj[9];
				break;
				case 'KECAMATAN':
					document.<?=$frm_name?>.elements['AUTO_<?=$id_dc_propinsi?>'].value = trimJS(arrIsiObj[1]);
					document.<?=$frm_name?>.elements['ID_<?=$id_dc_propinsi?>'].value = arrIsiObj[2];
					document.<?=$frm_name?>.elements['IDAUTO_<?=$id_dc_kota?>'].value = trimJS(arrIsiObj[3]);
					document.<?=$frm_name?>.elements['ID_<?=$id_dc_kota?>'].value = arrIsiObj[4];

					if(document.<?=$frm_name?>.elements['IDAUTO_<?=$id_dc_kecamatan?>'].value=="-- Data Tidak Ditemukan --"){
						document.<?=$frm_name?>.elements['IDAUTO_<?=$id_dc_kecamatan?>'].value = trimJS(arrIsiObj[5]);
						document.<?=$frm_name?>.elements['ID_<?=$id_dc_kecamatan?>'].value = arrIsiObj[6];
						tutup("IDADD_<?=$id_dc_kecamatan?>");
					}

					document.<?=$frm_name?>.elements['IDAUTO_<?=$id_dc_kelurahan?>'].value = trimJS(arrIsiObj[7]);
					document.<?=$frm_name?>.elements['ID_<?=$id_dc_kelurahan?>'].value = arrIsiObj[8];
					document.getElementById('IDTD_<?=$kode_pos?>').innerHTML = arrIsiObj[9];
					document.<?=$frm_name?>.elements['ID_<?=$kode_pos?>'].value = arrIsiObj[9];
				break;
				case 'KELURAHAN':
					document.<?=$frm_name?>.elements['AUTO_<?=$id_dc_propinsi?>'].value = trimJS(arrIsiObj[1]);
					document.<?=$frm_name?>.elements['ID_<?=$id_dc_propinsi?>'].value = arrIsiObj[2];
					document.<?=$frm_name?>.elements['IDAUTO_<?=$id_dc_kota?>'].value = trimJS(arrIsiObj[3]);
					document.<?=$frm_name?>.elements['ID_<?=$id_dc_kota?>'].value = arrIsiObj[4];
					document.<?=$frm_name?>.elements['IDAUTO_<?=$id_dc_kecamatan?>'].value = trimJS(arrIsiObj[5]);
					document.<?=$frm_name?>.elements['ID_<?=$id_dc_kecamatan?>'].value = arrIsiObj[6];

					if(document.<?=$frm_name?>.elements['IDAUTO_<?=$id_dc_kelurahan?>'].value=="-- Data Tidak Ditemukan --"){
						document.<?=$frm_name?>.elements['IDAUTO_<?=$id_dc_kelurahan?>'].value = trimJS(arrIsiObj[7]);
						document.<?=$frm_name?>.elements['ID_<?=$id_dc_kelurahan?>'].value = arrIsiObj[8];
						tutup("IDADD_<?=$id_dc_kelurahan?>");
					}

					document.getElementById('IDTD_<?=$kode_pos?>').innerHTML = arrIsiObj[9];
					document.<?=$frm_name?>.elements['ID_<?=$kode_pos?>'].value = arrIsiObj[9];
				break;
			}
		}
		
			function tambah_wilayah_<?=$kode_pos?>(Elm){
				var tipeCari,namaCari,idAtas;
				var dataBaru_<?=$kode_pos?> = document.getElementById('IDDATABARU').value

				switch(Elm){
					case 'PROPINSI':
						tipeCari='PROPINSI';
						namaCari='Indonesia';
						idAtas=1; //ambil id_dc_negara (Indonesia) :p
					break
					case 'KOTA':
						tipeCari='KOTA';
						namaCari=frmName_<?=$txt_form?>.elements['IDAUTO_<?=$id_dc_propinsi?>'].value;
						idAtas=frmName_<?=$txt_form?>.elements['ID_<?=$id_dc_propinsi?>'].value;
					break
					case 'KECAMATAN':
						tipeCari='KECAMATAN';
						namaCari=frmName_<?=$txt_form?>.elements['IDAUTO_<?=$id_dc_kota?>'].value;
						idAtas=frmName_<?=$txt_form?>.elements['ID_<?=$id_dc_kota?>'].value;
					break
					case 'KELURAHAN':
						tipeCari='KELURAHAN';
						namaCari=frmName_<?=$txt_form?>.elements['ID_<?=$id_dc_kota?>'].value;
						idAtas=frmName_<?=$txt_form?>.elements['ID_<?=$id_dc_kecamatan?>'].value;
					break
				}
				if (tipeCari!='' && idAtas!='' && namaCari!='') {
					url = HTTPPATH+"/_lib/function/function.form_wilayah_depan.php?param=ADD_WILAYAH&tipe_cari="+tipeCari+"&id_atas="+idAtas+"&nama_cari="+namaCari+"&data_baru="+dataBaru_<?=$kode_pos?>+"&id_pisah=<?=$kode_pos?>";
					openPop(url);
				} else {
					alert('PARAMETER KURANG !');
					return false;
				}
			}
			
			function refreshMe(tipeCari,selectedElm,idPisah) {
				var optUrl;
				switch(tipeCari){
					case 'PROPINSI':
						optUrl="&id_dc_propinsi=" + selectedElm;
					break
					case 'KOTA':
						optUrl="&id_dc_kota=" + selectedElm;
					break
					case 'KECAMATAN':
						optUrl="&id_dc_kecamatan=" + selectedElm;
					break
					case 'KELURAHAN':
						optUrl="&id_dc_kelurahan=" + selectedElm;
					break
				}
				var url = HTTPPATH+"/_lib/function/function.form_wilayah_depan.php?param=AJAX&tipe_cari=" + tipeCari + optUrl;
				if (url!==null) retrieveDataYoe(url,"getData_"+idPisah);
			}
		</script>
	<!-- END javascript #######################################################################-->
<?} //function form_wilayah(?>
<?} //if (!function_exists("form_wilayah")) {?>
<?} //switch($param){?>