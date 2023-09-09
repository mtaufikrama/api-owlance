<?
require_once("../_lib/function/db.php");
loadlib("function","function.olah_tabel");
loadlib("function","function.max_kode_number");
loadlib("function","function.max_kode_text");

// ================================================== mencari nomor antrian MCU ==============================================//

		/**
		 * Fungsi untuk mendapatkan nomor urut pemeriksaan MCU (sesuai dg kode_bagian) yang berikutnya. 
		 * Urutan akan kembali ke 1 apabila pemeriksaan dilakukan pada hari yang berbeda 
		 * dengan pemeriksaan sebelumnya.
		 *
		 * Hasil : $iNoUrutBerikutnya = Nomor urut pemeriksaan pm berikutnya
		 */
		
		 function no_pemeriksaan_mcu($kode_mcu)
		 {
			

			$iNoUrutBerikutnya=baca_tabel("pl_tc_poli","max(no_hasil_mcu)","where  kode_bagian='010901'  and year(tgl_jam_poli) =" . date ("Y"))+1;
			$panjang_mr=strlen($iNoUrutBerikutnya);
			$sisa_panjang=4-$panjang_mr;
			$tambah_nol="";
			for($i=1;$i<=$sisa_panjang;$i++){
			 $tambah_nol=$tambah_nol."0";
			}
			$noMcu=$tambah_nol.$iNoUrutBerikutnya;

			/*-----------------------------*/
			$cekNoMcu==baca_tabel("pl_tc_poli","year(tgl_jam_poli)","where  kode_bagian='010901'  and kode_gcu=".$kode_mcu);
			$cekThn=date("Y");

			if($cekNoMcu != $cekThn){
				}else{
				$noMcu=$noMcu;
			}

			return $noMcu;
		 }
?>