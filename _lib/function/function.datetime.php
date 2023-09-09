<?php
// ----------------------- FUNCTION namabulan -----------------------

// bandingkan dengan function bln2str() di bawah !!!
$namabulan=array("dummy","Januari","Pebruari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","Nopember","Desember");
if (!function_exists("namabulan")) {
	function namabulan($bulan="") {
		if (strlen($bulan)>0) {
			//$namabulan=array("dummy","Januari","Pebruari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","Nopember","Desember");
			return $namabulan[$bulan];
		} else {
			return "Bulan Salah!";
		} // end of if(strlen($bulan)>0)
	} // end of function namabulan($bulan="")
} // end of if(!function_exists("namabulan"))

// ----------------------- FUNCTION greeting -----------------------

if (!function_exists("greeting")) {
	function greeting($currentTime="") {
		if ($currentTime>10 && $currentTime<=14) {
			$greeting="Selamat Siang";
		} elseif ($currentTime>14 && $currentTime<=18) {
			$greeting="Selamat Sore";
		} elseif ($currentTime>18 && $currentTime<=23) {
			$greeting="Selamat Malam";
		} else {
			$greeting="Selamat Pagi";
		}
		return $greeting;
	} // end of function greeting($currentTime=date("H"))/**/
} // end of if(!function_exists("greeting"))

// ----------------------- FUNCTION angka2hari -----------------------

if (!function_exists("angka2hari")) {
	function angka2hari($angka) {
		$xx=array(0=>"Minggu",1=>"Senin",2=>"Selasa",3=>"Rabu",4=>"Kamis",5=>"Jumat",6=>"Sabtu");

		$hasil=$xx[$angka];

		return $hasil;
	} // end of function function angka2hari($angka)
} // end of if (!function_exists("angka2hari"))

// ----------------------- FUNCTION bandingkan_tgl -----------------------

if (!function_exists("bandingkan_tgl")) {
	// Menguji tanggal dalam string
	function bandingkan_tgl($tgl_diuji, $tgl_penguji = "", $tampilkan_terbesar = "") {		
		if ($tgl_penguji == "")
			$tgl_penguji = date("Y-m-d");
		list($thn_penguji, $bln_penguji, $hari_penguji) = split("[/.-]", $tgl_penguji);
		list($hari_diuji, $bln_diuji, $thn_diuji) = split("[/.-]", $tgl_diuji);		
		$wkt_penguji = mktime(0,0,0,$bln_penguji,$hari_penguji,$thn_penguji);
		$wkt_diuji = mktime(0,0,0,$bln_diuji,$hari_diuji,$thn_diuji);
		if ($tampilkan_terbesar != "") {
			// Jika mau menampilkan nilai terbesar/terkecil
			if ($tampilkan_terbesar)
				// Tampilkan nilai yang terbesar
				return (($wkt_penguji > $wkt_diuji) ? date("d-m-Y", $wkt_penguji) : date("d-m-Y", $wkt_diuji));
			else
				// Tampilkan nilai yang terkecil
				return (($wkt_penguji < $wkt_diuji) ? date("d-m-Y", $wkt_penguji) : date("d-m-Y", $wkt_diuji));
		} else {
			if ($wkt_penguji == $wkt_diuji)
				// Jika tanggal sama
				return 0;
			elseif ($wkt_penguji < $wkt_diuji)
				// Jika tanggal penguji lebih kecil daripada tanggal yang diuji			
				return 1;
			else
				// Jika tanggal penguji lebih kecil daripada tanggal yang diuji					
				return -1;
		}
	}
} // end of if(!function_exists("bandingkan_tgl")):

// ----------------------- FUNCTION batas_umur -----------------------

if (!function_exists("batas_umur")) {
	function batas_umur($no_mr,$no_kepesertaan="") {
		global $db;

		if ($no_mr!='') {
			$sql_cari="SELECT mp.nama_pasien AS nama,k.kode_fs,k.tgl_lahir,k.no_customer,k.no_pegawai,k.kode_kepesertaan FROM master_pasien mp,kepesertaan k WHERE mp.kode_kepesertaan=k.kode_kepesertaan AND no_mr='".$no_mr."'";
		} elseif($no_kepesertaan!='') {
			$sql_cari="SELECT k.nama_peserta AS nama,k.kode_fs,k.tgl_lahir,k.no_customer,k.no_pegawai,k.kode_kepesertaan FROM kepesertaan k WHERE kode_kepesertaan='".$no_kepesertaan."'";
		}

		$hasil=&$db->Execute($sql_cari);
		$kode_fs=$hasil->fields["kode_fs"];
		$nama=$hasil->fields["nama"];

		if ($kode_fs==3) {
				
			$no_customer=$hasil->fields["no_customer"];
			$cust=read_tabel("customer","batas_umur_anak","where no_customer='$no_customer'");
			$batas_umur=$cust->fields["batas_umur_anak"];

			$umurnya=umur($hasil->fields["tgl_lahir"]);
				
			if ($umurnya>$batas_umur) {
?>
				<font color='#FF0000' style="font-size: 12px;">Batas Umur kepesertaan untuk anak dibawah <?=$batas_umur?> tahun !</font>
				<font color="#FF0000">
<?php
			} // end of if ($umurnya>$batas_umur)
				
		} // end of if ($kode_fs==3)

		//return $comment;

	} // end of function batas_umur($no_mr,$no_kepesertaan="")
} // end of if (!function_exists("batas_umur"))

// ----------------------- FUNCTION bln2str -----------------------

// bandingkan dengan function namabulan() di atas !!!
if (!function_exists("bln2str")) {
	function bln2str($nilainya="",$mode="1") {
		if($mode=="1") {
			$nama_bulan=array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
		} elseif ($mode=="2") {
			$nama_bulan=array("Jan","Feb","Mar","Apr","Mei","Jun","Jul","Agust","Sep","Okt","Nov","Des");
		}

		if ($nilainya=="") {
			$nilainya=date("n");
		}

		$bulan=$nama_bulan[$nilainya-1];

		return($bulan);
	} // end of function bln2str($nilainya="",$mode="1")
} // end of if (!function_exists("bln2str"))

// ----------------------- FUNCTION cari_tanggal -----------------------

if (!function_exists("cari_tanggal")) {
	function cari_tanggal($tgl_akhir,$banyak,$tipe="") {

		global $db;
		$tgl_akhir=$db->UserDate($tgl_akhir,"Y-m-d H:i:s");
		$awal=mktime (0,0,0,1,1,1999);
		$akhir=mktime (0,0,0,1,2,1999);

		$selisih=$akhir-$awal;

		$banyaknya_selisih=$banyak*$selisih;

		list ($thn_2,$bln_2,$tgl_2) = split ('[/.-]', $tgl_akhir);

		$nilai_mktime2=mktime (0,0,0,$bln_2,$tgl_2,$thn_2);

		if($tipe=='1') {
			$nilai_mktime_baru=$nilai_mktime2+$banyaknya_selisih;
		} else {
			$nilai_mktime_baru=$nilai_mktime2-$banyaknya_selisih;	
		}

		$tglnya_adalah=date("Y-m-d",$nilai_mktime_baru);

		return $tglnya_adalah;
	} // end of function cari_tanggal($tgl_akhir,$banyak,$tipe="")
} // end of if (!function_exists("cari_tanggal"))

// ----------------------- FUNCTION date2sap -----------------------

/**
 * date2sap() : Untuk mengkonversi tanggal dari database ke format SAP
 *
 * @param string $a Tanggal yang akan dikonversi
 * @param int $mode Mode output :
 *                  0 : dot-delimited
 *                  1 : slash-delimited
 *
 * @return string
 *
 */

if (!function_exists("date2sap")) {
	function date2sap($a = "",$mode="0") {
		list ($fulltgl, $wkt) = split ('[ ]',$a);
		list ($tahun, $bulan, $tanggal) = split ('[/.-]', $fulltgl);

		if ($mode=="0") {
			$hasil=$tanggal.".".$bulan.".".$tahun;
		} else {
			$hasil=$tanggal."/".$bulan."/".$tahun;
		}  // end of elsenya if ($mode=="0")

		return $hasil;
	} // end of function date2sap($a = "",$mode="0")
} // end of if (!function_exists("date2sap"))
// ----------------------- FUNCTION  -----------------------

/**
 * sap2date() : Untuk mengkonversi tanggal dari format SAP ke database
 *
 * @param string $a Tanggal (format SAP) yang akan dikonversi
 * @param int $mode Mode output :
 *                  0 : hyphen-delimited
 *                  1 : slash-delimited
 *
 * @return string
 *
 */

if (!function_exists("sap2date")) {
	function sap2date($a = "",$mode="0"){
		list ($tanggal,$bulan,$tahun) = split ('[.]', $a);

		if ($mode=="0") {
			$hasil=$tahun."-".$bulan."-".$tanggal;
		} else {
			$hasil=$tahun."/".$bulan."/".$tanggal;
		}  // end of elsenya if ($mode=="0")

		return $hasil;
	} // end of function sap2date($a = "",$mode="0")
} // end of if (!function_exists("sap2date"))

// ----------------------- FUNCTION date2str -----------------------

/**
 * date2str() : Untuk mengkonversi tanggal (plus waktu) dari format database MSSQL ke human-readable format (Indonesian Locale)
 *
 * @param string $a Tanggal (format database) yang akan dikonversi
 * @param int $mode Mode output :
 *                  0 : hyphen-delimited
 *                  1 : slash-delimited
 *
 * @return string
 *
 */

if (!function_exists("date2str")) {
	function date2str($a = "",$mode="0"){
		global $db;
		
		$potongTahun	=substr($a,0,4);
		$potongBln		=substr($a,5,2);
		$potongTgl		=substr($a,8,2);
		
		$tanggal	=$potongTgl;
		$bulan		=$potongBln;
		$tahun		=$potongTahun;
		
		/*$tglWaktu=date("Y-m-d H:i:s",strtotime2($a));
		$potongWaktu=explode(" ",$tglWaktu);
		
		$potongTanggal=explode("-",$potongWaktu);
		
		$thn=$potongTanggal[0];
		$bln=$potongTanggal[1];
		$tgl=$potongTanggal[2];
		
		$tanggal=$tgl;
		$bulan	=$bln;
		$tahun	=$thn;*/
		
		$hasil=$a;
		
		//$b=$db->UserDate($a,"Y-m-d H:i:s");
		
		/*list ($fulltgl, $wkt) = split ('[ ]',$b);
		list ($tahun, $bulan, $tanggal) = split ('[/.-]', $fulltgl);*/

		if ($mode=="0") {
			$hasil=$tanggal."-".$bulan."-".$tahun;
		} else {
			$hasil=$tanggal."/".$bulan."/".$tahun;
		}/**/
		
		
		return $hasil;
	}
} // end of if (!function_exists("sap2date"))

// ----------------------- FUNCTION date2str_baru -----------------------

/**
 * date2str_baru() : Untuk mengkonversi tanggal dari format YYYYMMDD ke format lain
 *
 * @param string $a Tanggal (format database) yang akan dikonversi, return null kalo $a null
 * @param int $mode Mode output :
 *                  0 : format YYYY-MM-DD
 *                  1 : format DD-MM-YYYY
 *
 * @return string
 *
 */

if (!function_exists("date2str_baru")) {
	function date2str_baru($a = "",$mode="0") {
		$thn=substr($a, 0, 4); 
		$bln=substr($a, 4, 2);
		$tgl=substr($a, 6, 2);

		if ($mode=="0") {
			$hasil=$thn."-".$bln."-".$tgl;
		} else {
			$hasil=$tgl."-".$bln."-".$thn;
		}  // end of elsenya if ($mode=="0")

		return $a=="" ? "" : $hasil;
	}
} // end of if (!function_exists("date2str_baru"))


// ----------------------- FUNCTION date2str_baru -----------------------

/**
 * date2str_baru() : Untuk mengkonversi tanggal dari format YYYY[-/]MM[-/]DD ke ke format lain
 *
 * @param string $a Tanggal (format database) yang akan dikonversi, return null kalo $a null
 * @param int $mode Mode output :
 *                  0 : format YYYYMMDD
 *                  1 : format DDMMYYYY
 *
 * @return string
 *
 */

if (!function_exists("date2str_baru2")) {
	function date2str_baru2($a = "",$mode="0"){
		global $db;
		$a = $db->UserDate($a, "Y-m-d H:i:s");
		
		$thn=substr($a, 0, 4); 
		$bln=substr($a, 5, 2);
		$tgl=substr($a, 8, 2);

		if ($mode=="0") {
			$hasil=$thn.$bln.$tgl;
		} else {
			$hasil=$tgl.$bln.$thn;
		}  // end of elsenya if ($mode=="0")

		return $a=="" ? "" : $hasil;
	}
} // end of if (!function_exists("date2str_baru"))

// ----------------------- FUNCTION kurang_tanggal -----------------------

/**
 * kurang_tanggal() : Selisih dua tanggal (dalam hari)
 *
 * @param  string  $tgl1  Tanggal awal
 * @param  string  $tgl2  Tanggal akhir
 *
 * @return  string  Selisih kedua tanggal (dalam hari)
 *
 */

if (!function_exists("kurang_tanggal")) {
	function kurang_tanggal($tgl1,$tgl2) {
		//$tgl1=date("m/d/Y");
		ereg ("([0-9]{1,2})-([0-9]{1,2})-([0-9]{4})", $tgl1, $regs1); 
		ereg ("([0-9]{1,2})-([0-9]{1,2})-([0-9]{4})", $tgl2, $regs2);

		$temp1=date("z",mktime(0,0,0,$regs1[1],$regs1[2],$regs1[3]));
		$temp2=date("z",mktime(0,0,0,$regs2[1],$regs2[2],$regs2[3]));

		// Kalo tahunnya sama
		if($regs2[3]==$regs1[3]) {	
			$temp=$temp1-$temp2;
		} else {
			$temp=$temp1+date("z",mktime(0,0,0,1,0,$regs2[3]+1)-$temp2)+1;
		}
		return $temp;
	} // end of function kurang_tanggal($tgl1,$tgl2)
} // end of if (!function_exists("kurang_tanggal"))

// ----------------------- FUNCTION  -----------------------

/**
 * date2hour() : Ngambil jamnya doank!!!
 *
 * @param  string  $waktu  Input waktu dengan format "Y-m-d H:i:s"
 *
 * @return  string  Jamnya doank (tanpa mikrodetik) dengan format "Y-m-d H:i:s"
 *
 */

if (!function_exists("date2hour")) {
	function date2hour ($waktu="") {
		global $db;
		$b=$db->UserTimeStamp($waktu,"Y-m-d H:i:s");
		list ($fulltgl, $wkt) = split ('[ ]',$b);
		if(strlen($wkt)=="12") {
			$wkt=substr($wkt, 0, -4); // jika pake sql_server
		}
		return $wkt;
	} // end of function date2hour($waktu)
} // end of if (!function_exists("date2hour"))

// ----------------------- FUNCTION  -----------------------

/**
 * date_convert() : Buat Konversi dari format "d-m-Y H:i:s" ke "Y-m-d H:i:s"
 *
 * @param  string  $waktu  Waktu dengan format "d-m-Y H:i:s"
 *
 * @return  string  Waktu dengan format "Y-m-d H:i:s"
 *
 */

if (!function_exists("date_convert")) {
	function date_convert ($waktu="") {
		list($tgl,$bln,$thn,$jam,$menit,$detik) = split('[-/" ":]',$waktu);
		$timestamp_transaksi = mktime($jam,$menit,$detik,$bln,$tgl,$thn);
		$wkt = date("Y-m-d H:i:s",$timestamp_transaksi);
		return $wkt;
	} // end of function date_convert($waktu)
} // end of if (!function_exists("date_convert"))

// ----------------------- FUNCTION  -----------------------
/**
 * umur($a = "") : Fungsi untuk mencari umur
 *
 * @param  date  $a  Tanggal lahir orang tersebut
 *
 * @return  integer  Umur orang tersebut
 *
 */

if (!function_exists("umur")) {
	function umur($a = "") 
		{
		
		if($a=="")
		{
			$umurnya="-";

		}else
		{
		list ($fulltgl, $wkt) = split ('[ ]',$a);
		list ($tahun, $bulan, $tanggal) = split ('[/.-]', $fulltgl);
	
	$tgl_skrg=date("d");
	$bln_skrg=date("m");
	$thn_skrg=date("Y");

	if($bln_skrg==$bulan)
	{
		if($tgl_skrg<$tanggal)
		{
		$umurnya=$thn_skrg-$tahun-0.1;
		}
		else
		{
		$umurnya=$thn_skrg-$tahun;		
		}
	}
	elseif($bln_skrg<$bulan)
	{
	$umurnya=$thn_skrg-$tahun-1;
	$koma=(12-$bulan)+$bln_skrg;
	$koma=$koma/12;
	
	}
	else
	{
	$umurnya=$thn_skrg-$tahun;
	$koma=$bln_skrg-$bulan;
	$koma=$koma/12;
	
	}

	if($umurnya>0)
		{
			$umurnya=number_format($umurnya,0);
		}
		else
		{
			$umurnya=number_format($umurnya+$koma,1);
		}

	return $umurnya;
		}
}
}

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
if (!function_exists("selisih_tanggal")) {

function selisih_tanggal($tgl_akhir,$tgl_awal)
{

$awal=mktime (0,0,0,1,1,1999);
$akhir=mktime (0,0,0,1,2,1999);

$selisih=$akhir-$awal;

list ($bln_2,$tgl_2,$thn_2) = split ('[/.-]', $tgl_akhir);
list ($bln_1,$tgl_1,$thn_1) = split ('[/.-]', $tgl_awal);

$nilai_mktime1=mktime (0,0,0,$bln_1,$tgl_1,$thn_1);
$nilai_mktime2=mktime (0,0,0,$bln_2,$tgl_2,$thn_2);

$selisih_mktime=$nilai_mktime2-$nilai_mktime1;

$beda_tglnya=$selisih_mktime/$selisih;

return $beda_tglnya;
}
}
// ----------------------- FUNCTION  -----------------------
if (!function_exists("tgl_akhir_bln")) {

function tgl_akhir_bln($bln,$thn=""){
	
		if($thn==""):
		$thn=date("Y");
		endif;


		switch ($bln) {
			case 1:
			   $hasil="31";
				break;
			case 2:
				$kabisat=$thn%4;
				if($kabisat==0){
					$hasil=29;
				}else{
				//endif;
					$hasil="28";
				}break;
			case 3:
			   $hasil="31";
				break;
			case 5:
				$hasil="31";
				break;
			case 7:
				$hasil="31";
				break;
			case 8:
				$hasil="31";
					break;
			case 10:
				$hasil="31";
					break;
			case 12:
			   $hasil="31";
					break;
			default:
			   $hasil="30";
					break;

		}

		return $hasil;
	}
}
// ----------------------- FUNCTION  -----------------------
//Format tanggalan Indonesia:
/*	PARAM mode input :			
 *					0 : format YYYYMMDD
 *                  1 : format DDMMYYYY
 */
if (!function_exists("frm_tgl_id")) {

function frm_tgl_id($a="",$mode="0"){
	
	if($mode=="0"){	
		global $db;
		$b=$db->UserDate($a,"Y-m-d H:i:s");
		list ($fulltgl, $wkt) = split ('[ ]',$b);
		list ($thn, $bln, $tgl) = split ('[/.-]', $fulltgl);
	}else{
		list ($fulltgl, $wkt) = split ('[ ]',$a);
		list ($tgl, $bln, $thn) = split ('[/.-]', $fulltgl);
	}

	$hasil=$tgl." ".namaBulan($bln)." ".$thn;

	return $hasil;
}

}

// ----------------------- FUNCTION  -----------------------
if (!function_exists("date2str_new")) {
	function date2str_new($a = "",$mode="0"){
		global $db;
		$b=$db->UserDate($a,"Y-m-d H:i:s");
		list ($fulltgl, $wkt) = split ('[ ]',$b);
		list ($tahun, $bulan, $tanggal) = split ('[/.-]', $fulltgl);

		if ($mode=="0") {
			$hasil=$bulan."/".$tanggal."/".$tahun;
		} else {
			$hasil=$bulan."-".$tanggal."-".$tahun;
		}  // end of elsenya if ($mode=="0")

		return $hasil;
	}
} // end of if (!function_exists("sap2date"))

// ----------------------- FUNCTION  -----------------------
if (!function_exists("hitungTahunLahir")) {

function hitungTahunLahir($th_lahir,$bl_lahir,$tgl_lahir,$thn_skrg,$bln_skrg,$tgl_skrg) {
	

	if ($th_lahir <= $thn_skrg && $bl_lahir <= $bln_skrg && $tgl_lahir <= $tgl_skrg)
	return ($thn_skrg-$th_lahir);
	else {
		if ($bl_lahir > $bln_skrg && $tgl_lahir > $tgl_skrg)
		return ($thn_skrg-$th_lahir-1);
		else {
			if ($bl_lahir > $bln_skrg)
			return ($thn_skrg-$th_lahir-1);
			else {
				if ($bl_lahir == $bln_skrg && $tgl_lahir > $tgl_skrg)
				return ($thn_skrg-$th_lahir-1);
				else
				return ($thn_skrg-$th_lahir);
			}
		}
	}

	
}
}
if (!function_exists("hitungBulanLahir")) {

function hitungBulanLahir($th_lahir,$bl_lahir,$tgl_lahir,$thn_skrg,$bln_skrg,$tgl_skrg) {
	if ($bl_lahir <= $bln_skrg && $tgl_lahir <= $tgl_skrg){ 
		return $bln_skrg-$bl_lahir;
	}else{
			if($bl_lahir<=$bln_skrg){
				if ($tgl_lahir>$tgl_skrg) {
					if ($th_lahir<$thn_skrg) {
						if ($bl_lahir==$bln_skrg) {
							return 12-($bln_skrg-$bl_lahir + 1);
						}else {
							return $bln_skrg-$bl_lahir-1;
						}
					} else {
					return $bln_skrg-$bl_lahir-1;
					}
				}
			}else{
				if($tgl_lahir<=$tgl_skrg) 
					return 12-($bl_lahir-$bln_skrg);
			else return 12-($bl_lahir-$bln_skrg)-1;
			}
		}
}
}

if (!function_exists("hitungHariLahir")) {

function hitungHariLahir($th_lahir,$bl_lahir,$tgl_lahir,$thn_skrg,$bln_skrg,$tgl_skrg) {
	
	if ($tgl_lahir<=$tgl_skrg) return $tgl_skrg-$tgl_lahir;
		else {
		switch ($bl_lahir) {
		Case 1: case 3: case 5: case 7: case 8: case 10: case 12:
		return 31 - $tgl_lahir + $tgl_skrg;
		break;
		Case 2:
		if ($th_lahir % 4 == 0) return 29 - $tgl_lahir + $tgl_skrg;
		else 28 - $tgl_lahir + $tgl_skrg;
		break;
		default:
		return 30 - $tgl_lahir + $tgl_skrg;
		break;
		}
	}
}

}

if (!function_exists("hitungUmur")) {

function hitungUmur($asdew){
list ($th_lahir,$bl_lahir,$tgl_lahir,$jam,$mnt,$det) = split('[-:" "]',$asdew);
$birthDay=$tahun."-".$bulan."-".$tanggal;
$tgl_skrg=date("d");
$bln_skrg=date("m");
$thn_skrg=date("Y");
$tahun = hitungTahunLahir($th_lahir,$bl_lahir,$tgl_lahir,$thn_skrg,$bln_skrg,$tgl_skrg);
$bulan = hitungBulanLahir($th_lahir,$bl_lahir,$tgl_lahir,$thn_skrg,$bln_skrg,$tgl_skrg);
$hari = hitungHariLahir($th_lahir,$bl_lahir,$tgl_lahir,$thn_skrg,$bln_skrg,$tgl_skrg);
$umurnya= $tahun." Tahun ".$bulan." Bulan - ".$hari." hari";

return $umurnya;


}

}

// ----------------------- FUNCTION  -----------------------

if (!function_exists("TambahinNol")) {
	function TambahinNol($nomornya,$max_panjang){
		$panjang_mr=strlen($nomornya);
		$sisa_panjang=$max_panjang-$panjang_mr;
		$tambah_nol="";
		for($i=1;$i<=$sisa_panjang;$i++)
			{
				$tambah_nol=$tambah_nol."0";
			}
		$hasilnya=$tambah_nol.$nomornya;

	return $hasilnya;
	}	
} // end of if(!function_exists("TambahinNol"))

// ----------------------- FUNCTION  -----------------------

if (!function_exists("UmurV2")) {
	function UmurV2($tgl_lhr,$kondisi=0){
		$tgl_lhr=str_replace("T"," ",$tgl_lhr);
		$tgl_lhr=str_replace("Z"," ",$tgl_lhr);
		$interval = date_diff(date_create(), date_create($tgl_lhr));
		$val_thn=$interval->format("%Y");
		if(trim($kondisi)==0){
			if($val_thn >=1){ //>=1 thn tampil tahun & bulan
				$hasil=$interval->format("%Y<sup>th</sup>, %M<sup>bl</sup>");
			} else { //< 1thn tampil bulan & hari
				$hasil=$interval->format("%M<sup>bl</sup>, %d<sup>hr</sup>");
			}
		} else {

			//$hasil=$interval->format("You are  %Y Year, %M Months, %d Days, %H Hours, %i Minutes, %s Seconds Old");
			$hasil=$interval->format("%Y Th, %M Bln");
		}

	return $hasil;
	}	
} // end of if(!function_exists("TambahinNol"))


// ----------------------- FUNCTION  -----------------------
if (!function_exists("umur_rl")) {

function umur_rl($a = "") 
		{
			
		if($a=="")
		{
			$umurnya="-";

		}else
		{
		list ($fulltgl, $wkt) = split ('[ ]',$a);
		list ($tahun, $bulan, $tanggal) = split ('[/.-]', $fulltgl);
	
		$tgl_skrg=date("d");
		$bln_skrg=date("m");
		$thn_skrg=date("Y");

		if($bln_skrg==$bulan)
		{
			if($tgl_skrg<$tanggal)
			{
			$umurnya=$thn_skrg-$tahun-0.1;
			}
			else
			{
			$umurnya=$thn_skrg-$tahun;		
			}
		}
		elseif($bln_skrg<$bulan)
		{
		$umurnya=$thn_skrg-$tahun-1;
		$koma=(12-$bulan)+$bln_skrg;
		$koma=$koma/12;
		
		}
		else
		{
		$umurnya=$thn_skrg-$tahun;
		$koma=$bln_skrg-$bulan;
		$koma=$koma/12;
		
		}

		if($umurnya>0)
			{
				$umurnya=number_format($umurnya,0);
			}
			else
			{
				//$umurnya=number_format($umurnya+$koma,1);

				$jd1=GregorianToJD($bulan,$tanggal,$tahun);
				$jd2=GregorianToJD($bln_skrg,$tgl_skrg,$thn_skrg);
				$hari=$jd2-$jd1;

				$hitung_1=$hari/365;
				
				$limit=(1/365)+$hitung_1;

				$umurnya=$limit;


			}

		return $umurnya;
			}
	}
}

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