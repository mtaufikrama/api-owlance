<?
require_once("../_lib/function/db.php");
loadlib("function","function.olah_tabel");

// ================================================== mencari nomor kunjungan ===============================================

function nomor_kunjungan($no_registrasi)
{
	global $db;

		$cek_dulu="select no_kunjungan,no_mr,kode_bgn,tgl_jam from tc_registrasi where no_registrasi=$no_registrasi";
		$hasil_cek=&$db->Execute($cek_dulu);
		$no_kunjungan=$hasil_cek->fields["no_kunjungan"];
		$no_mr=$hasil_cek->fields["no_mr"];
		$kode_bagian=$hasil_cek->fields["kode_bgn"];
		$tgl_jam=$hasil_cek->fields["tgl_jam"];

		if($no_kunjungan=="" or $no_kunjungan=="0"):
		$sql_cek2="select no_kunjungan from tc_kunjungan_detail where no_registrasi=$no_registrasi";
		$hasil_cek2=&$db->Execute($sql_cek2);
		$no_kunjungan=$hasil_cek->fields["no_kunjungan"];
		endif;

		if($no_kunjungan=="" or $no_kunjungan=="0"):
		//$no_kunjungan=pasien_masuk($no_mr,$no_registrasi,$kode_bagian,$tgl_jam);
		endif;

return $no_kunjungan;
}

// ====================================================================================      end of mencari nomor kunjungan

// ================================================== pasien masuk   ===============================================

function pasien_masuk($no_mr,$no_registrasi,$kode_kelompok,$kode_perusahaan,$txt_bagian,$txt_cito,$kode_dokter)
{

		global $db;

		$cek_dulu="select kode_kunjungan from tc_kunjungan where no_mr='$no_mr' and kode_bagian_tujuan='$txt_bagian'";
		$hasil_cek=&$db->Execute($cek_dulu);
		$no_kunjungan =$hasil_cek->fields["kode_kunjungan"];

		if($no_kunjungan==""):

		// masukkan ke tabel
		$sql_max="select max(kode_kunjungan) as no_kunjungannya from tc_kunjungan";
		$hasil_max=&$db->Execute($sql_max);
		$no_kunjungan=$hasil_max->fields["kode_kunjungan"]+1;
		

		/*$no_kunjungan=max_kode_number("tc_kunjungan","kode_kunjungan");*/

		if($tgl_masuk==""):
		$tgl_masuk=date("Y-m-d H:i:s");
		endif;

		
      /* $isi_tc_kunjungan["no_registrasi"]=$no_registrasi;
		$isi_tc_kunjungan["kode_kunjungan"]=$no_kunjungan;
		$isi_tc_kunjungan["no_mr"]=$no_mr;
		$isi_tc_kunjungan["kode_kelompok"]=$kode_kelompok;
		$isi_tc_kunjungan["kode_perusahaan"]=$kode_perusahaan; 
		//$isi_tc_kunjungan["tgl_masuk"]=$tgl_masuk;
		$isi_tc_kunjungan["kode_bagian_tujuan"]=$txt_bagian;
		$isi_tc_kunjungan["status_cito"]=$txt_cito;
		$isi_tc_kunjungan["kode_dokter"]=$kode_dokter;
		insert_tabel("tc_kunjungan",$isi_tc_kunjungan);
		
     */
		$sql_insert="INSERT INTO tc_kunjungan (kode_kunjungan,no_registrasi,no_mr,kode_kelompok,kode_perusahaan,kode_dokter,kode_bagian_tujuan,status_cito) values('$no_kunjungan',$no_registrasi,'$no_mr',$kode_kelompok,$kode_perusahaan,'$kode_dokter','$txt_bagian',$txt_cito)";
		$eksekusi=&$db->Execute($sql_insert);

		
		endif;

		$edit_tc_registrasi["no_kunjungan"]=$no_kunjungan;
		update_tabel("tc_registrasi",$edit_tc_registrasi,"Where no_registrasi=$no_registrasi");


		// jika pasien baru masukkan ke trans_cetak_kartu
		$cek_kartu_sql="select stat_pasien from tc_registrasi where no_registrasi=$no_registrasi";
		$cek_kartu_do=&$db->Execute($cek_kartu_sql);
		$cek_kartu=$cek_kartu_do->fields["stat_pasien"];

		//$cek_kartu=baca_tabel("registrasi","stat_pasien","where no_registrasi=$no_registrasi");

		if($cek_kartu=="Baru"){
			//$nama_pasien=baca_tabel("master_pasien","nama_pasien","where no_mr='$no_mr'");
			

			/*$sql_insert_kartu="INSERT INTO trans_kartu (no_registrasi,no_mr,nama_pasien,tgl_transaksi,jumlah_transaksi) values($no_registrasi,'$no_mr','$nama_pasien','$tgl_transaksi',$jumlah_transaksi)";
			&$db->Execute($sql_insert_kartu);*/

			$isi_trans_kartu["no_registrasi"]=$no_registrasi;
			$isi_trans_kartu["no_mr"]=$no_mr;
			$isi_trans_kartu["nama_pasien"]=$nama_pasien;
			$isi_trans_kartu["tgl_transaksi"]=$tgl_transaksi;
			$isi_trans_kartu["jumlah_transaksi"]=$jumlah_transaksi;
			insert_tabel("trans_kartu",$isi_trans_kartu);

		}


		return $no_kunjungan;
}

// ====================================================================================      end of pasien masuk

// ================================================== pasien rujuk   ===============================================

function pasien_rujuk($no_mr,$no_registrasi_asal,$no_registrasi_baru,$kode_bagian,$tgl_masuk="")
{

global $db;

$cek_dulu="select no_kunjungan,no_mr,kode_bgn from tc_registrasi where no_registrasi=$no_registrasi_asal";
$hasil_cek=&$db->Execute($cek_dulu);
while ($tampil=$hasil_cek->FetchRow()) {
$no_kunjungan=$tampil["no_kunjungan"];
$no_mr=$tampil["no_mr"];
$kode_bagian_asal=$tampil["kode_bgn"];
}

if($tgl_masuk==""):
$tgl_masuk=date("Y-m-d H:i:s");
endif;

// jika blom ada coba cek di kunjungan_detail

	if($no_kunjungan=="" or $no_kunjungan=="0"){
		$sql_cek2="select no_kunjungan from tc_kunjungan_detail where no_registrasi=$no_registrasi_asal";
		$hasil_cek2=&$db->Execute($sql_cek2);
		$no_kunjungan=$hasil_cek2->fields["no_kunjungan"];
	}

// jika blom ada juga maka daftarin deh ke kunjungan

	if($no_kunjungan=="" or $no_kunjungan=="0"):
			
			$no_kunjungan=pasien_masuk($no_mr,$no_registrasi_baru,$kode_bagian,$tgl_jam);

	else:

			// masukkan ke tabel kunjungan_detail

			/*$sql_insert2="INSERT INTO tc_kunjungan_detail (no_kunjungan,no_registrasi,kode_bagian,tgl) values($no_kunjungan,$no_registrasi_baru,'$kode_bagian','$tgl_masuk')";

			$eksekusi_3=&$db->Execute($sql_insert2);*/

			$isi_tc_kunjungan_detail["no_kunjungan"]=$no_kunjungan;
			$isi_tc_kunjungan_detail["no_registrasi"]=$no_registrasi_baru;
			$isi_tc_kunjungan_detail["kode_bagian"]=$kode_bagian;
			$isi_tc_kunjungan_detail["tgl"]=$tgl_masuk;
			insert_tabel("tc_kunjungan_detail",$isi_tc_kunjungan_detail);

	endif;

return $no_kunjungan;

}
// ====================================================================================      end of pasien rujuk

// ================================================== pasien keluar   ===============================================

function pasien_keluar($no_mr,$no_registrasi,$kode_bagian,$tgl_keluar="")
{	
	global $db;

		if($tgl_keluar==""):
			$tgl_keluar=date("Y-m-d H:i:s");
		endif;

		$liat_no_kunj="select no_kunjungan from tc_kunjungan_detail where no_registrasi=$no_registrasi";
		$xx=&$db->Execute($liat_no_kunj);
		$no_kunjungan=$xx->fields["no_kunjungan"];

		$sql_update="UPDATE tc_kunjungan SET tgl_keluar='$tgl_keluar',kode_bagian_keluar='$kode_bagian',status=1 WHERE no_kunjungan=$no_kunjungan";
		
		$eksekusi_2=&$db->Execute($sql_update);

		$sql_plus_3 = (is_numeric($no_kunjungan)) ? ("no_kunjungan = $no_kunjungan") : ("no_registrasi = $no_registrasi");

		/*$sql_update_3="UPDATE trans_pelayanan SET status_kasir=1 WHERE $sql_plus_3";

		$eksekusi_3=&$db->Execute($sql_update_3);*/
		$edit_trans_pelayanan["status_kasir"]=1;
		update_tabel("trans_pelayanan",$edit_trans_pelayanan,"Where $sql_plus_3");



}

// ====================================================================================      end of pasien keluar

// ================================================== pasien batal   ===============================================

function pasien_batal($no_mr,$no_registrasi,$kode_bagian,$tgl_keluar="")
{
	global $db;

		if($tgl_keluar==""):
			$tgl_keluar=date("Y-m-d H:i:s");
		endif;				

		/*$sql_update="UPDATE tc_kunjungan_detail SET status_batal=1 WHERE no_registrasi=$no_registrasi";
		$eksekusi_2=&$db->Execute($sql_update);*/

		$edit_tc_kunjungan_detail["status_batal"]=1;
		update_tabel("tc_kunjungan_detail",$edit_tc_kunjungan_detail,"Where no_registrasi=$no_registrasi");
}
// ====================================================================================      end of pasien batal
?>