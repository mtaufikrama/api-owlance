<?
// ----------------------- FUNCTION errHandler -----------------------

/**
 * errHandler() : user-defined (or library-maker-defined :P ) error handler 
 *
 * @param  int     $errno    Error Code
 * @param  string  $errstr   Error String
 * @param  string  $errfile  Error File
 * @param  int     $errline  Error Line Number
 *
 */

if (!function_exists("errHandler")) {
	function errHandler($errno, $errstr, $errfile, $errline) {
		global $errNoShow, $errStrShow;
		$errStrShow = (strlen($errStrShow) == 0)?(addslashes($errstr)):($errStrShow);
		$errNoShow = (strlen($errNoShow) == 0)?($errno):($errNoShow);
	}

	set_error_handler("errHandler");
} // end of if (!function_exists("errHandler"))

// ----------------------- FUNCTION genapin_baris -----------------------

/**
 * genapin_baris() : Nggenepin baris dalam tabel sampe berapa baris
 *
 * @param  int  $total_baris   Total baris seluruhnya
 * @param  int  $baris_yg_ada  Baris yang ada sekarang
 * @param  int  $jumlah_td     Jumlah td yang ada di tr tersebut
 * @param  int  $mode          Style mode :
 *                             0 atau NULL : full styled
 *                             1 : polosan aja
 *
 */

if (!function_exists("genapin_baris")) {
	function genapin_baris($total_baris="",$baris_yg_ada="",$jumlah_td="5",$mode="") {
		if ($baris_yg_ada>0) {
			$baris_yg_ada=$baris_yg_ada+1;
		}

		$bgcolor=($bgcolor==$bgcolor_1)?$bgcolor_2:$bgcolor_1;

		$poles=" class='box-thno' align='right' style='padding-right:4px; '";

		$sisa=$total_baris-$baris_yg_ada;

		for ($baris=1;$baris<=$sisa;$baris++) {
			$bgcolor=($bgcolor=="#EFEFF7")?"#F7F7FF":"#EFEFF7";

			// jika polosan aja
			if ($mode=="1") {
				$bgcolor="";	
				$poles="";	
				$class="class='border-r'";
			}
?>
		<tr bgcolor="<?=$bgcolor?>">
			<td <?=$poles?> <?=$class?>> &nbsp; </td>
<?
			for ($hh=1;$hh<=$jumlah_td;$hh++) {
				if ($hh==$jumlah_td) {
					$class="";
				}
?>
			<td <?= $class?> >&nbsp;</td>
<?
			} // end of for($hh=1;$hh<=$jumlah_td;$hh++):
?>
		</tr>
<?
		} // end of for ($baris=1;$baris<=$sisa;$baris++)

	} // end of function genapin_baris($total_baris="",$baris_yg_ada="",$jumlah_td="5",$mode="")
} // end of if (!function_exists("genapin_baris"))

// ----------------------- FUNCTION genapin_char -----------------------

/**
 * genapin_char() : str_pad() bikinan sendiri
 *
 * @param  int   $nomornya     Nomor yang akan ditambah panjangnya (bisa juga pake string)
 * @param  int   $max_panjang  Panjang yang dikehendaki
 * @param  char  $char         karakter buat nambahin
 * @param  int   $mode         Mode :
 *                             0 atau NULL : nambahin $char di depan string asli
 *                             1 : nambahin $char di belakang string asli
 *
 * @return string
 *
 */

if (!function_exists("genapin_char")) {
	function genapin_char($nomornya,$max_panjang,$char="",$mode="") {
		$panjang=strlen($nomornya);
		$sisa_panjang=$max_panjang-$panjang;
		$tambah_char="";

		if ($sisa_panjang>0) {
			for($i=1;$i<=$sisa_panjang;$i++) {
				$tambah_char=$tambah_char.$char;
			}
		}

		if ($mode=="1") {
			$hasilnya=$nomornya.$tambah_char;
		} else {
			$hasilnya=$tambah_char.$nomornya;
		}

		return $hasilnya;
	} // end of function genapin_char($nomornya,$max_panjang,$char="",$mode="")
} // end of if (!function_exists("genapin_baris"))

// ----------------------- FUNCTION lempar_ke -----------------------

/**
 * lempar_ke() : Generate HTML code untuk melempar page tersebut ke file lain
 *
 * @param  string  $url  URL tujuan
 *
 */

if (!function_exists("lempar_ke")) {
	function lempar_ke($url) {
?>
<html><head><title>LEMPAR KE FILE LAIN</title></head><body onload=javascript:location.href='<?=$url?>'></body></html>
<?
	} // end of function lempar_ke($url)
} // end of if (!function_exists("lempar_ke"))

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