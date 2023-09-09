<?
require_once("../_lib/function/db.php");
loadlib("function","function.olah_tabel");
loadlib("/function/","function.max_kode_number");
loadlib("/function/01_registrasi","function.no_kunjungan");
loadlib("function/05_pm","function.no_antrian_pm");
loadlib("/function/05_pm","function.standar_hasil_lab");
loadlib("class","Tarif");


// ================================================== memilih tindakan / pemeriksaan PM ===============================================

/**
* Fungsi untuk memilih tindakan / pemeriksaan PM
*/
//cek_kiriman();
function simpan_standar_hasil_lab($kode_pemeriksaan)
{
	
	global $db;
	global $loginInfo;
	
	//////////////////////////////////////////
	
	//////////////////////////////////////////
	///////////////////variabel///////////////
	

	
	


	
	///////////////////////Perhitungan Billing/////////////////////////
	
	$kode_perusahaan= $sql->fields["kode_perusahaan"];
	$kode_klas = $sql->fields["kode_klas"];
	if ($kode_klas==""){
		$kode_klas = "5";	
	}
	$kopem=substr($kode_pemeriksaan,-2);
	$kopem=$kopem*1;
	//echo $kopem;
	$cek_masuk=baca_tabel("pm_tc_hasil_lab_detail","kode_penunjang","where kode_penunjang=$kode_penunjang");
	if($cek_masuk=="")
	{
		
		if($txt_kategori==1){
			$_sql = "select * from pm_isihasilluar_v where kode_penunjang=".$kode_penunjang;
		}else{
			$_sql = "select * from pm_isihasil_v where kode_penunjang=".$kode_penunjang;
		}

		$sql=&$db->Execute($_sql);
		
		$nama_tindakan= $sql->fields["nama_tindakan"];
		$nama_pemeriksaan= $sql->fields["nama_pemeriksaan"];
		$kode_mt_hasil_pm= $sql->fields["kode_mt_hasilpm"];



		while($oRS=$sql->Fetchrow())
		{
		

			///////////////////////////////////////////////////////////////////////

			$result = true;

			$db->BeginTrans();

			//////////////////////////////////////////////////////////////////////


			unset($insertPmTcHasilLabDetail);
			$sNilaiNormalNew=standar_hasil_lab($hitungTahunLahir,$hitungBulanLahir,$hitungHariLahir,0,$jen_kelamin,$kode_mt_hasil_pm);

			$insertPmTcHasilLabDetail["kode_penunjang"] = $kode_penunjang;
			$insertPmTcHasilLabDetail["nama_tindakan"] = $nama_tindakan;
			$insertPmTcHasilLabDetail["nm_pemeriksaan"] = $nama_pemeriksaan;
			$insertPmTcHasilLabDetail["hasil_pemeriksaan"] = $hasil_pemeriksaan;
			$insertPmTcHasilLabDetail["nilai_rujukan"] = $sNilaiNormalNew;
			$insertPmTcHasilLabDetail["satuan"] = $satuan;
			$insertPmTcHasilLabDetail["kode_mt_hasilpm"] = $kode_mt_hasilpm;
			$insertPmTcHasilLabDetail["kode_tarif"] = $kode_tarif;
			$result = insert_tabel("pm_tc_hasil_lab_detail", $insertPmTcHasilLabDetail);


			
			//////////////////////////////////////////////////////////////////////

			//$result=false;
			$db->CommitTrans($result !== false);

		}//end while



	}
				
}






?>