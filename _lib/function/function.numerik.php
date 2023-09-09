<?
// ----------------------- FUNCTION angka_romawi -----------------------

if (!function_exists("angka_romawi")) {
	function angka_romawi($angka) {
		// sementara sampe 12 dulu lagi males mikir, utamanya cuma buat banyaknya bulan doang hehe...

		$satuan="I";
		$limaan="V";
		$puluhan="X";

		if ($angka==1) $hasil="I";
		elseif ($angka==2) $hasil="II";
		elseif ($angka==3) $hasil="III";
		elseif ($angka==4) $hasil="IV";
		elseif ($angka==5) $hasil="V";
		elseif ($angka==6) $hasil="VI";
		elseif ($angka==7) $hasil="VII";
		elseif ($angka==8) $hasil="VIII";
		elseif ($angka==9) $hasil="IX";
		elseif ($angka==10) $hasil="X";
		elseif ($angka==11) $hasil="XI";
		elseif ($angka==12) $hasil="XII";

		return $hasil;
	} // end of function angka_romawi($angka)
} // end of if(!function_exists("angka_romawi"))

// ----------------------- FUNCTION hitung_next_month -----------------------

/**
 * hitung_next_month() : Gak mudhengg !!!
 *
 * @param  string  $tgl_lengkap  Inputan
 * @param  int     $thn          ???
 * @param  int     $bln          ???
 *
 * @return array
 *
 */

if(!function_exists("hitung_next_month"))
	function hitung_next_month($tgl_lengkap,$thn,$bln) {
		global $db;
		$b=$db->UserDate($tgl_lengkap,"Y-m-d H:i:s");
		list ($fulltgl, $wkt) = split ('[ ]',$b);
		list ($tahun, $bulan, $tanggal) = split ('[/.-]', $fulltgl);

		$total_bulan=($thn*12)+$bln;

		$bulan2=($total_bulan+$bulan) % 12;
		
		$tahunxx=floor(($total_bulan+$bulan)/12);
		
		$tahun2=$tahun+$tahunxx;

		$tgl_hasil="$tahun2-$bulan2-$tanggal";

		$hasil[0]="$tahun2-$bulan2-$tanggal";
		$hasil[1]="$tanggal-$bulan2-$tahun2";
		$hasil[2]=$total_bulan;


		return $hasil;
	} // end of function hitung_next_month($tgl_lengkap,$thn,$bln)
} // end of if(!function_exists("hitung_next_month"))

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


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


?>