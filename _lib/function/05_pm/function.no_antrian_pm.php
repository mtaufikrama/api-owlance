<?
require_once("../_lib/function/db.php");
loadlib("function","function.olah_tabel");
loadlib("function","function.max_kode_number");
loadlib("function","function.max_kode_text");

// ================================================== mencari nomor antrian pm ==============================================//

		/**
		 * Fungsi untuk mendapatkan nomor urut pemeriksaan pm (sesuai dg kode_bagian) yang berikutnya. 
		 * Urutan akan kembali ke 1 apabila pemeriksaan dilakukan pada hari yang berbeda 
		 * dengan pemeriksaan sebelumnya.
		 *
		 * Hasil : $iNoUrutBerikutnya = Nomor urut pemeriksaan pm berikutnya
		 */
		 function no_antrian_pm($kode_bagian)
		 {

			 $iNoUrutBerikutnya=max_kode_number("pm_tc_penunjang","no_antrian","WHERE " .
					   "kode_bagian = '" . $kode_bagian . "' AND " .
					   "day(tgl_daftar) = " . date ("d") . " AND " .
					   "month(tgl_daftar) = " . date ("m") . " AND " .
					   "year(tgl_daftar) = " . date ("Y"));
			
			 return $iNoUrutBerikutnya;
		 }

		 function no_pemeriksaan_pm($kode_bagian)
		 {
			$yy=date("y");
			$mm=date("m");
			$dd=date("d");

			$iNoUrutBerikutnya=baca_tabel("pm_tc_penunjang","count(no_hasil_pm)","where no_hasil_pm is not null and kode_bagian='" . $kode_bagian . "' and month(tgl_daftar) =".date ("m")." and year(tgl_daftar) =" . date ("Y")." and day(tgl_daftar) =".date("d"))+1;

			//$iNoUrutBerikutnya=baca_tabel("pm_tc_penunjang","count(no_hasil_pm)","where no_hasil_pm is not null and kode_bagian='" . $kode_bagian . "' and month(tgl_daftar) =".date ("m")." and year(tgl_daftar) =" . date ("Y"))+1;

			//$iNoUrutBerikutnya=max_kode_text("pm_tc_penunjang","no_hasil_pm","where kode_bagian='" . $kode_bagian . "' and day(tgl_daftar) =".date ("d")."and month(tgl_daftar) =".date ("m")." and year(tgl_daftar) =" . date ("Y"));
			
			if($iNoUrutBerikutnya==1)
			 {
				$next_number=$yy.$mm.$dd.$iNoUrutBerikutnya;
			 }else
			 {
				 //$next_number="0".$iNoUrutBerikutnya;
				$next_number=$yy.$mm.$dd.$iNoUrutBerikutnya;
			 }
			
			
					

			return $next_number;
		 }
?>