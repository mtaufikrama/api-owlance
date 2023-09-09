<?
// ================================================== mencari nomor kunjungan ===============================================

function nomor_kunjungan($no_registrasi)
{
global $con_id;

		$cek_dulu="select no_kunjungan,no_mr,kode_bgn,tgl_jam from registrasi where no_registrasi=$no_registrasi";
		$hasil_cek=odbc_do($con_id,$cek_dulu);
		$no_kunjungan=odbc_result($hasil_cek,"no_kunjungan");
		$no_mr=odbc_result($hasil_cek,"no_mr");
		$kode_bagian=odbc_result($hasil_cek,"kode_bgn");
		$tgl_jam=odbc_result($hasil_cek,"tgl_jam");
		
		if($no_kunjungan=="" or $no_kunjungan=="0"):
		$sql_cek2="select no_kunjungan from kunjungan_detail where no_registrasi=$no_registrasi";
		$hasil_cek2=odbc_do($con_id,$sql_cek2);
		$no_kunjungan=odbc_result($hasil_cek2,"no_kunjungan");
		endif;

		if($no_kunjungan=="" or $no_kunjungan=="0"):
			//$no_kunjungan=pasien_masuk($no_mr,$no_registrasi,$kode_bagian,$tgl_jam);
		endif;

return $no_kunjungan;
}

// ====================================================================================      end of mencari nomor kunjungan

// ================================================== pasien masuk   ===============================================

function pasien_masuk($no_mr,$no_registrasi,$kode_bagian,$tgl_masuk="")
{

		global $db;


		$cek_dulu="select no_kunjungan from mt_kunjungan where no_mr='$no_mr' and kode_bagian_masuk='$kode_bagian' and status<>1";
		$hasil_cek=&$db->Execute($cek_dulu);
		$no_kunjungan = $sql->fields["no_kunjungan"];

		if($no_kunjungan==""):

		// masukkan ke tabel
		$sql_max="select max(no_kunjungan) as no_kunjungannya from mt_kunjungan";
		$hasil_max=&$db->Execute($sql_max);

		$no_kunjungan=$sql->fields["no_kunjungan"]+1;

		if($tgl_masuk==""):
		$tgl_masuk=date("Y-m-d H:i:s");
		endif;

		$sql_insert="INSERT INTO mt_kunjungan (no_kunjungan,no_mr,tgl_masuk,kode_bagian_masuk) values($no_kunjungan,'$no_mr','$tgl_masuk','$kode_bagian')";
		$eksekusi=&$db->Execute($sql_insert);
		
		endif;

		// update di tabel registrasi :

		$sql_update="UPDATE mt_registrasi SET no_kunjungan=$no_kunjungan WHERE no_registrasi=$no_registrasi";
		$eksekusi_2=&$db->Execute($sql_update) or die ($sql_update);

		// insert ditabel kunjungan detail

		$sql_insert2="INSERT INTO mt_kunjungan_detail (no_kunjungan,no_registrasi,kode_bagian,tgl) values($no_kunjungan,$no_registrasi,'$kode_bagian','$tgl_masuk')";

		$eksekusi_3=&$db->Execute($sql_insert2);

		// jika pasien baru masukkan ke trans_cetak_kartu
		$cek_kartu_sql="select stat_pasien from mt_registrasi where no_registrasi=$no_registrasi";
		$cek_kartu_do=&$db->Execute($cek_kartu_sql);
		$cek_kartu=$sql->fields["stat_pasien"];

		//$cek_kartu=baca_tabel("registrasi","stat_pasien","where no_registrasi=$no_registrasi");

		if($cek_kartu=="Baru"){
			//$nama_pasien=baca_tabel("master_pasien","nama_pasien","where no_mr='$no_mr'");
			

			$sql_insert_kartu="INSERT INTO trans_kartu (no_registrasi,no_mr,nama_pasien,tgl_transaksi,jumlah_transaksi) values($no_registrasi,'$no_mr','$nama_pasien','$tgl_transaksi',$jumlah_transaksi)";
			&$db->Execute($sql_insert_kartu);
		}


		return $no_kunjungan;
}

// ====================================================================================      end of pasien masuk

// ================================================== pasien rujuk   ===============================================

function pasien_rujuk($no_mr,$no_registrasi_asal,$no_registrasi_baru,$kode_bagian,$tgl_masuk="")
{

global $con_id;

$cek_dulu="select no_kunjungan,no_mr,kode_bgn from registrasi where no_registrasi=$no_registrasi_asal";
$hasil_cek=odbc_do($con_id,$cek_dulu) or die ($cek_dulu);
while(odbc_fetch_row($hasil_cek)):
$no_kunjungan=odbc_result($hasil_cek,"no_kunjungan");
$no_mr=odbc_result($hasil_cek,"no_mr");
$kode_bagian_asal=odbc_result($hasil_cek,"kode_bgn");
endwhile;

if($tgl_masuk==""):
$tgl_masuk=date("Y-m-d H:i:s");
endif;

// jika blom ada coba cek di kunjungan_detail

	if($no_kunjungan=="" or $no_kunjungan=="0"):
		$sql_cek2="select no_kunjungan from kunjungan_detail where no_registrasi=$no_registrasi_asal";
		$hasil_cek2=odbc_do($con_id,$sql_cek2);
		$no_kunjungan=odbc_result($hasil_cek2,"no_kunjungan");
	endif;

// jika blom ada juga maka daftarin deh ke kunjungan

	if($no_kunjungan=="" or $no_kunjungan=="0"):
			
			$no_kunjungan=pasien_masuk($no_mr,$no_registrasi_baru,$kode_bagian,$tgl_jam);

	else:

			// masukkan ke tabel kunjungan_detail

			$sql_insert2="INSERT INTO kunjungan_detail (no_kunjungan,no_registrasi,kode_bagian,tgl) values($no_kunjungan,$no_registrasi_baru,'$kode_bagian','$tgl_masuk')";

			$eksekusi_3=odbc_do($con_id,$sql_insert2);

	endif;

return $no_kunjungan;

}
// ====================================================================================      end of pasien rujuk

// ================================================== pasien keluar   ===============================================

function pasien_keluar($no_mr,$no_registrasi,$kode_bagian,$tgl_keluar="")
{	
	global $con_id;

		if($tgl_keluar==""):
			$tgl_keluar=date("Y-m-d H:i:s");
		endif;

		$liat_no_kunj="select no_kunjungan from kunjungan_detail where no_registrasi=$no_registrasi";
		$xx=odbc_do($con_id,$liat_no_kunj);
		$no_kunjungan=odbc_result($xx,"no_kunjungan");

		$sql_update="UPDATE kunjungan SET tgl_keluar='$tgl_keluar',kode_bagian_keluar='$kode_bagian',status=1 WHERE no_kunjungan=$no_kunjungan";
		
		$eksekusi_2=odbc_do($con_id,$sql_update);

		$sql_plus_3 = (is_numeric($no_kunjungan)) ? ("no_kunjungan = $no_kunjungan") : ("no_registrasi = $no_registrasi");

		$sql_update_3="UPDATE trans_pelayanan SET status_kasir=1 WHERE $sql_plus_3";

		$eksekusi_3=odbc_do($con_id,$sql_update_3);

}

// ====================================================================================      end of pasien keluar

// ================================================== pasien batal   ===============================================

function pasien_batal($no_mr,$no_registrasi,$kode_bagian,$tgl_keluar="")
{
	global $con_id;

		if($tgl_keluar==""):
			$tgl_keluar=date("Y-m-d H:i:s");
		endif;				

		$sql_update="UPDATE kunjungan_detail SET status_batal=1 WHERE no_registrasi=$no_registrasi";
		$eksekusi_2=odbc_do($con_id,$sql_update) or die($sql_update);
}
// ====================================================================================      end of pasien batal
?>