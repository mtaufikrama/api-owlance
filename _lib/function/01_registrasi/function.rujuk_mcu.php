<?
require_once("../_lib/function/db.php");
include "../_configs/constants.php";
loadlib("function","function.olah_tabel");
loadlib("function","function.max_kode_number");
loadlib("function","function.datetime");
loadlib("/function/05_pm","function.simpan_tindakan_pm");


function pasien_rujuk_mcu($no_registrasi,$no_mr,$kode_dokter,$kode_bagian_masuk,$kode_bagian_asal,$tgl_masuk,$status_cito="",$keterangan="",$jenis_rujuk="1",$no_induk="",$smf="",$no_kunjungan_asal,$kode_referensi,$kode_mt_mcu,$bill_rs,$bill_dr,$bill_total,$nama_tindakan_det,$kode_tarif_mcu,$nama_tarif_paket,$kode_mcu,$kode_trans_pelayanan_paket_mcu,$kode_dokter2="")
{
$sub_kode_bagian=substr($kode_bagian_masuk,0,2);
	

global $db,$result;
	/*
	1. insert  ke tc_kunjungan
	2. inser ke pl_tc_poli apabila dari dari mcu ke poli
	3. insert kunjungan baru
	4. update tabel tc_kunjungan berdasarkan tc kunjungan baru jika pm	
	*/
	

	//////////////////////////////////////////////////////////////////////



	// task 1 , Masukan Ke tc_kunjungan do it ------------------------
	unset($insertTcKunjungan);
	$cek_no_kunjungan=baca_tabel("tc_kunjungan","kode_bagian_tujuan","where kode_bagian_tujuan='".$kode_bagian_masuk."' AND kode_bagian_asal='".$kode_bagian_asal."' AND no_registrasi=".$no_registrasi);

	if($cek_no_kunjungan=="" && $kode_bagian_masuk != AV_MCU ){
	$no_kunjungan=max_kode_number("tc_kunjungan","no_kunjungan");

	$insertTcKunjungan["no_kunjungan"] = $no_kunjungan;
	$insertTcKunjungan["no_registrasi"] = $no_registrasi;
	$insertTcKunjungan["no_mr"] = $no_mr;
	//if($kode_bagian_asal==$kode_bagian_masuk){
	$insertTcKunjungan["kode_dokter"] = $kode_dokter;
	//}
	$insertTcKunjungan["kode_bagian_tujuan"] = $kode_bagian_masuk;
	$insertTcKunjungan["kode_bagian_asal"] = $kode_bagian_asal;
	$insertTcKunjungan["tgl_masuk"] = $tgl_masuk;
	$insertTcKunjungan["status_masuk"] = 1;
	$insertTcKunjungan["status_cito"] = $status_cito; 
	$insertTcKunjungan["keterangan"] = $keterangan;
	$insertTcKunjungan["id_mt_smf"] = $smf;
	$insertTcKunjungan["status_mcu"] = 1;
	if($no_induk==''){
		$no_induk=$loginInfo["no_induk"];
	}
	$insertTcKunjungan["no_induk"] = $no_induk;
	
	if($result !== false) $result=insert_tabel("tc_kunjungan", $insertTcKunjungan);
	}

	///////////////////////////////////////////////////////////////////////////////////	
	// task 2 masukin ke pl_tc_poli------------------------------------------------------

	///////////////////////////////////////////////////////////////////////////////////
	
	if($sub_kode_bagian=="01" && $kode_bagian_masuk != AV_MCU  ){
			$no_kunjungannya=baca_tabel("tc_kunjungan","no_kunjungan","where kode_bagian_tujuan='".$kode_bagian_masuk."' AND kode_bagian_asal='".$kode_bagian_asal."' AND no_registrasi=".$no_registrasi);
			$cek_detail_poli =baca_tabel("pl_tc_poli","kode_bagian","where kode_bagian <> '012901' AND kode_bagian ='".$kode_bagian_masuk."' AND no_kunjungan=".$no_kunjungannya);
			if($cek_detail_poli==""){

			///////////////////////////////////////////////////////////////////////////////////
			// task 2 masukin ke pl_tc_poli------------------------------------------------------
			$dNow=date("d");
			$mNow=date("m");
			$yNow=date("Y");

			$kode_poli1=max_kode_number("pl_tc_poli","kode_poli");

			$no_antrian=max_kode_number("pl_tc_poli","no_antrian","WHERE YEAR(tgl_jam_poli)=".$yNow." AND MONTH(tgl_jam_poli)=".$mNow." AND DAY(tgl_jam_poli)=".$dNow." AND kode_bagian='".$kode_bagian_masuk."'  AND flag_ri IS  NULL");

				if($no_kunjungan!=""){
					unset($insertPlTcPoli);

					$insertPlTcPoli["kode_poli"]					= $kode_poli1;
					$insertPlTcPoli["no_kunjungan"]					= $no_kunjungannya;
					$insertPlTcPoli["kode_bagian"]					= $kode_bagian_masuk;
					$insertPlTcPoli["tgl_jam_poli"]					= $tgl_masuk;
					$insertPlTcPoli["no_antrian"]					= $no_antrian;
					$insertPlTcPoli["no_induk"]						= $no_induk;
					$insertPlTcPoli["no_registrasi"]				= $no_registrasi;
					$insertPlTcPoli["kode_dokter"]					= $kode_dokter;
					$insertPlTcPoli["flag_mcu"]						= 1;
					$insertPlTcPoli["flag_bayar_konsul"]			= 2;
					if ($result !== false) $result=insert_tabel("pl_tc_poli", $insertPlTcPoli);
				}

			///////////////////////////////////////////////////////////////////////////////////

			
			}
	}

	//////////////////////////////////////////////////////////////////////////////////
	//Daftarin Ke PenunjangNya
	if($sub_kode_bagian=='05'){
		$no_kunjungannya=baca_tabel("tc_kunjungan","no_kunjungan","where kode_bagian_tujuan='".$kode_bagian_masuk."' AND kode_bagian_asal='".$kode_bagian_asal."' AND no_registrasi=".$no_registrasi);
		$cek_detail_pm =baca_tabel("pm_tc_penunjang","kode_bagian","where  kode_bagian ='".$kode_bagian_masuk."' AND no_kunjungan=".$no_kunjungannya);
			if($cek_detail_pm==""){

			///////////////////////////////////////////////////////////////////////////////////
				if($kode_dokter!=""){
					$nama_dokter=baca_tabel("mt_karyawan","nama_pegawai","where kode_dokter='".$kode_dokter."'");
				}

				$no_induk=$loginInfo["no_induk"];
				$kode_penunjang=max_kode_number("pm_tc_penunjang","kode_penunjang");
				$isi_pm_tc_penunjang["kode_penunjang"]=$kode_penunjang;
				$isi_pm_tc_penunjang["tgl_daftar"]=$tgl_masuk;
				$isi_pm_tc_penunjang["kode_bagian"]=$kode_bagian_masuk;
				$isi_pm_tc_penunjang["no_kunjungan"]=$no_kunjungannya;
				$isi_pm_tc_penunjang["dr_pengirim"]=$nama_dokter;
				$isi_pm_tc_penunjang["asal_daftar"]=$kode_bagian_asal;
				$isi_pm_tc_penunjang["no_antrian"]=no_antrian_pm($kode_bagian_tujuan);
				$isi_pm_tc_penunjang["petugas_input"]=$userInfo["id_dd_user"];
				$isi_pm_tc_penunjang["kode_klas"]=16;
				$isi_pm_tc_penunjang["no_kunjungan_asal"]=$no_kunjungan_asal;
				$isi_pm_tc_penunjang["status_daftar"]=1;
				$isi_pm_tc_penunjang["flag_mcu"]= 1;
				if ($result !== false) $result=insert_tabel("pm_tc_penunjang", $isi_pm_tc_penunjang);
				
				
			 }
			/////////////////////////////////////////////////////////////////////
		

	}

	///////////////////////////////////////////////////////////////////////////////////
				//masukin ke tc_trans_pelayanan_paket

	//////////////////////////////////////////////////////////////////////
		
		$cari_no_kunjungan=baca_tabel("tc_kunjungan","no_kunjungan","where kode_bagian_tujuan='".$kode_bagian_masuk."' AND kode_bagian_asal='".$kode_bagian_asal."' AND no_registrasi=".$no_registrasi);
		$kode_penunjangnya=baca_tabel("pm_tc_penunjang","kode_penunjang","where  kode_bagian ='".$kode_bagian_masuk."' AND no_kunjungan=".$cari_no_kunjungan);
		
		$cek_ada=baca_tabel("tc_trans_pelayanan_paket_mcu","no_registrasi","where  no_registrasi =".$no_registrasi);
		
		if($cek_ada==""){

			unset($insertTcTransPelayananPaketMcu);
			$tgl_transaksi=date("Y-m-d H:i:s");
			$insertTcTransPelayananPaketMcu["no_kunjungan"] = $no_kunjungannya;
			$insertTcTransPelayananPaketMcu["no_registrasi"] = $no_registrasi;
			$insertTcTransPelayananPaketMcu["kode_tarif_mcu"] = $kode_tarif_mcu;
			$insertTcTransPelayananPaketMcu["no_mr"] = $no_mr;
			$insertTcTransPelayananPaketMcu["tgl_transaksi"] = $tgl_transaksi;
			$insertTcTransPelayananPaketMcu["kode_mt_mcu"] = $kode_mt_mcu;
			$insertTcTransPelayananPaketMcu["nama_tindakan"] = $nama_tindakan_det;
			$insertTcTransPelayananPaketMcu["nama_tindakan_paket"] = $nama_tarif_paket;
			$insertTcTransPelayananPaketMcu["kode_bagian"] = $kode_bagian_masuk;
			$insertTcTransPelayananPaketMcu["kode_bagian_asal"] = $kode_bagian_asal;
			$insertTcTransPelayananPaketMcu["bill_rs"] = $bill_rs;
			$insertTcTransPelayananPaketMcu["bill_dr"] = $bill_dr;
			$insertTcTransPelayananPaketMcu["bill_dr1"] = $bill_dr2;
			$insertTcTransPelayananPaketMcu["bill_total"] = $bill_total;
			$insertTcTransPelayananPaketMcu["jumlah"] = 1;
			$insertTcTransPelayananPaketMcu["status_selesai"] = 3;
			$insertTcTransPelayananPaketMcu["kode_tarif_detail"] = $kode_referensi;
			$insertTcTransPelayananPaketMcu["kode_penunjang"] = $kode_penunjangnya;
			$insertTcTransPelayananPaketMcu["kode_mcu"] = $kode_mcu;
			$insertTcTransPelayananPaketMcu["kode_dokter_mcu"] = $kode_dokter;
			$insertTcTransPelayananPaketMcu["kode_dokter_mcu_2"] = $kode_dokter2;
			if ($result !== false) $result= insert_tabel("tc_trans_pelayanan_paket_mcu", $insertTcTransPelayananPaketMcu);

		}else{

			unset($insertTcTransPelayananPaketMcu);
			$insertTcTransPelayananPaketMcu["nama_tindakan"] = $nama_tindakan_det;
			$insertTcTransPelayananPaketMcu["nama_tindakan_paket"] = $nama_tarif_paket;
			$insertTcTransPelayananPaketMcu["status_selesai"] = 3;
                        if($kode_bagian_masuk == AV_MCU){
                            $no_kunjungannya = $no_kunjungan_asal;
                        }
			$insertTcTransPelayananPaketMcu["no_kunjungan"] = $no_kunjungannya;
			$insertTcTransPelayananPaketMcu["kode_dokter_mcu"] = $kode_dokter;
			$insertTcTransPelayananPaketMcu["kode_dokter_mcu_2"] = $kode_dokter2;
                        $insertTcTransPelayananPaketMcu["kode_penunjang"] = $kode_penunjangnya;
			if ($result !== false) $result= update_tabel("tc_trans_pelayanan_paket_mcu", $insertTcTransPelayananPaketMcu," WHERE no_registrasi=".$no_registrasi." and kode_tarif_detail=".$kode_referensi." AND kode_trans_pelayanan_paket_mcu = $kode_trans_pelayanan_paket_mcu");
		
		}
	//////////////////////////////////////////////////////////////////////
	

}
/////////////////////////////////////////////////////////////////////////////////////////////////////////
function pasien_keluar_bagian($no_kunjungan,$status_meninggal="")
{	
	global $db;

		if($tgl_keluar==""):
			$tgl_keluar=date("Y-m-d H:i:s");
		endif;


		//1. Update Kunjungan

		$edit_kunjungan["tgl_keluar"]=$tgl_keluar;
		if($status_meninggal==""){
			$edit_kunjungan["status_keluar"]=3;
		}else{
			$edit_kunjungan["status_keluar"]=$status_meninggal;
		}

		update_tabel("tc_kunjungan",$edit_kunjungan,"Where no_kunjungan=$no_kunjungan and  tgl_keluar IS NULL ");

      

}
/////////////////////////////////////////////////////////////////////////////////////////////////////////

?>