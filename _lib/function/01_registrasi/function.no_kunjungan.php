<?
include "../_lib/function/db_login.php";
include "../_lib/function/function.olah_tabel.php";
include "../_lib/function/function.max_kode_number.php";
include "../_lib/function/function.datetime.php";

// ================================================== mencari nomor kunjungan ===============================================

function nomor_registrasi($no_mr)
{
	global $db;

		$cek_registrasi=baca_tabel("tc_registrasi","no_registrasi","WHERE no_mr='$no_mr' and tgl_jam_keluar IS NULL and status_batal IS NULL ORDER BY no_registrasi DESC");

		if($cek_registrasi==""){
			$cek_registrasi=max_kode_number("tc_registrasi","no_registrasi");
		}
return $cek_registrasi;
}

// ====================================================================================      end of mencari nomor kunjungan

// ================================================== pasien masuk   ===============================================

function pasien_masuk($no_mr,$kode_bagian_masuk,$kode_dokter="",$tgl_masuk="",$stat_pasien="",$status_cito="0",$prioritas="",$keterangan="",$no_induk="",$asal_pasien="",$no_voucher="",$kode_bagian_voucher="",$flag_voucher="",$id_tc_registrasi_perusahaan="")
{

		global $db;
		
		/*	0.  untuk melihat kode_kelompok dan kode_perusahaan liat dari mt_master_pasien;
			1.	masukkan ke tc_registrasi
			2.	masukkan ke tabel tc_kunjungan		
			3.	masukkan ke tabel trans_kartu jika pasien baru			
			
		*/

		    if($tgl_masuk==""):
				$tgl_masuk=date("Y-m-d H:i:s");
			endif;
		
		// Cari kode_kelompok dan kode_perusahaan

		$mt_pasien=read_tabel("mt_master_pasien","kode_kelompok,kode_perusahaan,nama_pasien,tgl_lhr","WHERE no_mr='$no_mr'");

		$kode_kelompok=$mt_pasien->fields["kode_kelompok"];
		$kode_perusahaan=$mt_pasien->fields["kode_perusahaan"];
		$nama_pasien=$mt_pasien->fields["nama_pasien"];
		$tgl_lahir=$mt_pasien->fields["tgl_lhr"];

		/*--1. Masuk ke tc_registrasi--*/
			// cari no_registrasi

			$no_registrasi=max_kode_number("tc_registrasi","no_registrasi");
			if ($tgl_lahir!=""){

				list ($th_lahir,$bl_lahir,$tgl_lahir,$jam,$mnt,$det) = split('[-:" "]',$tgl_lahir);
				$birthDay=$tahun."-".$bulan."-".$tanggal;
				$tgl_skrg=date("d");
				$bln_skrg=date("m");
				$thn_skrg=date("Y");

				$tahun = hitungTahunLahir($th_lahir,$bl_lahir,$tgl_lahir,$thn_skrg,$bln_skrg,$tgl_skrg);
				$bulan = hitungBulanLahir($th_lahir,$bl_lahir,$tgl_lahir,$thn_skrg,$bln_skrg,$tgl_skrg);
				$hari = hitungHariLahir($th_lahir,$bl_lahir,$tgl_lahir,$thn_skrg,$bln_skrg,$tgl_skrg);

				//$umur = umur($tgl_lahir);
				$umur = $tahun;
				$umur_bulan=$bulan;
				$umur_hari=$hari;

			} else {

				$umur = 0;

			}
			$insertTcRegistrasi["no_registrasi"] = $no_registrasi;
			$insertTcRegistrasi["no_mr"] = $no_mr;
			$insertTcRegistrasi["kode_perusahaan"] = $kode_perusahaan;
			$insertTcRegistrasi["kode_kelompok"] = $kode_kelompok;
			$insertTcRegistrasi["kode_dokter"] = $kode_dokter;
			$insertTcRegistrasi["no_induk"] = $no_induk;
			$insertTcRegistrasi["tgl_jam_masuk"] = $tgl_masuk;
			//$insertTcRegistrasi["tgl_jam_keluar"] = $tgl_jam_keluar;
			$insertTcRegistrasi["prioritas"] = $prioritas;
			$insertTcRegistrasi["kode_bagian_masuk"] = $kode_bagian_masuk;
			//$insertTcRegistrasi["kode_bagian_keluar"] = $kode_bagian_keluar;
			//$insertTcRegistrasi["status_batal"] = $status_batal;
			$insertTcRegistrasi["stat_pasien"] =$stat_pasien;
			$insertTcRegistrasi["umur"] = $umur;
			$insertTcRegistrasi["umur_bulan"] = $umur_bulan;
			$insertTcRegistrasi["umur_hari"] = $umur_hari;
			$insertTcRegistrasi["asal_pasien"] = $asal_pasien;
			$insertTcRegistrasi["kode_bagian_voucher"] = $kode_bagian_voucher;
			$insertTcRegistrasi["no_voucher"] = $no_voucher;
			$insertTcRegistrasi["flag_voucher"] = $flag_voucher;
			$insertTcRegistrasi["id_tc_registrasi_perusahaan"] = $id_tc_registrasi_perusahaan;

			//PUNK-20/03/2013-11:49:20 
			if($no_mr!='')$cek_lama=baca_tabel('tc_registrasi',"no_registrasi","WHERE no_mr='".$no_mr."'");
			if($cek_lama=='')$insertTcRegistrasi["lama_baru"] = 1;

			/*///////////////////////////////////No registrasi///////////////////////////////////////////////////////*/
			
			if($kode_bagian_masuk=='010901'){
				$read_urutan=read_tabel("tc_registrasi","no_regis_urutan","where  YEAR(tgl_jam_masuk)=".date("Y")." AND MONTH(tgl_jam_masuk)=".date("m")." AND DAY(tgl_jam_masuk)=".date("d")."   ORDER BY no_registrasi DESC");
				$max_urutan = $read_urutan->fields["no_regis_urutan"];
				$mrID = substr($max_urutan,1) + 1;
				$panjang_mr=strlen($mrID);
				//panjang no 7
				$sisa_panjang=3-$panjang_mr;
				$tambah_nol="";
				for($i=1;$i<=$sisa_panjang;$i++){
				 $tambah_nol=$tambah_nol."0";
				}
				$mrID=$tambah_nol.$mrID;
				
				$tahun_dua=date("y");
				$bulan_dua=date("m");
				$tanggal_dua=date("d");
				$urutan_regis=$mrID;
				$no_regis_mcu=9;
				
				$no_regis_gabung=$tahun_dua."".$bulan_dua."".$tanggal_dua."".$no_regis_mcu."".$urutan_regis;

				$insertTcRegistrasi["no_regis_tahun"]		= $tahun_dua;
				$insertTcRegistrasi["no_regis_bulan"]		= $bulan_dua;
				$insertTcRegistrasi["no_regis_tanggal"]		= $tanggal_dua;
				$insertTcRegistrasi["no_regis_urutan"]		= $urutan_regis;
				$insertTcRegistrasi["no_regis_mcu"]			= $no_regis_mcu;
				$insertTcRegistrasi["no_regis_gabung"]		= $no_regis_gabung;
			}

			/*///////////////////////////////////No registrasi///////////////////////////////////////////////////////*/
		

			insert_tabel("tc_registrasi",$insertTcRegistrasi);

			/*--2. Masuk ke tc_kunjungan--*/

			//Cari no_kunjungan

			$no_kunjungan=max_kode_number("tc_kunjungan","no_kunjungan");
			//$kode_kunjungan=max_kode_text("tc_kunjungan","kode_kunjungan");
			//$insertTcKunjungan["kode_kunjungan"] = $kode_kunjungan;
			$insertTcKunjungan["no_kunjungan"] = $no_kunjungan;
			$insertTcKunjungan["no_registrasi"] = $no_registrasi;
			$insertTcKunjungan["no_mr"] = $no_mr;
			$insertTcKunjungan["kode_dokter"] = $kode_dokter;
			$insertTcKunjungan["kode_bagian_tujuan"] = $kode_bagian_masuk;
			$insertTcKunjungan["kode_bagian_asal"] = $kode_bagian_masuk;
			$insertTcKunjungan["tgl_masuk"] = $tgl_masuk;
			//$insertTcKunjungan["tgl_keluar"] = $tgl_keluar;
			$insertTcKunjungan["status_masuk"] = 0;
			//$insertTcKunjungan["status_keluar"] = $status_keluar;
			$insertTcKunjungan["status_cito"] = $status_cito;
			$insertTcKunjungan["keterangan"] = $keterangan;
			$insertTcKunjungan["umur_tahun"] = $umur;
			$insertTcKunjungan["umur_bulan"] = $umur_bulan;
			$insertTcKunjungan["umur_hari"] = $umur_hari;

			if($kode_bagian_masuk=="010901"){
				$insertTcKunjungan["status_mcu"] = 1;
			}
			insert_tabel("tc_kunjungan", $insertTcKunjungan);

				
			/*--3. Masuk ke trans_kartu--*/

			// jika pasien baru masukkan ke trans_cetak_kartu
			

			$cek_kartu=trim(strtolower(baca_tabel("tc_registrasi","stat_pasien","where no_registrasi=$no_registrasi")));

			if($cek_kartu=="baru"){
				
				$kode_trans_kartu=max_kode_number("tc_trans_kartu","kode_trans_kartu");

				$isi_trans_kartu["kode_trans_kartu"]=$kode_trans_kartu;
				$isi_trans_kartu["no_registrasi"]=$no_registrasi;
				$isi_trans_kartu["no_mr"]=$no_mr;
				$isi_trans_kartu["nama_pasien"]=$nama_pasien;
				$isi_trans_kartu["tgl_transaksi"]=$tgl_masuk;
				$isi_trans_kartu["jumlah_transaksi"]=1;
				$isi_trans_kartu["no_kunjungan"]=$no_kunjungan;
				insert_tabel("tc_trans_kartu",$isi_trans_kartu);

			}


		return $no_kunjungan;
}

// ====================================================================================      end of pasien masuk

// ================================================== pasien rujuk   ===============================================

function pasien_rujuk($no_mr,$kode_dokter,$kode_bagian_masuk,$kode_bagian_asal,$tgl_masuk,$status_cito="",$keterangan="",$jenis_rujuk="1",$noregistrasi="",$nokunjunganlama="")
{

global $db;

	/*
	1. cari nomor registrasi
	2. update tc_kunjungan jika tidak dirujuk ke pm
	3. insert kunjungan baru
	4. update tabel tc_kunjungan berdasarkan tc kunjungan baru jika pm	
	*/
	
	// task 1 do it .......................................
	//echo"no_reg=".$noregistrasi;
	if($noregistrasi==""){
		$no_registrasi=nomor_registrasi($no_mr);
	}else{
		$no_registrasi=$noregistrasi;
	}
	// task 1 done ----------------------------------------

	if($jenis_rujuk=="3"){
		$kunjungan_cek=baca_tabel("tc_kunjungan","no_kunjungan","WHERE no_mr='$no_mr' and no_registrasi=$no_registrasi and kode_bagian_tujuan='$kode_bagian_asal' and tgl_keluar IS NULL");

	if($kunjungan_cek==""){
		if($nokunjunganlama==""){
			$kunjungan_cek=baca_tabel("tc_kunjungan","top 1 no_kunjungan","WHERE no_mr='$no_mr' and no_registrasi=$no_registrasi  and tgl_keluar IS NULL order by tgl_masuk desc");
			//$kunjungan_cek=baca_tabel("tc_kunjungan","no_kunjungan","WHERE no_mr='$no_mr' and no_registrasi=$no_registrasi  and tgl_keluar IS NULL order by tgl_masuk desc LIMIT 1");
		}else{
			$kunjungan_cek=$nokunjunganlama;
		}
	}
	/*$kunjungan_cek=$no_kunjungan;*/

	$editTcKunjungan["tgl_keluar"] = $tgl_masuk;
	$editTcKunjungan["status_keluar"] = 1;
	//update_tabel("tc_kunjungan", $editTcKunjungan, "WHERE no_mr='$no_mr' and no_registrasi=$no_registrasi and kode_bagian_tujuan='$kode_bagian_asal' and tgl_keluar IS NULL and no_kunjungan=$kunjungan_cek");
	update_tabel("tc_kunjungan", $editTcKunjungan, "WHERE no_mr='$no_mr' and no_registrasi=$no_registrasi and no_kunjungan=$kunjungan_cek");

	}


	// task 2 , Masukan Ke tc_kunjungan do it ------------------------

	$mt_pasien=read_tabel("mt_master_pasien","tgl_lhr","WHERE no_mr='$no_mr'");
	$tgl_lahir=$mt_pasien->fields["tgl_lhr"];

	if ($tgl_lahir!=""){

				list ($th_lahir,$bl_lahir,$tgl_lahir,$jam,$mnt,$det) = split('[-:" "]',$tgl_lahir);
				$birthDay=$tahun."-".$bulan."-".$tanggal;
				$tgl_skrg=date("d");
				$bln_skrg=date("m");
				$thn_skrg=date("Y");

				$tahun = hitungTahunLahir($th_lahir,$bl_lahir,$tgl_lahir,$thn_skrg,$bln_skrg,$tgl_skrg);
				$bulan = hitungBulanLahir($th_lahir,$bl_lahir,$tgl_lahir,$thn_skrg,$bln_skrg,$tgl_skrg);
				$hari = hitungHariLahir($th_lahir,$bl_lahir,$tgl_lahir,$thn_skrg,$bln_skrg,$tgl_skrg);

				//$umur = umur($tgl_lahir);
				$umur = $tahun;
				$umur_bulan=$bulan;
				$umur_hari=$hari;

	} else {

			$umur = 0;

	}


	$no_kunjungan=max_kode_number("tc_kunjungan","no_kunjungan");

	$insertTcKunjungan["no_kunjungan"] = $no_kunjungan;
	$insertTcKunjungan["no_registrasi"] = $no_registrasi;
	$insertTcKunjungan["no_mr"] = $no_mr;
	$insertTcKunjungan["kode_dokter"] = $kode_dokter;
	$insertTcKunjungan["kode_bagian_tujuan"] = $kode_bagian_masuk;
	$insertTcKunjungan["kode_bagian_asal"] = $kode_bagian_asal;
	$insertTcKunjungan["tgl_masuk"] = $tgl_masuk;
	$insertTcKunjungan["status_masuk"] = 1;
	$insertTcKunjungan["status_cito"] = $status_cito; 
	$insertTcKunjungan["keterangan"] = $keterangan;

	$insertTcKunjungan["umur_tahun"] = $umur;
	$insertTcKunjungan["umur_bulan"] = $umur_bulan;
	$insertTcKunjungan["umur_hari"] = $umur_hari;

	insert_tabel("tc_kunjungan", $insertTcKunjungan);

	// task 2 done------------------------------------------------------

	// task 3 do it ------------------------------------------------------

	
	//SEMENTARA 
	if($jenis_rujuk=="2"){
	/*$kunjungan_cek=baca_tabel("tc_kunjungan","no_kunjungan","WHERE no_mr='$no_mr' and no_registrasi=$no_registrasi and kode_bagian_tujuan='$kode_bagian_asal' and tgl_keluar IS NULL");*/
	$kunjungan_cek=$no_kunjungan;

	$editTcKunjungan["tgl_keluar"] = $tgl_masuk;
	$editTcKunjungan["status_keluar"] = 1;
	//update_tabel("tc_kunjungan", $editTcKunjungan, "WHERE no_mr='$no_mr' and no_registrasi=$no_registrasi and kode_bagian_tujuan='$kode_bagian_asal' and tgl_keluar IS NULL and no_kunjungan=$kunjungan_cek");
	update_tabel("tc_kunjungan", $editTcKunjungan, "WHERE no_mr='$no_mr' and no_registrasi=$no_registrasi and no_kunjungan=$kunjungan_cek");

	}

	// task 3 done -------------------------------------------------------

return $no_kunjungan;

}
// ====================================================================================      end of pasien rujuk

// ================================================== pasien keluar   ===============================================

function pasien_keluar($no_mr,$no_registrasi,$kode_bagian,$tgl_keluar="",$status_meninggal="")
{	
	global $db;

		//PUNK-02/11/2012-10:11:13 KAGA JALAN di RSSM
		//if($tgl_keluar==""):
			$tgl_keluar=date("Y-m-d H:i:s");
		//endif;

		//1. Update Pasien Keluar

		$edit_registrasi["tgl_jam_keluar"]=$tgl_keluar;
		$edit_registrasi["kode_bagian_keluar"]=$kode_bagian;
		$edit_registrasi["status_registrasi"]=1;
		update_tabel("tc_registrasi",$edit_registrasi,"Where no_registrasi=$no_registrasi");

		//2. Update Kunjungan

		$edit_kunjungan["tgl_keluar"]=$tgl_keluar;
		if($status_meninggal==""){
		$edit_kunjungan["status_keluar"]=3;
		}else{
		$edit_kunjungan["status_keluar"]=$status_meninggal;
		}
		/*update_tabel("tc_kunjungan",$edit_kunjungan,"Where no_registrasi=$no_registrasi and kode_bagian_tujuan=$kode_bagian and no_mr=$no_mr and tgl_keluar IS NULL ");*/

		update_tabel("tc_kunjungan",$edit_kunjungan,"Where no_registrasi=$no_registrasi and no_mr='$no_mr' and tgl_keluar IS NULL ");

      

}

// ====================================================================================      end of pasien keluar

// ================================================== pasien batal   ===============================================

function pasien_batal($no_mr,$no_registrasi,$no_kunjungan,$mode="1",$kd_masuk="")
{
	//echo "masuk";
	global $db;

		/*1. Hapus  di tabel tc_kunjungan :
		  2. Cek di tc_kunjungan untuk no registrasi tersebut ada atau tidak
		  3. Jika tidak ada maka hapus di tc_registrasi untuk no registrasi tersebut
		
		### tambahan suwi ###
		sebelum dihapus di 'transfer' dulu ke tabel history

		*/
		if( $mode == 1 ) {
			$sql_transfer_kunjungan = "INSERT INTO tc_kunjungan_batal SELECT * FROM tc_kunjungan WHERE no_kunjungan =".$no_kunjungan." AND no_registrasi=".$no_registrasi." AND no_mr='".$no_mr."'";
	
		$sql_transfer_regis = "INSERT INTO tc_registrasi_batal SELECT * FROM tc_registrasi WHERE  no_registrasi=".$no_registrasi." AND no_mr='".$no_mr."'";
			
			$db->Execute($sql_transfer_kunjungan);
			$db->Execute($sql_transfer_regis);
			
		
			//1.Hapus  di tabel tc_kunjungan
					delete_tabel("tc_kunjungan","WHERE no_kunjungan=$no_kunjungan");
			
			//2. Cek di tc_kunjungan untuk no registrasi tersebut ada atau tidak
			$registrasi_cek=baca_tabel("tc_kunjungan","no_registrasi","WHERE no_registrasi=$no_registrasi");
				if($registrasi_cek=="")
				{
					delete_tabel("tc_registrasi","WHERE no_registrasi=$no_registrasi");
				}
			/* sesudah itu update history untuk batal */
			
			$update_kunj_batal["tgl_keluar"] = date("Y-m-d H:i:s");
			$update_kunj_batal["status_keluar"] = 3;
			
			$update_reg_batal["tgl_jam_keluar"] = date("Y-m-d H:i:s"); 
			$update_reg_batal["status_batal"] = 1; 
	
		update_tabel("tc_kunjungan_batal",$update_kunj_batal,"WHERE no_kunjungan=$no_kunjungan AND no_registrasi=$no_registrasi AND no_mr='$no_mr'");
			update_tabel("tc_registrasi_batal",$update_reg_batal,"WHERE no_registrasi=$no_registrasi AND no_mr='$no_mr'");
	
		/*$sql_update="UPDATE tc_kunjungan_detail SET status_batal=1 WHERE no_registrasi=$no_registrasi";
			$eksekusi_2=&$db->Execute($sql_update);
	
		$edit_tc_kunjungan_detail["status_batal"]=1;
			update_tabel("tc_registrasi_",$edit_tc_kunjungan_detail,"Where no_registrasi=$no_registrasi");
			*/
		}else if($mode=="2"){

			$kdMasuk=substr($kd_masuk,0,2);

			
			unset($fld);
			$fld["status_batal"]		= 1;

			if($kdMasuk == "01" ){

				if($kd_masuk == "010901" ){

					update_tabel("mcu_tc_registrasi",$fld,"WHERE no_kunjungan=$no_kunjungan");

				}else{

					update_tabel("pl_tc_poli",$fld,"WHERE no_kunjungan=$no_kunjungan");

				}

			}else if($kdMasuk == "02"){

				update_tabel("gd_tc_gawat_darurat",$fld,"WHERE no_kunjungan=$no_kunjungan");

			}else if($kdMasuk == "03"){

				update_tabel("ri_tc_rawatinap",$fld,"WHERE no_kunjungan=$no_kunjungan");

				$kode_ruangan=baca_tabel("ri_tc_rawatinap","kode_ruangan","WHERE no_kunjungan=$no_kunjungan");
				
				unset($editMtRuangan);
				$editMtRuangan["status"] =NULL;
				$result = update_tabel("mt_ruangan",$editMtRuangan, "WHERE  kode_ruangan='$kode_ruangan'");


			}else if($kdMasuk == "05"){
				
				update_tabel("pm_tc_penunjang",$fld,"WHERE no_kunjungan=$no_kunjungan");

			}

			unset($fld);
			$fld["status_batal"]		= 1;
			$fld["tgl_keluar"]			= date("Y-m-d H:i:s"); 
			$fld["status_keluar"]		= 3;

			$cekJmlkunjungan=baca_tabel("tc_kunjungan","count(no_kunjungan)"," where no_registrasi=$no_registrasi AND no_mr='$no_mr' ");

			
			
			if($cekJmlkunjungan == 1){

				update_tabel("tc_kunjungan",$fld,"WHERE no_kunjungan=$no_kunjungan AND no_registrasi=$no_registrasi AND no_mr='$no_mr'");

				unset($fld);
				$fld["status_batal"]		= 1;
				$fld["tgl_jam_keluar"]		= date("Y-m-d H:i:s"); 
				$fld["kode_bagian_keluar"]	= baca_tabel("tc_registrasi","kode_bagian_masuk"," where no_registrasi=$no_registrasi AND no_mr='$no_mr' ");

				update_tabel("tc_registrasi",$fld,"WHERE  no_registrasi=$no_registrasi AND no_mr='$no_mr'");

			}else{
			
				update_tabel("tc_kunjungan",$fld,"WHERE no_kunjungan=$no_kunjungan AND no_registrasi=$no_registrasi AND no_mr='$no_mr'");

			}

		
		}
}
// ====================================================================================      end of pasien batal


// ================================================== pasien rujuk keluar   ===============================================

function pasien_rujuk_keluar($no_mr,$no_registrasi,$kode_bagian,$tgl_keluar="")
{	
	global $db;

		if($tgl_keluar==""):
			$tgl_keluar=date("Y-m-d H:i:s");
		endif;

		//1. Update Kunjungan

		$edit_kunjungan["tgl_keluar"]=$tgl_keluar;
		$edit_kunjungan["status_keluar"]=5;
		
		update_tabel("tc_kunjungan",$edit_kunjungan,"Where no_registrasi=$no_registrasi and kode_bagian_tujuan='$kode_bagian' and no_mr='$no_mr' and tgl_keluar IS NULL ");
}

// ====================================================================================      end of pasien rujuk keluar
// ====================================================================================      end of pasien rujuk
// ================================================== pasien keluar   ===============================================

function pasien_keluar_mcu($no_mr,$no_registrasi,$kode_bagian,$tgl_keluar="",$status_meninggal="")
{	
	global $db;

		if($tgl_keluar==""):
			$tgl_keluar=date("Y-m-d H:i:s");
		endif;

		//1. Update Pasien Keluar

		$edit_registrasi["tgl_jam_keluar"]=$tgl_keluar;
		$edit_registrasi["kode_bagian_keluar"]=$kode_bagian;
		$edit_registrasi["status_registrasi"]=1;
		update_tabel("tc_registrasi",$edit_registrasi,"Where no_registrasi=$no_registrasi");

		update_tabel("tc_registrasi",$edit_registrasi,"Where no_mr='$no_mr' AND tgl_jam_keluar IS NULL");

		//2. Update Kunjungan

		$edit_kunjungan["tgl_keluar"]=$tgl_keluar;
		if($status_meninggal !=4 || $status_meninggal !=6 ){
			$edit_kunjungan["status_keluar"]=3;//keluar Hidup

		}else if($status_meninggal==4){
			$edit_kunjungan["status_keluar"]=4;//Meninggal

		}else if($status_meninggal==6){
		   $edit_kunjungan["status_keluar"]=6;//keluar RS
		}
		

		/*update_tabel("tc_kunjungan",$edit_kunjungan,"Where no_registrasi=$no_registrasi and kode_bagian_tujuan=$kode_bagian and no_mr=$no_mr and tgl_keluar IS NULL ");*/

		update_tabel("tc_kunjungan",$edit_kunjungan,"Where no_registrasi=$no_registrasi and no_mr='$no_mr' and tgl_keluar IS NULL and kode_bagian_tujuan='".$kode_bagian."'");

		update_tabel("tc_kunjungan",$edit_kunjungan,"Where no_mr='$no_mr' AND tgl_keluar IS NULL AND  kode_bagian_tujuan='".$kode_bagian."'");
			
		

}

// ====================================================================================      end of pasien keluar mcu
?>