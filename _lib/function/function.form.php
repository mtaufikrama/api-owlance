<?
// ----------------------- FUNCTION cetak -----------------------

/**
 * cetak() : Untuk memunculkan link [cetak] dan [close] yang tidak ikut dicetak
 *
 */

if (!function_exists("cetak")) {
	function cetak() {
?>

<span style="visibility: hidden;">
<a href="#" onclick="javascript:window.print()">Cetak</a>&nbsp;&nbsp;&nbsp;<a href="#" onclick="javascript:window.close()">Close</a>
</span>

<?
	} // end of function cetak()
} // end of if(!function_exists("cetak"))

// ----------------------- FUNCTION date_popup -----------------------

/**
 * date_popup() : Untuk ngambil kalender dengan interface yang user-friendly
 *
 * @param string $nama_var  Nama variabel kalender (dianggap text input)
 * @param string $nama_form Nama form
 *
 */

if (!function_exists("date_popup")) {
	function date_popup($nama_var="txt_tgl",$nama_form="") {
?>

<input type=text name="<?$nama_var?>" size="15"><a href="javascript:show_calendar('<?$nama_form?>.<?$nama_var?>');" onmouseover="window.status='Date Picker';return true;" onmouseout="window.status='';return true;"><img src="show-calendar.gif" width="24" height="22" border="0"></a>

<?
	} // end of function date_popup($nama_var="txt_tgl",$nama_form="")
} // end of if (!function_exists("date_popup"))

// ----------------------- FUNCTION form_bln -----------------------

/**
 * form_bln() : Menampilkan select (form element) untuk input bulan
 *
 * @param  string  $txt_nama  Nama dari elemen select
 * @param  int     $default   Default selected
 * @param  string  $dhtml     User-defined Dynamic HTML or [disabled] attribute
 * @param  int     $mode      Display mode :
 *                            NULL : menampilkan nama bulan (singkatan, 3 huruf)
 *                            NOT NULL : menampilkan bulan dalam bentuk angkanya
 *
 */

if (!function_exists("form_bln")) {
	function form_bln($txt_nama="txt_bln",$default="",$dhtml="",$mode="") {
		$nama_bulan=array("Jan","Feb","Mar","Apr","Mei","Jun","Jul","Agt","Sep","Okt","Nov","Des");
?>
<select class='form-control' name="<?=$txt_nama?>" id="<?=$txt_nama?>" size="1" <?=$dhtml?>>
<?
		if ($default!="") {
			$bln_patokan=$default;
		} elseif ($$txt_nama!="") {
			$bln_patokan=$$txt_nama;
		} else {
			$bln_patokan=date("n");
		}

		for ($i=1;$i<=12;$i++) {
?>
	<option value="<?=$i?>" <?=($bln_patokan==$i)?"selected":""?>><?=($mode=="")?$nama_bulan[$i-1]:$i?></option>
<?
		} // end of for ($i=1;$i<=12;$i++)
?>
</select>
<?
	} // end of function form_bln($txt_nama="txt_bln",$default="",$dhtml="",$mode="")
} // end of if (!function_exists("form_bln"))

// ----------------------- FUNCTION form_isian -----------------------

/**
 * form_isian() : Membuat form isian untuk sesuatu yang tak diketahui. blah.. blah.. blah..
 *
 * Contoh Penggunaan Fungsi ......
 *   $nama_field="kode ICD-10,Nama ICD-10";
 *   $variabel_field="txt_icd_10,txt_nama_icd,";
 *   $value_field="";
 *   $size_field="10,30";
 *   $action="isi_icd10_act.php";
 *   $nama_hidden="";
 *   $value_hidden="";
 *   $judul_diatas="ISI TABEL ICD-10";
 *   $nama_form="";
 *   $button="ISI";
 *   $tipe_form="1,2";
 *   form_isian($nama_field,$variabel_field,$size_field,$action,$value_field,$nama_hidden,$value_hidden,$judul_diatas,$nama_form,$button,$tipe_form);
 *
 *
 * @param  string  $keterangan_f   Keterangan (comma-separated)
 * @param  string  $nama_var_f     Nama variabel (comma-separated)
 * @param  int     $size_f         Size text input (comma-separated)
 * @param  string  $action_f       Action dari form
 * @param  string  $value_form     Value text input (comma-separated)
 * @param  string  $tipe_hidden_f  Nama hidden input (comma-separated)
 * @param  string  $value_hidden   Value hidden input (comma-separated)
 * @param  string  $judul_f        Judul di form
 * @param  string  $nama_form_f    Nama form
 * @param  string  $button_f       Value dari submit button
 * @param  string  $tipe_form      Reserved (comma-separated)
 *
 */

if (!function_exists("form_isian")) {
	function form_isian($keterangan_f,$nama_var_f="",$size_f="",$action_f="PHP_SELF",$value_form="",$tipe_hidden_f="",$value_hidden="",$judul_f="FORM ISIAN",$nama_form_f="",$button_f="SUBMIT",$tipe_form="") {
		$cek_field_1=split(",",$keterangan_f);
		$cek_field_2=split(",",$nama_var_f);
		$cek_field_3=split(",",$value_form);
		$cek_field_6=split(",",$size_f);
		$cek_field_7=split(",",$tipe_form);
		$cek_field_4=split(",",$tipe_hidden_f);
		$cek_field_5=split(",",$value_hidden);
		$banyak_cekfield_1=count($cek_field_1);
		$banyak_cekfield_4=count($cek_field_4);

?>
<html xmlns:sirs>
<head>
<link rel="stylesheet" href="/_komponen/css/main.css" type="text/css">
<link rel="stylesheet" href="/_komponen/css/tags.css" type="text/css">
<script src="/_komponen/js/main.js"></script>
<meta http-equiv="pragma" content="no-cache">
</head>

<body style="overflow:hidden;">
<div id="ruler"></div>
<div id="isiHeader">
	<sirs:bartitle judul="<?=$judul_f?>"></sirs:bartitle>
</div>
<div id="isiMainNoFoot">
<form name="<?=$nama_form_f?>" method="post" action="<?=$action_f?>" style="margin:0px 0px 0px 0px;">

<table width="100%" border="0" align="center">
<tr>
	<td colspan="4" height="37">
		<div align="center"><b></b></div>
	</td>
</tr>
<tr>
	<td width="4%" height="30" >&nbsp;</td>
	<td width="25%" height="30" >&nbsp;</td>
	<td width="4%" height="30" >&nbsp;</td>
	<td width="67%" height="30" align="right">&nbsp;</td>
</tr>

<?
		for ($i=0; $i<$banyak_cekfield_1; $i++) {
			if ($cek_field_2[$i]=='') {
				$cek_field_2[$i]=$cek_field_1[$i];
			}
?>
<tr height="30" valign="top">
	<td>&nbsp;</td>
	<td>
		<div align="left"><b><?=$cek_field_1[$i]?></b></div>
	</td>
	<td>
		<div align="center">:</div>
	</td>
	<td>
		<div align="left">
<?
		if (($cek_field_7[$i]=='1') || ($cek_field_7[$i]=='')) {
?>
			<input type="<?=$cek_field_7[$i]?>" name="<?=$cek_field_2[$i]?>" size="<?=$cek_field_6[$i]?>" class="kecil" value="<?=$cek_field_3[$i]?>">
<?
		} elseif ($cek_field_7[$i]=='2') {
?>
			<textarea name="<?=$cek_field_2[$i]?>" rows="" cols="<?=$cek_field_6[$i]?>"><?=$cek_field_3[$i]?></textarea>
<?
		} // end of elseif ($cek_field_7[$i]=='2')
?>
		</div>
	</td>
</tr>

<?
		} # end of for ($i=0; $i<$banyak_cekfield_1; $i++)
?>

<tr height="26">
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td align="right">&nbsp;</td>
</tr>
<tr>
	<td colspan="4" height="59">
		<div align="center">
			<span class="brd03"><input type="submit" name="Submit"  class="submit03" value="<?=$button_f?>" <? konfirmasi('Apakah data sudah benar ?') ?>></span>
		</div>
	</td>
</tr>
</table>
<?
		for ($i=0; $i<$banyak_cekfield_4; $i++) {
?>
<input type="hidden" name="<?=$cek_field_4[$i]?>" value="<?=$cek_field_5[$i]?>">
<?
		}# end of $i=....
?>
</form>
</div>
</body>
</html>
<?
	} // end of function form_isian()
} // end of if (!function_exists("form_isian"))

// ----------------------- FUNCTION kolom -----------------------

/**
 * kolom() : Membuat judul kolom dengan pengaturan tertentu
 *
 * @param  array   $cek_field     Nama judul kolom
 * @param  array   $cek_field2    Lebar elemen
 * @param  string  $warna         Warna background
 * @param  string  $posisi_datar  Horizontal align dari elemen
 * @param  string  $posisi_tegak  Vertical align dari elemen
 *
 */

if (!function_exists("form_isian")) {
	function kolom($cek_field="",$cek_field2="",$warna="",$posisi_datar="",$posisi_tegak="") {
		//$cek_field=split(",",$nama_var_f);
		//$cek_field2=split(",",$ukuran);

		$banyak_cekfield=count($cek_field);
?>
	<tr bgcolor="<?=$warna?>">
<?
		for ($i=0; $i<$banyak_cekfield; $i++) {
?>
		<td width="<?=$cek_field2[$i]?>" align="<?=$posisi_datar?>" valign=<?=$posisi_tegak?>><?=$cek_field[$i]?> </td>
<?
		} # end of for ($i=0; $i<$banyak_cekfield; $i++)
?>
	</tr>
<?
	} # end of function kolom($cek_field="",$cek_field2="",$warna="",$posisi_datar="",$posisi_tegak="")
} // end of if (!function_exists("kolom"))

// ----------------------- FUNCTION form_tgl -----------------------

/**
 * form_tgl() : Menampilkan select (form element) untuk input tanggal
 *
 * @param  string  $txt_nama  Nama dari elemen select
 * @param  int     $default   Default selected
 * @param  string  $dhtml     User-defined Dynamic HTML or [disabled] attribute
 *
 */

if (!function_exists("form_tgl")) {
	function form_tgl($txt_nama="txt_tgl",$default="",$dhtml="") {
?>
<select class='form-control' name="<?=$txt_nama?>" <?=$dhtml?>>
<?
		if ($default!="") {
			$tgl_patokan=$default;
		} elseif ($$txt_nama!="") {
			$tgl_patokan=$$txt_nama;
		} else {
			$tgl_patokan=date("d");
		}

		for ($i=1;$i<=31;$i++) {
?>
	<option value="<?=$i?>" <?=($tgl_patokan==$i)?"selected":""?>><?=$i?></option>
<?
		} // end of for ($i=1;$i<=31;$i++)
?>
</select>
<?
	} // end of function form_tgl($txt_nama="txt_tgl",$default="",$dhtml="")
} // end of if (!function_exists("form_tgl"))

// ----------------------- FUNCTION form_tgl_baru -----------------------

/**
 * form_tgl_baru() : Menampilkan select (form element) untuk input tanggal, bulan, dan tahun sekaligus
 *
 * @param  string  $txt_nama      Nama dari elemen select
 * @param  int     $default       Default selected
 * @param  string  $dhtml         User-defined Dynamic HTML or [disabled] attribute
 * @param  int     $range_mundur  Tahun awal (berapa tahun mundurnya dari tahun sekarang)
 * @param  int     $range_maju    Tahun akhir (berapa tahun lagi dari tahun sekarang)
 *
 */

if (!function_exists("form_tgl_baru")) {
	function form_tgl_baru($txt_nama="txt_tgl",$default="",$dhtml="",$range_mundur="5",$range_maju="5") {
?>
<select class='form-control' name="<?=$txt_nama?>" <?=$dhtml?>>
<?
		if ($default!="") {
			$tgl_patokan=$default;
		} elseif ($$txt_nama!="") {
			$tgl_patokan=$$txt_nama;
		} else {
			$tgl_patokan=date("d");
		} // end of for ($i=1;$i<=31;$i++)

		for ($i=1;$i<=31;$i++) {
?>
	<option value="<?=$i?>" <?($tgl_patokan==$i)?"selected":""?>><?=$i?></option>
<?
		}
?>
</select>

<select class='form-control' name="<?=$txt_nama?>" size="1" <?=$disabled?> >
<?
		$nama_bulan=array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");

		if ($default!="") {
			$bln_patokan=$default;
		} elseif ($$txt_nama!="") {
			$bln_patokan=$$txt_nama;
		} else {
			$bln_patokan=date("n");
		}

		for ($i=1;$i<=12;$i++) {
?>
	<option value="<?=$i?>" <?=($bln_patokan==$i)?"selected":""?>><?=($mode=="")?$nama_bulan[$i-1]:$i?></option>
<?
		} // end of for ($i=1;$i<=12;$i++)
?>
</select>

<select class='form-control' name="<?=$txt_nama?>" size="1" <?=$disabled?> >
<?
		if ($default!="") {
			$thn_patokan=$default;
		} elseif ($$txt_nama!="") {
			$thn_patokan=$$txt_nama;
		} else {
			$thn_patokan=date("Y");
		}

		$mulai=date("Y")-$range_mundur;
		$akhir=date("Y")+$range_maju;

		for ($i=$mulai; $i<=($akhir); $i++) {
?>
	<option value="<?=$i?>" <?($thn_patokan==$i)?"selected":""?>><?=$i?></option>
<?
		} // end of for ($i=$mulai; $i<=($akhir); $i++)
?>
</select>
<?
	} // end of function form_tgl_baru($txt_nama="txt_tgl",$default="",$disabled="",$range_mundur="5",$range_maju="5")
} // end of if (!function_exists("form_tgl_baru"))

// ----------------------- FUNCTION form_tgl_new -----------------------

/**
 * form_tgl_new() : Menampilkan elemen untuk input tanggal, bulan, dan tahun sekaligus (in fashioned way)
 *
 * @param  string  $txt_nama  Nama dari input
 * @param  string  $default   Default selected
 * @param  string  $disabled  [disabled] attribute
 *
 */

if (!function_exists("form_tgl_new")) {
	function form_tgl_new($txt_nama="txt_tgl",$default="",$disabled="") {
		if ($default!="") {
?>
<div class="kalender"><script>DateInput('<?=$txt_nama?>',true,'YYYYMMDD','<?=$default?>')</script></div>
<?
		} else {
?>
<div class="kalender"><script>DateInput('<?=$txt_nama?>',true,'YYYYMMDD')</script></div>
<?
		} // end of elsenya if ($default!="")
	} // end of function form_tgl_new($txt_nama="txt_tgl",$default="",$disabled="")
} // end of if (!function_exists("form_tgl_new"))

// ----------------------- FUNCTION form_thn -----------------------

/**
 * form_thn() : Menampilkan elemen select (form element) untuk input tahun
 *
 * @param  string  $txt_nama      Nama dari input
 * @param  string  $default       Default selected
 * @param  int     $range_mundur  Tahun awal (berapa tahun mundurnya dari tahun sekarang)
 * @param  int     $range_maju    Tahun akhir (berapa tahun lagi dari tahun sekarang)
 * @param  string  $disabled      [disabled] attribute
 *
 */

if (!function_exists("form_thn")) {
	function form_thn($txt_nama="txt_thn",$default="",$range_mundur="20",$range_maju="5",$disabled="") {
?>
<select class='form-control' id="<?=$txt_nama?>" name="<?=$txt_nama?>" size="1" <?=$disabled?> >
<?
		if ($default!="") {
			$thn_patokan=$default;
		} elseif ($$txt_nama!="") {
			$thn_patokan=$$txt_nama;
		} else {
			$thn_patokan=date("Y");
		}

		$mulai=date("Y")-$range_mundur;
		$akhir=date("Y")+$range_maju;

		for ($i=$mulai; $i<=($akhir); $i++) {
?>
	<option value="<?=$i?>" <?=($thn_patokan==$i)?"selected":""?>><?=$i?></option>	
<?
		} // end of for ($i=$mulai; $i<=($akhir); $i++)
?> 
</select>
<?
	} // end of function form_thn($txt_nama="txt_thn",$default="",$range_mundur="10",$range_maju="10",$disabled="")
} // end of if (!function_exists("form_thn"))

// ----------------------- FUNCTION hanya_angka -----------------------

/**
 * hanya_angka() : bikin validasi bahwa di text input, yang diterima hanya karakter '0123456789'
 */

if (!function_exists("hanya_angka")) {
	function hanya_angka() {
?>
	onblur="javascript:{var valid = '0123456789';var ok = 'yes';var temp;for (var i=0; i<this.value.length; i++) {temp = '' + this.value.substring(i, i+1);if (valid.indexOf(temp) == '-1') ok = 'no';}if (ok == 'no') {alert('Pengisian Form ini Hanya Berlaku Angka');this.focus();return false;}}"
<?
	} // end of function hanya_angka()
} // end of if (!function_exists("form_thn"))

// ----------------------- FUNCTION isi_hidden -----------------------

/**
 * isi_hidden() : ???
 *
 * @param  string  $yg_tidak  Yang tidak dicek(comma-separated)
 *
 */

if (!function_exists("isi_hidden")) {
	function isi_hidden($yg_tidak="") {
		$nama_var="";
		$yg_gak_masuk=split(",",$yg_tidak);
		$banyak_cekfield=count($yg_gak_masuk);

		reset ($_POST);
		foreach ($_POST as $key => $val) {
			$cek_ada=0;
			for ($i=0;$i<$banyak_cekfield;$i++) {
					if ($yg_gak_masuk[$i]==$key) {
						$cek_ada++;
					}
			} // end of for ($i=0;$i<$banyak_cekfield;$i++)

			if ($cek_ada<1) {
?>
	<input type="hidden" name="<?=$key?>" value="<?=$val?>">
<?
			}
		} // end of foreach ($_POST as $key => $val)

		reset ($_GET);
		foreach ($_GET as $key => $val) {
			$cek_ada=0;
			for ($i=0;$i<$banyak_cekfield;$i++) {
					if ($yg_gak_masuk[$i]==$key) {
						$cek_ada++;
					}
			} // end of for ($i=0;$i<$banyak_cekfield;$i++)

			if($cek_ada<1) {
?>
	<input type="hidden" name="<?=$key?>" value="<?=$val?>">
<?
			}

		} // end of foreach ($_POST as $key => $val)

	} # end of function isi_hidden($yg_tidak="")
} // end of if (!function_exists("isi_hidden"))

// ----------------------- FUNCTION isi_kirim -----------------------

/**
 * isi_kirim() : Keterangan fungsinya
 *
 * @param tipe_variabel $nama_variabel Keterangan variabelnya
 *
 * @return tipe_variabel
 *
 */

if (!function_exists("isi_kirim")) {
	function isi_kirim($yg_tidak="") {
		$nama_var="";
		$yg_gak_masuk=split(",",$yg_tidak);
		$banyak_cekfield=count($yg_gak_masuk);

		reset ($_POST);
		foreach ($_POST as $key => $val) {
			$cek_ada=0;
			for ($i=0;$i<$banyak_cekfield;$i++) {
				if ($yg_gak_masuk[$i]==$key) {   
					$cek_ada++;
				}
			} // end of for
			if ($cek_ada<1) {   
				if (is_array($val)) {
					foreach ($val as $key2 => $val2) {
						if (is_array($val2)) {
							foreach ($val2 as $key3 => $val3) {
								$nama_var=$nama_var."&".$key."[$key2][$key3]=".urlencode($val3);
							}
						} else {
							$nama_var=$nama_var."&".$key."[$key2]=".urlencode($val2);
						}
					}
				} else {
					$nama_var=$nama_var."&".$key."=".urlencode($val);
				}
			}// end of if
		} // end of foreach ($_POST as $key => $val)
		reset ($_GET);
		foreach ($_GET as $key => $val) {
			$cek_ada=0;
			for ($i=0;$i<$banyak_cekfield;$i++) {
				if ($yg_gak_masuk[$i]==$key) {   
					$cek_ada++;
				}
			} // end of for
			if ($cek_ada<1) {   
				if (is_array($val)) {
					foreach ($val as $key2 => $val2) {
						if (is_array($val2)) {
							foreach ($val2 as $key3 => $val3) {
								$nama_var=$nama_var."&".$key."[$key2][$key3]=".urlencode($val3);
							}
						} else {
							$nama_var=$nama_var."&".$key."[$key2]=".urlencode($val2);
						}
					}
				} else {
					$nama_var=$nama_var."&".$key."=".urlencode($val);
				}
			}// end of if
		} // end of foreach ($_GET as $key => $val)
			
		$nilai_lempar=substr($nama_var, 1);

		return $nilai_lempar;
	} # end of function isi_benar
} // end of if (!function_exists("isi_kirim"))

// ----------------------- FUNCTION konfirmasi -----------------------

/**
 * konfirmasi() : Konfirmasi ke user (pake javascript), dan ngubah lokasi browser kalo konfirmasi bener
 *
 * @param  string  $teksnya  Pesan konfirmasi
 * @param  int     $mode     Dipake kalo parameter $teksnya gak ada
 * @param  string  $link     Link yang dituju kalo konfirmasi bener
 *                           Kalo link NULL, maka .... ???
 *
 */

if (!function_exists("konfirmasi")) {
	function konfirmasi($teksnya="",$mode="1",$link="") {
		// inisialisasi comment :::
		if ($teksnya=="") {
			switch ($mode) {
				case 1:
					$teksnya="Anda benar-benar ingin menghapus data ini ?";
					break;
				case 2:
					$teksnya="Anda benar-benar ingin mengubah data ini ?";
					break;
				case 3:
					$teksnya="Anda ingin mencetak data ini ?";
					break;
				case 4:
					$teksnya="Anda ingin mengisi data ?";
					break;
				case 4:
					$teksnya="Apakah data sudah benar ?";
					break;
				default:
					$teksnya="Anda benar-benar ingin menghapus data ini ? ?";
				} // end of switch ($mode)
		} // end of if ($teksnya=="")

		if ($link!="") {
?>
onclick="javascript: if(window.confirm('<?=$teksnya?>')==true){location.href='<?=$link?>'}else{return false;}"	
<?	
		} else{
?>
onclick="javascript:return window.confirm('<?=$teksnya?>')"
<?
		} // end of elsenya if ($link!="")
	} // end of function konfirmasi($teksnya="",$mode="1",$link="")
} // end of if (!function_exists("konfirmasi"))

// ----------------------- FUNCTION  -----------------------

/**
 * pilihan_list() : Bikin option list dengan field-field dari database
 *
 * @param  object  $db  AdoDB Object Database
 * @param  string  $sql_f  Query utk milih record & field di database
 * @param  string  $option_tampil_f  nama field yang akan ditampilkan (comma-separated)
 * @param  string  $isi_option_f  nama field yang akan jadi value-nya option
 * @param  string  $nilai_1_f  nama field yang akan dibandingkan, kalo sama dengan nama variabel $nilai_2_f maka option tersebut selected
 * @param  string  $nilai_2_f  nama variabel yang akan dibandingkan dengan nama field $nilai_1_f
 */

if (!function_exists("pilihan_list")) {
	function pilihan_list($sql_f,$option_tampil_f,$isi_option_f,$nilai_1_f="",$nilai_2_f="") {
		global $db;

		$res_tabel_f_h = &$db->Execute($sql_f);
		while ($res_tabel_f=$res_tabel_f_h->FetchRow()) {
			if (($nilai_1_f!="") && ($nilai_2_f!="")) {
				$selected_f = ($res_tabel_f[$nilai_1_f] == $nilai_2_f) ? "selected" : "";
			} else {
				$selected_f="";
			}

			$cek_field=split(",",$option_tampil_f);
			$banyak_cekfield=count($cek_field);
			for ($i=0; $i<$banyak_cekfield; $i++) {	
				$tampilin_f=$cek_field[$i];
				if ($i==1) {
					$isi_tampilin = "...(".$res_tabel_f[$tampilin_f].")";
				} else {
					$isi_tampilin = $res_tabel_f[$tampilin_f]." ";
				}
			}
?>
<option value="<?=$res_tabel_f[$isi_option_f]?>" <?=$selected_f?>><?=$isi_tampilin?></option>
<?
		} // end of while odbc_fetch_row;
	} // end of function pilihan_list;
} // end of if (!function_exists("pilihan_list"))

// ----------------------- FUNCTION  -----------------------

/**
 * nama_fungsi() : Keterangan fungsinya
 *
 * @param  tipe_variabel  $nama_variabel  Keterangan variabelnya
 *
 * @return  tipe_variabel  Keterangan return valuenya
 *
 */


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


?>