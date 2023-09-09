<?
require_once("../_lib/function/db.php");
include "../_configs/constants.php";
loadlib("function","function.olah_tabel");
loadlib("/function/01_registrasi","function.no_kunjungan");
loadlib("function/05_pm","function.no_antrian_pm");
loadlib("class","Tarif");
//require_once '../02_poli/ajax_cek_diskon.php';

	
// ================================================== memilih tindakan / pemeriksaan PM ===============================================

/**
* Fungsi untuk memilih tindakan / pemeriksaan PM
*/
//cek_kiriman();
function cek_diskon($no_registrasi="",$kode_tarif="",$kode_bagian="",$sql_kondisi)
{
//echo ' cek Diskon '.$no_registrasi.' : '.$kode_tarif.' : '.$kode_bagian.' : '.$sql_kondisi.' : ';
//cek_kiriman();
//$db->debug=TRUE;
$cek_all=read_tabel("tc_registrasi","*","where no_registrasi=$no_registrasi");
$kode_bagian_voucher=$cek_all->fields('kode_bagian_voucher');
$cek_dapat_voucher=$cek_all->fields('flag_voucher');

//$db->debug=FALSE;
if($kode_bagian==$kode_bagian_voucher){

if($cek_dapat_voucher==1)
{
$kode_bagian=baca_tabel("tc_registrasi","kode_bagian_voucher","where no_registrasi=$no_registrasi");
$flag_diskon=baca_tabel("mt_voucher","flag_diskon","where kode_bagian=$kode_bagian");
if($flag_diskon==2){
	$cek_voucher_tarif=baca_tabel("mt_voucher","diskon","where kode_tarif=$kode_tarif AND kode_bagian=$kode_bagian");
	$diskon= $cek_voucher_tarif/100;
	}else
	{
	$cek_tarif_luar=baca_tabel("mt_master_tarif","flag_pemeriksaan_luar","where kode_tarif=$kode_tarif");
	if($cek_tarif_luar==1){
	$cek_voucher_tarif=baca_tabel("mt_voucher","diskon","where kode_bagian=$kode_bagian");
	$diskon= $cek_voucher_tarif/100;
	}
	}
	//echo $diskon;
	
	return $diskon;
}
}

}

function cito($kode_bagian)
{
	global $db;
	///////////////////variabel///////////////

	$nilai_cito=baca_tabel("pm_mt_kenaikancito","prosentase","WHERE kode_bagian='".$kode_bagian."'");
	$kenaikan_cito=($nilai_cito*0.01)+1;
	return $kenaikan_cito;
}


function simpan_tindakan_pm($kode_pemeriksaan,$kode_bagian, $kode_penunjang,$cito,$kode_dokter1,$kode_dokter2,$no_foto,$dokter_pengirim1,$dokter_pengirim2,$kode_bagian_asal,$txt_kategori,$id_dd_user,$acc_pola="",$id_dd_rujuk_rs="",$bill_rs_rujukan="",$diag="")
{
	
	global $db;
	global $loginInfo;
	
	//////////////////////////////////////////
	
	//////////////////////////////////////////
	///////////////////variabel///////////////
	

	if($txt_kategori==1)
	{
		$_sql = "select * from pm_pasienluar_v where kode_penunjang=".$kode_penunjang;
	}else
	{
		$_sql = "select * from pm_pasienpm_v where kode_penunjang=".$kode_penunjang;
	}

	$sql=&$db->Execute($_sql);
	
	$kode_kunjungan= $sql->fields["no_kunjungan"];
	$no_mr= $sql->fields["no_mr"];
	$nama_pasien= $sql->fields["nama_pasien"];
	
	//$no_registrasi=baca_tabel("tc_registrasi","no_registrasi","WHERE no_mr='$no_mr' and tgl_jam_keluar IS NULL and status_batal IS NULL and kode_bagian_masuk='".$kode_bagian_asal."'");
	$no_kunjungan=baca_tabel("pm_tc_penunjang","no_kunjungan","WHERE kode_penunjang=".$kode_penunjang);
	$no_registrasi=baca_tabel("tc_kunjungan","no_registrasi","WHERE no_kunjungan=".$no_kunjungan);


	$kode_kelompok= $sql->fields["kode_kelompok"];
	if($kode_kelompok=="")
	{
		$kode_kelompok=1;
	}
	$kode_dokter= $sql->fields["kode_dokter"];
	$tgl_transaksi= $sql->fields["tgl_daftar"];
	if($dokter_pengirim2=="")
	{
		$dokter_pengirim=$dokter_pengirim1;
		$flag_dr_pengirim='0';
	}elseif($dokter_pengirim1=="")
	{
		$dokter_pengirim=$dokter_pengirim2;
		$flag_dr_pengirim='1';
	}elseif($dokter_pengirim1=="0")
	{
		$dokter_pengirim=$dokter_pengirim2;
		$flag_dr_pengirim='1';
	}else
	{
		$dokter_pengirim="-";
		$flag_dr_pengirim='';
	}


	$kode_dokter1=$kode_dokter1;
	$kode_dokter2=$kode_dokter2;
	$kode_ri=0;
	$kode_poli=0;
	$jumlah=1;
	$kode_ri=0;
	$kode_barang="";
	$kode_penunjang=$kode_penunjang;
	$kode_depo_stok=0;
	$kode_gd=0;
	$kode_master_tarif_detail=$kode_master_tarif_detail;
	$kd_tr_resep=0;
	
	///////////////////update perubahan cito- tc_kunjungan///////////////
	$editTcKunjungan["status_cito"] = $cito;
	$result = update_tabel("tc_kunjungan", $editTcKunjungan, "WHERE no_kunjungan=$no_kunjungan");

	///////////////////update pm_tc_penunjang///////////////////////////
	$editPmTcPenunjang["petugas_input"] = $loginInfo["id_dd_user"];
	$editPmTcPenunjang["no_foto"] = $no_foto;
	$editPmTcPenunjang["dr_pengirim"] = $dokter_pengirim;
	$editPmTcPenunjang["flag_dr_pengirim"] = $flag_dr_pengirim;
    $editPmTcPenunjang["diagnosa"] = $diag;
	$result = update_tabel("pm_tc_penunjang", $editPmTcPenunjang, "WHERE kode_penunjang=".$kode_penunjang);

	
	///////////////////////Perhitungan Billing/////////////////////////
	
	$kode_perusahaan= $sql->fields["kode_perusahaan"];
	$kode_klas = $sql->fields["kode_klas"];
	if ($kode_klas==""){
		$kode_klas = "5";	
	}
	$kopem=substr($kode_pemeriksaan,-2);
	$kopem=$kopem*1;
	
	if($kopem==0)
	{
		if($acc_pola==''){
			$tabelnya="mt_master_tarif";
			$sqlPluss="";
		}else{
			/*$tabelnya="mt_master_tarif_perusahaan";
			$sqlPluss=" AND acc_pola=$acc_pola";*/

			
			$tabelnya="mt_master_tarif";
			$sqlPluss="";
		}

		//$_sqlo = "select * from mt_master_tarif where referensi=".$kode_pemeriksaan;
		$_sqlo = "select * from ".$tabelnya." where referensi=".$kode_pemeriksaan." ".$sqlPluss;
		$sql=&$db->Execute($_sqlo);

		while($oRS=$sql->Fetchrow())
		{
			$kode_trans_pelayanan=max_kode_number("tc_trans_pelayanan","kode_trans_pelayanan");

			$kode_anak= $oRS["kode_tarif"];
			$jenis_tindakan=3;

			unset($insertXxTrins);
			
			$tarifUmum=new Tarif();
			$tarifUmum->set("kode_tarif",$kode_anak);
			$tarifUmum->set("jumlah",1);
			$tarifUmum->set("kode_klas",$kode_klas);
			$tarifUmum->set("kode_kelompok",$kode_kelompok);
			$tarifUmum->set("kode_bagian",$kode_bagian);
			$tarifUmum->set("cito",$cito);
			$tarifUmum->set("acc_pola",$acc_pola);
			$insertXxTrins=$tarifUmum->hitung();
			
			///////////////////////////////////////////////////////////////////////

			$result = true;

			

			//////////////////////////////////////////////////////////////////////


			$insertXxTrins["kode_trans_pelayanan"] = $kode_trans_pelayanan;
			$insertXxTrins["no_kunjungan"] = $kode_kunjungan;
			$insertXxTrins["no_registrasi"] = $no_registrasi;
			$insertXxTrins["no_mr"] = $no_mr;
			$insertXxTrins["nama_pasien_layan"] = $nama_pasien;
			$insertXxTrins["kode_kelompok"] = $kode_kelompok;
			$insertXxTrins["kode_dokter"] = $kode_dokter;
			$insertXxTrins["kode_perusahaan"] = $kode_perusahaan;
			$insertXxTrins["tgl_transaksi"] = $tgl_transaksi;
			$insertXxTrins["jenis_tindakan"] = $jenis_tindakan;
			//$insertXxTrins["nama_tindakan"] = $nama_tindakan;
			//$insertXxTrins["bill_rs"] = $bill_rs;
			//$insertXxTrins["bill_dr1"] = $bill_dr1;
			//$insertXxTrins["bill_dr2"] = $bill_dr2;
			$insertXxTrins["kode_dokter1"] = $kode_dokter1;
			$insertXxTrins["kode_dokter2"] = $kode_dokter2;
			$insertXxTrins["kode_ri"] = $kode_ri;
			$insertXxTrins["kode_poli"] = $kode_poli;
			$insertXxTrins["jumlah"] = $jumlah;
			$insertXxTrins["kode_barang"] = $kode_barang;
			$sql_kondisi="flag_pemeriksaan_luar=1 and tingkatan=5";
			$diskon=cek_diskon($no_registrasi,$kode_anak,$kode_bagian,$sql_kondisi);
		//echo $diskon;
			if($diskon!=""){
			$insertXxTrins["diskon"]=($insertXxTrins['bill_rs']+$insertXxTrins['bill_dr1']+$insertXxTrins['bill_dr2']+$insertXxTrins['bill_dr3'])*$diskon;
			}	
			$insertXxTrins["kode_penunjang"] = $kode_penunjang;
			$insertXxTrins["kode_depo_stok"] = $kode_depo_stok;
			$insertXxTrins["kode_gd"] = $kode_gd;
			//$insertXxTrins["kode_master_tarif_detail"] = $kode_master_tarif_detail;
			//$insertXxTrins["kode_tarif"] = $kode_tarif;
			$insertXxTrins["kd_tr_resep"] = $kd_tr_resep;
			
			//---------cek daftar lanjutan
			$flag_daftar=baca_tabel("pm_tc_penunjang","flag_daftar","where kode_penunjang=$kode_penunjang");
			if($flag_daftar>1){
				$insertXxTrins["status_selesai"] = 53;
			}else{
				$insertXxTrins["status_selesai"] = 1;
			}
			$insertXxTrins["kode_bagian"] = $kode_bagian;
			$insertXxTrins["id_dd_user"] = $id_dd_user;
			$insertXxTrins["kode_bagian_asal"] = $kode_bagian_asal;
			
			$cekSudahada=baca_tabel("tc_trans_pelayanan","kode_trans_pelayanan"," where kode_penunjang=$kode_penunjang and kode_tarif=$kode_anak");
			
			if($cekSudahada==""){
				if($result) $result = insert_tabel("tc_trans_pelayanan", $insertXxTrins);
			}
		//////////////////////////////////////////////////////////////////////
		if($id_dd_rujuk_rs!='')
			{
				//PUNK-24/04/2013-9:33:53 *kata CUY1 harga rujukan sama dengan harga rs
				//$bill_rs_total=submit_uang($bill_rs)+submit_uang($bill_rs_rujukan);
				$kode_trans_pelayanan=baca_tabel("tc_trans_pelayanan","max(kode_trans_pelayanan)","where no_registrasi=$no_registrasi");
				$fld["no_registrasi"] = $no_registrasi;
				//$fld["bill_rs"] = $bill_rs_total;
				$fld["bill_rs"] = submit_uang($bill_rs);
				$fld["bill_rs_rujukan"] = submit_uang($bill_rs_rujukan);
				//$fld["bill_rs_laba_rujukan"] = submit_uang($bill_rs);
				$fld["bill_dr1"] = $bill_dr1;
				$fld["id_dd_rujuk_rs"] = $id_dd_rujuk_rs;
				if($result) $result = update_tabel("tc_trans_pelayanan",$fld,"WHERE kode_trans_pelayanan=".$kode_trans_pelayanan);
			}
		//////////////////////////////////////////////////////////////////////

			//$result=false;
			
			return $result;

		}//end while



	}else 
	{
		$kode_trans_pelayanan=max_kode_number("tc_trans_pelayanan","kode_trans_pelayanan");

		unset($insertXxTrins);
		
		$tarifUmum=new Tarif();
		$tarifUmum->set("kode_tarif",$kode_pemeriksaan);
		$tarifUmum->set("jumlah",1);
		$tarifUmum->set("kode_klas",$kode_klas);
		$tarifUmum->set("kode_kelompok",$kode_kelompok);
		$tarifUmum->set("kode_bagian",$kode_bagian);
		$tarifUmum->set("cito",$cito);
		$tarifUmum->set("acc_pola",$acc_pola);
		$insertXxTrins=$tarifUmum->hitung();
		
		$bill_rs=$insertXxTrins["bill_rs"];
		$bill_dr1=$insertXxTrins["bill_dr1"];
		

		//show($insertXxTrins);
		$jenis_tindakan=3;
		

		///////////////////////////////////////////////////////////////////////

		$result = true;

		

		//////////////////////////////////////////////////////////////////////


		$insertXxTrins["kode_trans_pelayanan"] = $kode_trans_pelayanan;
		$insertXxTrins["no_kunjungan"] = $kode_kunjungan;
		$insertXxTrins["no_registrasi"] = $no_registrasi;
		$insertXxTrins["no_mr"] = $no_mr;
		$insertXxTrins["nama_pasien_layan"] = $nama_pasien;
		$insertXxTrins["kode_kelompok"] = $kode_kelompok;
		$insertXxTrins["kode_dokter"] = $kode_dokter;
		$insertXxTrins["kode_perusahaan"] = $kode_perusahaan;
		$insertXxTrins["tgl_transaksi"] = $tgl_transaksi;
		$insertXxTrins["jenis_tindakan"] = $jenis_tindakan;
		//$insertXxTrins["nama_tindakan"] = $nama_tindakan;
		//$insertXxTrins["bill_rs"] = $bill_rs;
		//$insertXxTrins["bill_dr1"] = $bill_dr1;
		//$insertXxTrins["bill_dr2"] = $bill_dr2;

		if($dokter_pengirim1!="" && $kode_bagian==AV_FISIOTERAPI){

			$kode_fiso=baca_tabel("mt_karyawan","kode_dokter"," where nama_pegawai='".$dokter_pengirim1."'");
			$insertXxTrins["kode_dokter1"] = $kode_fiso;

		}else{

			$insertXxTrins["kode_dokter1"] = $kode_dokter1;

		}
		if($kode_bagian==AV_FISIOTERAPI){
			$insertXxTrins["kode_dokter3"] = $kode_dokter1;
		}

		$insertXxTrins["kode_dokter2"] = $kode_dokter2;
		$insertXxTrins["kode_ri"] = $kode_ri;
		$insertXxTrins["kode_poli"] = $kode_poli;
		$insertXxTrins["jumlah"] = $jumlah;
		$insertXxTrins["kode_barang"] = $kode_barang;
		$sql_kondisi="flag_pemeriksaan_luar=1 and tingkatan=5";
		$diskon=cek_diskon($no_registrasi,$kode_pemeriksaan,$kode_bagian,$sql_kondisi);
		//echo $diskon;
		if($diskon!=""){
		$insertXxTrins["diskon"]=($insertXxTrins['bill_rs']+$insertXxTrins['bill_dr1']+$insertXxTrins['bill_dr2']+$insertXxTrins['bill_dr3'])*$diskon;
		}	
		$insertXxTrins["kode_penunjang"] = $kode_penunjang;
		$insertXxTrins["kode_depo_stok"] = $kode_depo_stok;
		$insertXxTrins["kode_gd"] = $kode_gd;
		//$insertXxTrins["kode_master_tarif_detail"] = $kode_master_tarif_detail;
		//$insertXxTrins["kode_tarif"] = $kode_tarif;
		$insertXxTrins["kd_tr_resep"] = $kd_tr_resep;
		$flag_daftar=baca_tabel("pm_tc_penunjang","flag_daftar","where kode_penunjang=$kode_penunjang");
			if($flag_daftar>1){
				$insertXxTrins["status_selesai"] = 53;
			}else{
				$insertXxTrins["status_selesai"] = 2;
			}
		$insertXxTrins["kode_bagian"] = $kode_bagian;
		$insertXxTrins["kode_bagian_asal"] = $kode_bagian_asal;
		$insertXxTrins["id_dd_user"] = $id_dd_user;
		
		$cekSudahada=baca_tabel("tc_trans_pelayanan","kode_trans_pelayanan"," where kode_penunjang=$kode_penunjang and kode_tarif=$kode_pemeriksaan");
			
			
			
		if($cekSudahada==""){	
			$result = insert_tabel("tc_trans_pelayanan", $insertXxTrins);
		}
		//////////////////////////////////////////////////////////////////////
		if($id_dd_rujuk_rs!='')
			{
				//PUNK-24/04/2013-9:33:53 *kata CUY1 harga rujukan sama dengan harga rs
				//$bill_rs_total=submit_uang($bill_rs)+submit_uang($bill_rs_rujukan);
				$kode_trans_pelayanan=baca_tabel("tc_trans_pelayanan","max(kode_trans_pelayanan)","where no_registrasi=$no_registrasi");
				$fld["no_registrasi"] = $no_registrasi;
				//$fld["bill_rs"] = $bill_rs_total;
				$fld["bill_rs"] = submit_uang($bill_rs);
				$fld["bill_rs_rujukan"] = submit_uang($bill_rs_rujukan);
				//$fld["bill_rs_laba_rujukan"] = submit_uang($bill_rs);
				$fld["bill_dr1"] = $bill_dr1;
				$fld["id_dd_rujuk_rs"] = $id_dd_rujuk_rs;
				$result = update_tabel("tc_trans_pelayanan",$fld,"WHERE kode_trans_pelayanan=".$kode_trans_pelayanan);
			}
		//////////////////////////////////////////////////////////////////////

		//$result=false;
		return $result;
		
	}//end if kode_pemeriksaan=semua
				
}



function daftar_tindakanrujukan_pm($no_mr,$kode_bagian_asal,$kode_bagian_tujuan,$kode_klas,$id_dd_user,$diag="",$jenis_bayar="",$noregistrasi="",$nokunjunganlama="")
{
	global $db;
	global $loginInfo;
	
	//////////////////////////////////////////
	
	//////////////////////////////////////////

	// Masukin Ke nomor kunjungan sekalian registrasi
	
	$txt_tanggal_masuk=date("Y-m-d H:i:s");
	$stat_pasien=0;
	$status_cito=0;
	$kode_dokter=0;

	$no_kunjungan=pasien_rujuk($no_mr,$kode_dokter,$kode_bagian_tujuan,$kode_bagian_asal,$txt_tanggal_masuk,$status_cito="",$keterangan="",$jenis_rujuk="2",$noregistrasi,$nokunjunganlama);


		//Masukin ke Penunjang Medis
		  //1. Dapatkan kode_penunjang--
		  
			$kode_penunjang=max_kode_number("pm_tc_penunjang","kode_penunjang");

		 //2.Daftarin Ke PenunjangNya

			 if($no_kunjungan!=""){
				$isi_pm_tc_penunjang["kode_penunjang"]=$kode_penunjang;
				$isi_pm_tc_penunjang["tgl_daftar"]=$txt_tanggal_masuk;
				$isi_pm_tc_penunjang["kode_bagian"]=$kode_bagian_tujuan;
				$isi_pm_tc_penunjang["no_kunjungan"]=$no_kunjungan;
				$isi_pm_tc_penunjang["asal_daftar"]=$kode_bagian_asal;
				$isi_pm_tc_penunjang["no_antrian"]=no_antrian_pm($kode_bagian_tujuan);
				$isi_pm_tc_penunjang["petugas_input"]=$userInfo["id_dd_user"];
				$isi_pm_tc_penunjang["kode_klas"]=$kode_klas;
				$isi_pm_tc_penunjang["flag_pembayaran"]=$jenis_bayar;
                $isi_pm_tc_penunjang["diagnosa"]=$diag;
				insert_tabel("pm_tc_penunjang",$isi_pm_tc_penunjang);
			 }
	$arrReturn["no_kunjungan"]=$no_kunjungan;
	$arrReturn["kode_penunjang"]=$kode_penunjang;
	return $arrReturn;


}



function simpan_tindakanrujukan_pm($kode_pemeriksaan,$kode_bagian_pm, $kode_penunjang,$cito,$kode_dokter1,$kode_dokter2,$no_foto,$dokter_pengirim,$kode_bagian_asal,$no_registrasi,$id_dd_user,$diag="",$jenis_bayar="")
{
	global $db;
	
	///////////////////variabel///////////////

	if($kode_penunjang=="")
	 {
	$arr_data=daftar_tindakanrujukan_pm($no_mr,$kode_bagian_asal,$kode_bagian_tujuan,$kode_klas,$id_dd_user,$diag,$jenis_bayar,$no_registrasi);
	$no_kunjungan=$arr_data["no_kunjungan"];
	$kode_penunjang=$arr_data["kode_penunjang"];
	 }	
	 
	$_sql = "select * from pm_pasienpm_v where kode_penunjang=".$kode_penunjang;
	$sql=&$db->Execute($_sql);

	$kode_kunjungan= $sql->fields["no_kunjungan"];
	$no_mr= $sql->fields["no_mr"];
	$nama_pasien = $sql->fields["nama_pasien"];

	$kode_kelompok= $sql->fields["kode_kelompok"];
	if($kode_kelompok=="")
	{
		$kode_kelompok=1;
	}
	$kode_dokter= $sql->fields["kode_dokter"];
	$tgl_transaksi= $sql->fields["tgl_daftar"];

	
	$kode_dokter1=$kode_dokter1;
	$kode_dokter2=$kode_dokter2;
	$kode_ri=0;
	$kode_poli=0;
	$jumlah=1;
	$kode_ri=0;
	$kode_barang="";
	$kode_penunjang=$kode_penunjang;
	$kode_depo_stok=0;
	$kode_gd=0;
	$kode_master_tarif_detail=$kode_master_tarif_detail;
	$kd_tr_resep=0;
	
	///////////////////update perubahan cito- tc_kunjungan///////////////
	$editTcKunjungan["status_cito"] = $cito;
	$result = update_tabel("tc_kunjungan", $editTcKunjungan, "WHERE no_kunjungan=$kode_kunjungan");

	
	///////////////////update pm_tc_penunjang///////////////////////////
	$editPmTcPenunjang["petugas_input"] = $loginInfo["id_dd_user"];
	$editPmTcPenunjang["no_foto"] = $no_foto;
	$editPmTcPenunjang["dr_pengirim"] = $dokter_pengirim;
    $editPmTcPenunjang["diagnosa"] = $diag;
	$editPmTcPenunjang["flag_pembayaran"] = $jenis_bayar;
	$result = update_tabel("pm_tc_penunjang", $editPmTcPenunjang, "WHERE kode_penunjang=".$kode_penunjang);

	
	///////////////////////Perhitungan Billing/////////////////////////
	
	$kode_perusahaan= $sql->fields["kode_perusahaan"];
	$kode_klas= $sql->fields["kode_klas"];

	$kopem=substr($kode_pemeriksaan,-2);
	$kopem=$kopem*1;
	//echo $kopem;
	if($kode_bagian_pm==AV_BAGCATHLAB){
	$kopem=1;
	}
	if($kopem==0)
	{

		$_sqlo = "select * from mt_master_tarif where referensi=".$kode_pemeriksaan;
		$sql=&$db->Execute($_sqlo);
        // echo "test";
		while($oRS=$sql->Fetchrow())
		{
			$kode_trans_pelayanan=max_kode_number("tc_trans_pelayanan","kode_trans_pelayanan");
			

			$kode_anak= $oRS["kode_tarif"];
			$jenis_tindakan=3;

			unset($insertXxTrins);
			
			$tarifUmum=new Tarif();
			$tarifUmum->set("kode_tarif",$kode_anak);
			$tarifUmum->set("jumlah",1);
			$tarifUmum->set("kode_klas",$kode_klas);
			$tarifUmum->set("kode_kelompok",$kode_kelompok);
			$tarifUmum->set("kode_bagian",$kode_bagian_pm);
			$tarifUmum->set("cito",$cito);
			$insertXxTrins=$tarifUmum->hitung();
			
			///////////////////////////////////////////////////////////////////////

			$result = true;

			$db->BeginTrans();

			//////////////////////////////////////////////////////////////////////


			$insertXxTrins["kode_trans_pelayanan"] = $kode_trans_pelayanan;
			$insertXxTrins["no_kunjungan"] = $kode_kunjungan;
			$insertXxTrins["no_registrasi"] = $no_registrasi;
			$insertXxTrins["no_mr"] = $no_mr;
			$insertXxTrins["nama_pasien_layan"] = $nama_pasien;
			$insertXxTrins["kode_kelompok"] = $kode_kelompok;
			$insertXxTrins["kode_dokter"] = $kode_dokter;
			$insertXxTrins["kode_perusahaan"] = $kode_perusahaan;
			$insertXxTrins["tgl_transaksi"] = $tgl_transaksi;
			$insertXxTrins["jenis_tindakan"] = $jenis_tindakan;
			$insertXxTrins["kode_dokter1"] = $kode_dokter1;
			$insertXxTrins["kode_dokter2"] = $kode_dokter2;
			$insertXxTrins["kode_ri"] = $kode_ri;
			$insertXxTrins["kode_poli"] = $kode_poli;
			$insertXxTrins["jumlah"] = $jumlah;
			$insertXxTrins["kode_barang"] = $kode_barang;
			$sql_kondisi="flag_pemeriksaan_luar=1 and tingkatan=5";
			$diskon=cek_diskon($no_registrasi,$kode_pemeriksaan,$kode_bagian_pm,$sql_kondisi);
		//echo $diskon;
			if($diskon!=""){
			$insertXxTrins["diskon"]=($insertXxTrins['bill_rs']+$insertXxTrins['bill_dr1']+$insertXxTrins['bill_dr2']+$insertXxTrins['bill_dr3'])*$diskon;
			}	
			$insertXxTrins["kode_penunjang"] = $kode_penunjang;
			$insertXxTrins["kode_depo_stok"] = $kode_depo_stok;
			$insertXxTrins["kode_gd"] = $kode_gd;
			$insertXxTrins["kd_tr_resep"] = $kd_tr_resep;
			$insertXxTrins["status_selesai"] = 2;
			$insertXxTrins["kode_bagian"] = $kode_bagian_pm;
			$insertXxTrins["id_dd_user"] = $id_dd_user;
			$insertXxTrins["kode_bagian_asal"] = $kode_bagian_asal;
			$cekSudahada=baca_tabel("tc_trans_pelayanan","kode_trans_pelayanan"," where kode_penunjang=$kode_penunjang and kode_tarif=$kode_anak");
			
			
			
			if($cekSudahada==""){
			
			$result = insert_tabel("tc_trans_pelayanan", $insertXxTrins);
			}
			//////////////////////////////////////////////////////////////////////

			//$result=false;
			$db->CommitTrans($result !== false);

		}//end while

			


	}else if($kode_bagian_pm==AV_BAGCATHLAB)
	{
	
		$kode_trans_pelayanan=max_kode_number("tc_trans_pelayanan","kode_trans_pelayanan");

		unset($insertXxTrins);
		
		$tarifUmum=new Tarif();
		$tarifUmum->set("kode_tarif",$kode_pemeriksaan);
		$tarifUmum->set("jumlah",1);
		$tarifUmum->set("kode_klas",$kode_klas);
		$tarifUmum->set("kode_kelompok",$kode_kelompok);
		$tarifUmum->set("kode_bagian",$kode_bagian_pm);
		$tarifUmum->set("cito",$cito);
		$insertXxTrins=$tarifUmum->hitung();
		//show($insertXxTrins);
		//die;
		$jenis_tindakan=3;

		
		//////perhitungan kenaikan tarif/ potongan tarif utk pasien perusahaan/ askes dan lain-lain//////

		///////////////////////////////////////////////////////////////////////


		$result = true;

		$db->BeginTrans();

		//////////////////////////////////////////////////////////////////////


		$insertXxTrins["kode_trans_pelayanan"] = $kode_trans_pelayanan;
		$insertXxTrins["no_kunjungan"] = $kode_kunjungan;
		$insertXxTrins["no_registrasi"] = $no_registrasi;
		$insertXxTrins["no_mr"] = $no_mr;
		$insertXxTrins["nama_pasien_layan"] = $nama_pasien;
		$insertXxTrins["kode_kelompok"] = $kode_kelompok;
		$insertXxTrins["kode_dokter"] = $kode_dokter;
		$insertXxTrins["kode_perusahaan"] = $kode_perusahaan;
		$insertXxTrins["tgl_transaksi"] = $tgl_transaksi;
		$insertXxTrins["jenis_tindakan"] = $jenis_tindakan;
		$insertXxTrins["kode_dokter1"] = $kode_dokter1;
		$insertXxTrins["kode_dokter_op1"] = $kode_dokter2;
		$insertXxTrins["kode_dokter2"] = $dokter_pengirim;
		$insertXxTrins["kode_dokter3"] = 0;
		$insertXxTrins["bill_dr3"] = 0;
		
		if($kode_dokter2>0)
		{
		$insertXxTrins["bill_dr_op1"] =$insertXxTrins["bill_dr2"];		
		$insertXxTrins["bill_dr2"]=0;
		}
		if($kode_dokter3=='0')
		{		
		$insertXxTrins["bill_dr3"] = 0;
		}

		if($dokter_pengirim > 0){
		if($kode_klas==1){
		$biaya_anestesi=840000;
		}else if($kode_klas==2){
		$biaya_anestesi=750000;
		}else if($kode_klas==3){
		$biaya_anestesi=660000;
		}else if($kode_klas==4 || $kode_klas==16){
		$biaya_anestesi=600000;
		}else if($kode_klas==5){
		$biaya_anestesi=540000;
		}else if($kode_klas==17){
		$biaya_anestesi=960000;
		}else{
		$biaya_anestesi=660000;
		}
		$insertXxTrins["bill_dr2"] = $biaya_anestesi;
		}else{
		$insertXxTrins["bill_dr2"] = 0;
		}
		$insertXxTrins["kode_ri"] = $kode_ri;
		$insertXxTrins["kode_poli"] = $kode_poli;
		$insertXxTrins["jumlah"] = $jumlah;
		$insertXxTrins["kode_barang"] = $kode_barang;
		$sql_kondisi="flag_pemeriksaan_luar=1 and tingkatan=5";
		$diskon=cek_diskon($no_registrasi,$kode_pemeriksaan,$kode_bagian_pm,$sql_kondisi);
		//echo $diskon;
			if($diskon!=""){
			$insertXxTrins["diskon"]=($insertXxTrins['bill_rs']+$insertXxTrins['bill_dr1']+$insertXxTrins['bill_dr2']+$insertXxTrins['bill_dr3'])*$diskon;
			}
				
		$insertXxTrins["kode_penunjang"] = $kode_penunjang;
		$insertXxTrins["kode_depo_stok"] = $kode_depo_stok;
		$insertXxTrins["kode_gd"] = $kode_gd;
		$insertXxTrins["kd_tr_resep"] = $kd_tr_resep;
		$insertXxTrins["kode_bagian"] = $kode_bagian_pm;
		$insertXxTrins["id_dd_user"] = $id_dd_user;
		$insertXxTrins["kode_bagian_asal"] = $kode_bagian_asal;
		//show($insertXxTrins)
		if($cito==1)
		{
		$insertXxTrins["bill_rs"] = ((AV_CITO/100)*$insertXxTrins["bill_rs"]);
		$insertXxTrins["bill_dr1"] = ((AV_CITO/100)*$insertXxTrins["bill_dr1"]);
		$insertXxTrins["bill_dr2"] = ((AV_CITO/100)*$insertXxTrins["bill_dr2"]);
		$insertXxTrins["bill_perawat"] = ((AV_CITO/100)*$insertXxTrins["bill_perawat"]);
		$insertXxTrins["kamar_tindakan"] = ((AV_CITO/100)*$insertXxTrins["kamar_tindakan"]);
		$insertXxTrins["alat_rs"] = ((AV_CITO/100)*$insertXxTrins["alat_rs"]);
		$insertXxTrins["pendapatan_rs"] = ((AV_CITO/100)*$insertXxTrins["pendapatan_rs"]);
		$insertXxTrins["bill_dr_op1"] = ((AV_CITO/100)*$insertXxTrins["bill_dr_op1"]);
		$insertXxTrins["gros_dr"] = 0;
		$insertXxTrins["pendapatan_rsop"] = 0;
		$insertXxTrins["pendapatan_rsan"] = 0;
		}
		$cekSudahada=baca_tabel("tc_trans_pelayanan","kode_trans_pelayanan"," where kode_penunjang=$kode_penunjang and kode_tarif=$kode_pemeriksaan");
			
			
			
			if($cekSudahada==""){
		$result = insert_tabel("tc_trans_pelayanan", $insertXxTrins);
			}
		//////////////////////////////////////////////////////////////////////
		//$db->CommitTrans(false);
		$db->CommitTrans($result !== false);
		return $insertXxTrins;
		//die;

	}else
	{
		
		$kode_trans_pelayanan=max_kode_number("tc_trans_pelayanan","kode_trans_pelayanan");

		unset($insertXxTrins);
		
		$tarifUmum=new Tarif();
		$tarifUmum->set("kode_tarif",$kode_pemeriksaan);
		$tarifUmum->set("jumlah",1);
		$tarifUmum->set("kode_klas",$kode_klas);
		$tarifUmum->set("kode_kelompok",$kode_kelompok);
		$tarifUmum->set("kode_bagian",$kode_bagian_pm);
		$tarifUmum->set("cito",$cito);
		$insertXxTrins=$tarifUmum->hitung();
		//show($insertXxTrins);
		//die;
		$jenis_tindakan=3;

		
		//////perhitungan kenaikan tarif/ potongan tarif utk pasien perusahaan/ askes dan lain-lain//////

		///////////////////////////////////////////////////////////////////////


		$result = true;

		$db->BeginTrans();

		//////////////////////////////////////////////////////////////////////


		$insertXxTrins["kode_trans_pelayanan"] = $kode_trans_pelayanan;
		$insertXxTrins["no_kunjungan"] = $kode_kunjungan;
		$insertXxTrins["no_registrasi"] = $no_registrasi;
		$insertXxTrins["no_mr"] = $no_mr;
		$insertXxTrins["nama_pasien_layan"] = $nama_pasien;
		$insertXxTrins["kode_kelompok"] = $kode_kelompok;
		$insertXxTrins["kode_dokter"] = $kode_dokter;
		$insertXxTrins["kode_perusahaan"] = $kode_perusahaan;
		$insertXxTrins["tgl_transaksi"] = $tgl_transaksi;
		$insertXxTrins["jenis_tindakan"] = $jenis_tindakan;
		
		if($kode_bagian_pm==AV_FISIOTERAPI){
			$kode_fisio=baca_tabel("mt_karyawan","kode_dokter"," where nama_pegawai='".$dokter_pengirim."'");
			$insertXxTrins["kode_dokter1"] = $kode_fisio;
		}else{
			$insertXxTrins["kode_dokter1"] = $kode_dokter1;
		}
		$insertXxTrins["kode_dokter2"] = $kode_dokter2;
		
		if($kode_bagian_pm==AV_FISIOTERAPI){
			$insertXxTrins["kode_dokter3"] = $kode_dokter1;
		}else{
			$kode_dr=baca_tabel("mt_karyawan","kode_dokter"," where kode_dokter='".$dokter_pengirim."'");
			
			if($kode_dr==""){
				$dokter_pengirim=baca_tabel("mt_karyawan","kode_dokter"," where nama_pegawai='".$dokter_pengirim."'");
			}else{
				$dokter_pengirim=$dokter_pengirim;
			}

			$insertXxTrins["kode_dokter3"] = $dokter_pengirim;
		}

		if($kode_dokter2=='0')
		{
		$insertXxTrins["bill_dr2"] = 0;		
		}
		if($insertXxTrins["kode_dokter3"]=='0')
		{	//if($kode_bagian_pm!=AV_FISIOTERAPI){
			$insertXxTrins["bill_dr3"] = 0;
			//}
		}
		$insertXxTrins["kode_ri"] = $kode_ri;
		$insertXxTrins["kode_poli"] = $kode_poli;
		$insertXxTrins["jumlah"] = $jumlah;
		$insertXxTrins["kode_barang"] = $kode_barang;
		$sql_kondisi="flag_pemeriksaan_luar=1 and tingkatan=5";
		$diskon=cek_diskon($no_registrasi,$kode_pemeriksaan,$kode_bagian_pm,$sql_kondisi);
		//echo $diskon;
			if($diskon!=""){
			$insertXxTrins["diskon"]=($insertXxTrins['bill_rs']+$insertXxTrins['bill_dr1']+$insertXxTrins['bill_dr2']+$insertXxTrins['bill_dr3'])*$diskon;
			}
				
		$insertXxTrins["kode_penunjang"] = $kode_penunjang;
		$insertXxTrins["kode_depo_stok"] = $kode_depo_stok;
		$insertXxTrins["kode_gd"] = $kode_gd;
		$insertXxTrins["kd_tr_resep"] = $kd_tr_resep;
		$insertXxTrins["kode_bagian"] = $kode_bagian_pm;
		$insertXxTrins["id_dd_user"] = $id_dd_user;
		$insertXxTrins["kode_bagian_asal"] = $kode_bagian_asal;
		//show($insertXxTrins)
		$cekSudahada=baca_tabel("tc_trans_pelayanan","kode_trans_pelayanan"," where kode_penunjang=$kode_penunjang and kode_tarif=$kode_pemeriksaan");
			
			
			
			if($cekSudahada==""){
		$result = insert_tabel("tc_trans_pelayanan", $insertXxTrins);
			}
		//////////////////////////////////////////////////////////////////////
		//$db->CommitTrans(false);
		$db->CommitTrans($result !== false);
		//die;
	}
	//end if kopem
				
}


?>