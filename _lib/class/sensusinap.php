<?

	//require_once("../_lib/function/db.php");
	require_once("../_configs/constants_12_rekammedis.php");
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

				if($jml < 0){
					$jml = 0;
				}

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
		
		////////////////////////////////////////////////////////////////////////////////////////
		function pasienMasuk($tgl){
			$hasil = $this->hasilCariPasien[$tgl][AV_RM_FL_MASUK];
			return $hasil;
		}
		function pasienMasukPindah($tgl){
			$hasil = $this->hasilCariPasien[$tgl][AV_RM_FL_PINDAH];
			return $hasil;
		}
		function pasienKeluarPindah($tgl){
			$hasil = $this->hasilCariPasien[$tgl][AV_RM_FL_DIPINDAH];
			return $hasil;
		}
		function pasienKeluarHidup($tgl){
			$hasil = $this->hasilCariPasien[$tgl][AV_RM_FL_KELUAR_HIDUP];
			return $hasil;
		}
		function pasienKeluarMati($tgl){
			$hasil = $this->hasilCariPasien[$tgl][AV_RM_FL_KELUAR_MATI];
			return $hasil;
		}

		////////////////////////////////////////////////////////////////////////////////////////

		function pasienMasukKelasA($tgl){
			$hasil1	= $this->hasilCariPasienKelas[$tgl][AV_RM_FL_MASUK][AV_RM_CL_KELAS_A];
			$hasil2	= $this->hasilCariPasienKelas[$tgl][AV_RM_FL_PINDAH][AV_RM_CL_KELAS_A];
			$hasil = $hasil1+ $hasil2;
			return $hasil;
		}
		
		function pasienMasukKelasB($tgl){
			$hasil1	= $this->hasilCariPasienKelas[$tgl][AV_RM_FL_MASUK][AV_RM_CL_KELAS_B];
			$hasil2	= $this->hasilCariPasienKelas[$tgl][AV_RM_FL_PINDAH][AV_RM_CL_KELAS_B];
			$hasil = $hasil1 + $hasil2;
			return $hasil;
		}
		
		function pasienMasukKelasC($tgl){
			$hasil1	= $this->hasilCariPasienKelas[$tgl][AV_RM_FL_MASUK][AV_RM_CL_KELAS_C];
			$hasil2	= $this->hasilCariPasienKelas[$tgl][AV_RM_FL_PINDAH][AV_RM_CL_KELAS_C];
			$hasil = $hasil1 + $hasil2;
			return $hasil;
		}

		function pasienMasukKelasD($tgl){
			$hasil1	= $this->hasilCariPasienKelas[$tgl][AV_RM_FL_MASUK][AV_RM_CL_KELAS_D];
			$hasil2	= $this->hasilCariPasienKelas[$tgl][AV_RM_FL_PINDAH][AV_RM_CL_KELAS_D];
			$hasil = $hasil1 + $hasil2;
			return $hasil;
		}

		function pasienMasukKelasE($tgl){
			$hasil1	= $this->hasilCariPasienKelas[$tgl][AV_RM_FL_MASUK][AV_RM_CL_KELAS_E];
			$hasil2	= $this->hasilCariPasienKelas[$tgl][AV_RM_FL_PINDAH][AV_RM_CL_KELAS_E];
			$hasil = $hasil1 + $hasil2;
			return $hasil;
		}

		function pasienMasukKelasF($tgl){
			$hasil1	= $this->hasilCariPasienKelas[$tgl][AV_RM_FL_MASUK][AV_RM_CL_KELAS_F];
			$hasil2	= $this->hasilCariPasienKelas[$tgl][AV_RM_FL_PINDAH][AV_RM_CL_KELAS_F];
			$hasil = $hasil1 + $hasil2;
			return $hasil;
		}


		function pasienMasukKelasG($tgl){
			$hasil1	= $this->hasilCariPasienKelas[$tgl][AV_RM_FL_MASUK][AV_RM_CL_KELAS_G];
			$hasil2	= $this->hasilCariPasienKelas[$tgl][AV_RM_FL_PINDAH][AV_RM_CL_KELAS_G];
			$hasil = $hasil1 + $hasil2;
			return $hasil;
		}


		function pasienMasukKelasH($tgl){
			$hasil1	= $this->hasilCariPasienKelas[$tgl][AV_RM_FL_MASUK][AV_RM_CL_KELAS_H];
			$hasil2	= $this->hasilCariPasienKelas[$tgl][AV_RM_FL_PINDAH][AV_RM_CL_KELAS_H];
			$hasil = $hasil1 + $hasil2;
			return $hasil;
		}

		function pasienMasukKelasI($tgl){
			$hasil1	= $this->hasilCariPasienKelas[$tgl][AV_RM_FL_MASUK][AV_RM_CL_KELAS_I];
			$hasil2	= $this->hasilCariPasienKelas[$tgl][AV_RM_FL_PINDAH][AV_RM_CL_KELAS_I];
			$hasil = $hasil1 + $hasil2;
			return $hasil;
		}

		function pasienMasukKelasJ($tgl){
			$hasil1	= $this->hasilCariPasienKelas[$tgl][AV_RM_FL_MASUK][AV_RM_CL_KELAS_J];
			$hasil2	= $this->hasilCariPasienKelas[$tgl][AV_RM_FL_PINDAH][AV_RM_CL_KELAS_J];
			$hasil = $hasil1 + $hasil2;
			return $hasil;
		}
		

		////////////////////////////////////////////////////////////////////////////////////////

		function pasienKeluarKelasA($tgl){
			$hasil1 = $this->hasilCariPasienKelas[$tgl][AV_RM_FL_DIPINDAH][AV_RM_CL_KELAS_A];
			$hasil2 = $this->hasilCariPasienKelas[$tgl][AV_RM_FL_KELUAR_HIDUP][AV_RM_CL_KELAS_A];
			$hasil3 = $this->hasilCariPasienKelas[$tgl][AV_RM_FL_KELUAR_MATI][AV_RM_CL_KELAS_A];
			$hasil = $hasil1+$hasil2+$hasil3;
			return $hasil;
		}

		function pasienKeluarKelasB($tgl){
			$hasil1 = $this->hasilCariPasienKelas[$tgl][AV_RM_FL_DIPINDAH][AV_RM_CL_KELAS_B];
			$hasil2 = $this->hasilCariPasienKelas[$tgl][AV_RM_FL_KELUAR_HIDUP][AV_RM_CL_KELAS_B];
			$hasil3 = $this->hasilCariPasienKelas[$tgl][AV_RM_FL_KELUAR_MATI][AV_RM_CL_KELAS_B];
			$hasil = $hasil1+$hasil2+$hasil3;
			return $hasil;
		}

		function pasienKeluarKelasC($tgl){
			$hasil1 = $this->hasilCariPasienKelas[$tgl][AV_RM_FL_DIPINDAH][AV_RM_CL_KELAS_C];
			$hasil2 = $this->hasilCariPasienKelas[$tgl][AV_RM_FL_KELUAR_HIDUP][AV_RM_CL_KELAS_C];
			$hasil3 = $this->hasilCariPasienKelas[$tgl][AV_RM_FL_KELUAR_MATI][AV_RM_CL_KELAS_C];
			$hasil = $hasil1+$hasil2+$hasil3;
			return $hasil;
		}

		function pasienKeluarKelasD($tgl){
			$hasil1 = $this->hasilCariPasienKelas[$tgl][AV_RM_FL_DIPINDAH][AV_RM_CL_KELAS_D];
			$hasil2 = $this->hasilCariPasienKelas[$tgl][AV_RM_FL_KELUAR_HIDUP][AV_RM_CL_KELAS_D];
			$hasil3 = $this->hasilCariPasienKelas[$tgl][AV_RM_FL_KELUAR_MATI][AV_RM_CL_KELAS_D];
			$hasil = $hasil1+$hasil2+$hasil3;
			return $hasil;
		}

		function pasienKeluarKelasE($tgl){
			$hasil1 = $this->hasilCariPasienKelas[$tgl][AV_RM_FL_DIPINDAH][AV_RM_CL_KELAS_E];
			$hasil2 = $this->hasilCariPasienKelas[$tgl][AV_RM_FL_KELUAR_HIDUP][AV_RM_CL_KELAS_E];
			$hasil3 = $this->hasilCariPasienKelas[$tgl][AV_RM_FL_KELUAR_MATI][AV_RM_CL_KELAS_E];
			$hasil = $hasil1+$hasil2+$hasil3;
			return $hasil;
		}


		function pasienKeluarKelasF($tgl){
			$hasil1 = $this->hasilCariPasienKelas[$tgl][AV_RM_FL_DIPINDAH][AV_RM_CL_KELAS_F];
			$hasil2 = $this->hasilCariPasienKelas[$tgl][AV_RM_FL_KELUAR_HIDUP][AV_RM_CL_KELAS_F];
			$hasil3 = $this->hasilCariPasienKelas[$tgl][AV_RM_FL_KELUAR_MATI][AV_RM_CL_KELAS_F];
			$hasil = $hasil1+$hasil2+$hasil3;
			return $hasil;
		}


		function pasienKeluarKelasG($tgl){
			$hasil1 = $this->hasilCariPasienKelas[$tgl][AV_RM_FL_DIPINDAH][AV_RM_CL_KELAS_G];
			$hasil2 = $this->hasilCariPasienKelas[$tgl][AV_RM_FL_KELUAR_HIDUP][AV_RM_CL_KELAS_G];
			$hasil3 = $this->hasilCariPasienKelas[$tgl][AV_RM_FL_KELUAR_MATI][AV_RM_CL_KELAS_G];
			$hasil = $hasil1+$hasil2+$hasil3;
			return $hasil;
		}

		function pasienKeluarKelasH($tgl){
			$hasil1 = $this->hasilCariPasienKelas[$tgl][AV_RM_FL_DIPINDAH][AV_RM_CL_KELAS_H];
			$hasil2 = $this->hasilCariPasienKelas[$tgl][AV_RM_FL_KELUAR_HIDUP][AV_RM_CL_KELAS_H];
			$hasil3 = $this->hasilCariPasienKelas[$tgl][AV_RM_FL_KELUAR_MATI][AV_RM_CL_KELAS_H];
			$hasil = $hasil1+$hasil2+$hasil3;
			return $hasil;
		}

		function pasienKeluarKelasI($tgl){
			$hasil1 = $this->hasilCariPasienKelas[$tgl][AV_RM_FL_DIPINDAH][AV_RM_CL_KELAS_I];
			$hasil2 = $this->hasilCariPasienKelas[$tgl][AV_RM_FL_KELUAR_HIDUP][AV_RM_CL_KELAS_I];
			$hasil3 = $this->hasilCariPasienKelas[$tgl][AV_RM_FL_KELUAR_MATI][AV_RM_CL_KELAS_I];
			$hasil = $hasil1+$hasil2+$hasil3;
			return $hasil;
		}

		function pasienKeluarKelasJ($tgl){
			$hasil1 = $this->hasilCariPasienKelas[$tgl][AV_RM_FL_DIPINDAH][AV_RM_CL_KELAS_J];
			$hasil2 = $this->hasilCariPasienKelas[$tgl][AV_RM_FL_KELUAR_HIDUP][AV_RM_CL_KELAS_J];
			$hasil3 = $this->hasilCariPasienKelas[$tgl][AV_RM_FL_KELUAR_MATI][AV_RM_CL_KELAS_J];
			$hasil = $hasil1+$hasil2+$hasil3;
			return $hasil;
		}



		////////////////////////////////////////////////////////////////////////////////////////
	}
}
?>