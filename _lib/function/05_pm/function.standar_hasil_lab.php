<?
require_once("../_lib/function/db.php");
loadlib("function","function.olah_tabel");
loadlib("function","function.max_kode_number");
loadlib("function","function.max_kode_text");
loadlib("function","function.array2table");

// ================================================== mencari nomor antrian pm ==============================================//

		/**
		 * Fungsi untuk mendapatkan standar hasil lab. 
		 */
		 function standar_hasil_lab($umur_tahun=0,$umur_bulan=0,$umur_hari=0,$umur_jam=0,$jenis_kelamin,$kode_mt_hasil_pm)
		 {
			
			// lihat di dd_mktime untuk nilainya, biar gak banyak buka database saya taruh langsung aja deh

				 $mktime_tahun=31622400 * $umur_tahun;
				 $mktime_bulan=2678400 * $umur_bulan;
				 $mktime_hari=86400 * $umur_hari;
				 $mktime_jam=3600 * $umur_jam;
				 
			 $mktimenya=$mktime_tahun + $mktime_bulan + $mktime_hari + $mktime_jam;
					 
				 //$mktimenya=mktime($umur_jam,0,0,$umur_bulan,$umur_hari,$umur_tahun);
			 if($jenis_kelamin=="L"){$field_hasil="standar_hasil_pria";}else{$field_hasil="standar_hasil_wanita";}
			 $prahasil=read_tabel("pm_standarhasil_detail_v","keterangan,$field_hasil","where kode_mt_hasilpm='$kode_mt_hasil_pm' AND mktime_umur_mulai<=$mktimenya AND mktime_umur_akhir>$mktimenya");
				
				while ($hasildb=$prahasil->FetchRow()) {
						$hasil[0]=$hasildb[$field_hasil];
						$hasil[1]=$hasildb["keterangan"];
					}

			 return $hasil;
		 }

		/**
		 * Fungsi untuk mendapatkan standar hasil lab seluruhnya/perkode_tarif. 
		 */
		 function standar_hasil_lab_all($kode_tarif="",$print="")
		 {
			 if($kode_tarif!=""){$sql_kondisi="WHERE kode_tarif='$kode_tarif' ";}
			 $hasil=read_tabel("pm_standarhasil_detail_v","*","$sql_kondisi");
			
			
			if($print=="1"){
				var_dump($hasil);
				
			array2table($hasil);
			}
			
			return $hasil;
		 }


?>