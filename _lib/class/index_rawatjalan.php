<?
if(!class_exists("index_rawatjalan")){
	class index_rawatjalan{
		var $db;
				function index_rawatjalan($db,$txt_frekuensi,$tanggal,$bulan,$tahun){

				if($txt_frekuensi==1){
					$sql_plus="AND  DAY(a.tgl_masuk)=$tanggal AND MONTH(a.tgl_masuk)=$bulan AND YEAR(a.tgl_masuk)=$tahun ";
					
				}else if($txt_frekuensi==2){
					$sql_plus="AND  MONTH(a.tgl_masuk)=$bulan AND YEAR(a.tgl_masuk)=$tahun ";
					
				}else{
					$sql_plus="AND  YEAR(a.tgl_masuk)=$tahun";
				}

				$sql="select  a.kode_bagian_asal,b.nama_bagian,count(a.id_tc_kunjungan) as jumlah,
				count(CASE WHEN d.kode_kelompok	 = 1 THEN '1' END) AS umum,
				count(CASE WHEN  d.kode_kelompok = 2 THEN '1' END) AS member,
				count(CASE WHEN d.kode_kelompok  = 3 THEN '1' END) AS perusahaan,
				count(CASE WHEN d.kode_kelompok  = 4 THEN '1' END) AS karyawan
				from tc_kunjungan as a inner join mt_bagian as b on a.kode_bagian_asal=b.kode_bagian
				inner join mt_master_pasien as d on a.no_mr=d.no_mr  WHERE a.kode_bagian_asal like'01%' AND a.tgl_keluar IS NOT NULL AND (a.status_keluar='3' or	a.status_keluar='1')  $sql_plus GROUP BY a.kode_bagian_asal,b.nama_bagian ORDER BY b.kode_bagian";
				$hasil = $db->Execute($sql);
				
				while ($tampil=$hasil->FetchRow()) {
					$kode_bagian = $tampil["kode_bagian_asal"];
					$nama_bagian = $tampil["nama_bagian"];
					$umum = $tampil["umum"];
					$member = $tampil["member"];
					$perusahaan = $tampil["perusahaan"];
					$karyawan = $tampil["karyawan"];
					$jumlah = $tampil["jumlah"];
					
					$this->hasilUmum[$kode_bagian]				= $umum;
					$this->hasilMember[$kode_bagian]			= $member;
					$this->hasilPerusahaan[$kode_bagian]		= $perusahaan;
					$this->hasilKaryawan[$kode_bagian]			= $karyawan;
					$this->hasilJumlah[$kode_bagian]			= $jumlah;
					//$this->
					
					
				}
				
				/**/
				
				
			
		}

		function totalUmum($kode_bagian){
				$hasil = $this->hasilUmum[$kode_bagian];
				return $hasil;
		}

		function totalMember($kode_bagian){
				$hasil = $this->hasilMember[$kode_bagian];
				return $hasil;
		}

		function totalPerusahaan($kode_bagian){
				$hasil = $this->hasilPerusahaan[$kode_bagian];
				return $hasil;
		}

		function totalKaryawan($kode_bagian){
				$hasil = $this->hasilKaryawan[$kode_bagian];
				return $hasil;
		}

		function totalJumlah($kode_bagian){
				$hasil = $this->hasilJumlah[$kode_bagian];
				return $hasil;
		}
	}
}
?>