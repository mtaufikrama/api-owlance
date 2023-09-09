<?

	//require_once("../_lib/function/db.php");
	include "AvObjects.php";
	loadlib("function","function.variabel");
	loadlib("function","function.olah_tabel");


/************************************************/
/*		isi variabel kelas ri RS ASRI 			*/	
/*		( May Differ in Other Hospital )		*/
/*		1:	Super VIP							*/
/*		2:	VIP Plus							*/
/*		3:	VIP									*/
/*		4:	Standar								*/
/*		5:	VIP A								*/
/************************************************/

if(!class_exists("sensusinap")){
	class sensusinap{
		
		var $db;

		function sensusinap ($db, $bln, $thn, $frekuensi, $thn_rekap, $awal_triwulan, $akhir_triwulan, $kode_bagian){
		global $db;
		if ($frekuensi!=""){
			if ($frekuensi=="1"){
				$sql_2_satu = " month(tgl_masuk) ='$bln' and ";
				$sql_2_dua = " month(tgl_pindah) ='$bln' and ";
			} else if($frekuensi=="2") {
				$sql_2_satu = " (month(tgl_masuk) between '$awal_triwulan' and '$akhir_triwulan') and ";
				$sql_2_dua = " (month(tgl_pindah) between '$awal_triwulan' and '$akhir_triwulan') and ";
			} else {
				$sql_2_satu = "";
			}
		} else {
			$sql_2_satu = " month(tgl_masuk) ='$bln' and ";
			$sql_2_dua = " month(tgl_pindah) ='$bln' and ";
		}
		
		$sql="( SELECT 
			COUNT(kode_riw_klas) as jml, 
				kode_riw_klas,
				day(tgl_masuk)as tgl, 
				month(tgl_masuk) as bln, 
				year(tgl_masuk)as thn, 
				ket_masuk as status, 
				status_hidup, bagian_tujuan, 
				bagian_asal, 
				kelas_tujuan 
			
			FROM 
				ri_tc_riwayat_kelas 
			
			WHERE 
				$sql_2_satu 
				year(tgl_masuk)='$thn' and 
				bagian_tujuan = '$kode_bagian' 
			
			GROUP BY 
				tgl_masuk, 
				ket_masuk,  
				status_hidup, 
				bagian_tujuan, 
				bagian_asal, 
				kelas_tujuan,
				kode_riw_klas
			
			
			) 
			UNION

			(SELECT 
				COUNT(kode_riw_klas) as jml,
				kode_riw_klas,
				day(tgl_pindah)as tgl, 
				month(tgl_pindah) as bln, 
				year(tgl_pindah)as thn, 
				ket_keluar as status, 
				status_hidup, 
				bagian_tujuan, 
				bagian_asal, 
				kelas_tujuan 
			
			FROM 
				ri_tc_riwayat_kelas 
			
			WHERE 
				$sql_2_dua
				year(tgl_pindah)='$thn' and 
				bagian_tujuan = '$kode_bagian' 
			
			GROUP BY 
				tgl_pindah, 
				ket_keluar, 
				status_hidup, 
				bagian_tujuan, 
				bagian_asal, 
				kelas_tujuan,
				kode_riw_klas
				
			
			)ORDER BY
				thn,
				bln,
				tgl
			"; 
			
			$hasil =& $db->Execute($sql);
			while ($tampil=$hasil->FetchRow()) {
				
				$jml			= $tampil["jml"];
				$tgl			= $tampil["tgl"];
				$bln			= $tampil["bln"];
				$thn			= $tampil["thn"];
				$status			= $tampil["status"];
				$ket_masuk		= $tampil["ket_masuk"];
				$ket_keluar		= $tampil["ket_keluar"];
				$status_hidup	= $tampil["status_hidup"];
				$bagian_tujuan	= $tampil["bagian_tujuan"];
				$kelas_tujuan	= $tampil["kelas_tujuan"];
				
				$this->hasilCariPasien[$tgl][$status] +=$jml;
				$this->hasilCariPasienKelas[$tgl][$status][$kelas_tujuan] +=$jml;
				//echo $tgl."-".$ket_masuk."<br>";
			}
				/*
				echo "<pre style=\"border:1px solid bottom\">";
				print_r($this->hasilCariPasienKelas);
				echo "</pre>";
				//die();
				*/
		}
		
		function pasienMasuk($tgl){
			$hasil = $this->hasilCariPasien[$tgl][0];
			return $hasil;
		}
		function pasienMasukPindah($tgl){
			$hasil = $this->hasilCariPasien[$tgl][1];
			return $hasil;
		}
		function pasienKeluarPindah($tgl){
			$hasil = $this->hasilCariPasien[$tgl][2];
			return $hasil;
		}
		function pasienKeluarHidup($tgl){
			$hasil = $this->hasilCariPasien[$tgl][3];
			return $hasil;
		}
		function pasienKeluarMati($tgl){
			$hasil = $this->hasilCariPasien[$tgl][4];
			return $hasil;
		}
		function pasienMasukKelasVip($tgl){
			$hasil1 = $this->hasilCariPasienKelas[$tgl][0][3];
			$hasil2 = $this->hasilCariPasienKelas[$tgl][0][4];
			$hasil3 = $this->hasilCariPasienKelas[$tgl][1][3];
			$hasil4 = $this->hasilCariPasienKelas[$tgl][1][4];
			$hasil	= $hasil1+$hasil2+$hasil3+$hasil4;
			return $hasil;
		}
		function pasienMasukKelasI($tgl){
			$hasil1	= $this->hasilCariPasienKelas[$tgl][0][5];
			$hasil2	= $this->hasilCariPasienKelas[$tgl][1][5];
			$hasil	= $hasil1+$hasil2;
			return $hasil;
		}
		function pasienMasukKelasII($tgl){
			$hasil1	= $this->hasilCariPasienKelas[$tgl][0][6];
			$hasil2	= $this->hasilCariPasienKelas[$tgl][1][6];
			$hasil	= $hasil1+$hasil2;
			return $hasil;
		}
		function pasienMasukKelasIII($tgl){
			$hasil1	= $this->hasilCariPasienKelas[$tgl][0][7];
			$hasil2	= $this->hasilCariPasienKelas[$tgl][1][7];
			$hasil	= $hasil1+$hasil2;
			return $hasil;
		}
		function pasienKeluarKelasVip($tgl){
			$hasil1 = $this->hasilCariPasienKelas[$tgl][2][3];
			$hasil2 = $this->hasilCariPasienKelas[$tgl][2][5];

			$hasil3 = $this->hasilCariPasienKelas[$tgl][3][3];
			$hasil4 = $this->hasilCariPasienKelas[$tgl][3][5];

			$hasil5 = $this->hasilCariPasienKelas[$tgl][4][3];
			$hasil6 = $this->hasilCariPasienKelas[$tgl][4][5];
			$hasil	= $hasil1+$hasil2+$hasil3+$hasil4;
			return $hasil;
		}
		function pasienKeluarKelasI($tgl){
			$hasil1	= $this->hasilCariPasienKelas[$tgl][2][5];
			$hasil2	= $this->hasilCariPasienKelas[$tgl][3][5];
			$hasil3	= $this->hasilCariPasienKelas[$tgl][4][5];
			$hasil	= $hasil1+$hasil2+$hasil3;
			return $hasil;
		}
		function pasienKeluarKelasII($tgl){
			$hasil1	= $this->hasilCariPasienKelas[$tgl][2][6];
			$hasil2	= $this->hasilCariPasienKelas[$tgl][3][6];
			$hasil3	= $this->hasilCariPasienKelas[$tgl][4][6];
			$hasil	= $hasil1+$hasil2+$hasil3;
			return $hasil;
		}
		function pasienKeluarKelasIII($tgl){
			$hasil1	= $this->hasilCariPasienKelas[$tgl][2][7];
			$hasil2	= $this->hasilCariPasienKelas[$tgl][3][7];
			$hasil3	= $this->hasilCariPasienKelas[$tgl][4][7];
			$hasil	= $hasil1+$hasil2+$hasil3;
			return $hasil;
		}


	}
}
?>