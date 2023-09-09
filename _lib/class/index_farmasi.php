<?
if(!class_exists("index_farmasi")){
	class index_farmasi{
		var $db;
				function index_farmasi($db,$txt_frekuensi,$tanggal,$bulan,$tahun){

				if($txt_frekuensi==1){
					$sql_plus="AND  DAY(b.tgl_trans)=$tanggal AND MONTH(b.tgl_trans)=$bulan AND YEAR(b.tgl_trans)=$tahun ";
					
				}else if($txt_frekuensi==2){
					$sql_plus="AND  MONTH(b.tgl_trans)=$bulan AND YEAR(b.tgl_trans)=$tahun ";
					
				}else{
					$sql_plus="AND  YEAR(b.tgl_trans)=$tahun";
				}

	
				$sql = "SELECT a.nama_pelayanan, b.kode_profit, 
				COUNT(b.kode_trans_far) AS jumlah, 
				(COUNT(CASE WHEN d .kode_kelompok = 1 THEN '1' END) + COUNT(CASE WHEN b.no_mr = 0 THEN '1' END)) AS umum, 
				COUNT(CASE WHEN d .kode_kelompok = 2 THEN '1' END) AS member,
				COUNT(CASE WHEN d .kode_kelompok = 3 THEN '1' END) AS perusahaan, 
				COUNT(CASE WHEN d .kode_kelompok = 4 THEN '1' END) AS karyawan
				FROM fr_mt_profit_margin AS a INNER JOIN
					fr_tc_far AS b ON a.kode_profit = b.kode_profit LEFT OUTER JOIN
					mt_master_pasien AS d ON b.no_mr = d.no_mr
				WHERE (b.status_transaksi = 1) $sql_plus
				GROUP BY a.nama_pelayanan, b.kode_profit
				ORDER BY b.tgl_trans";

				$hasil = $db->Execute($sql);
				
				while ($tampil=$hasil->FetchRow()) {
					$nama_pelayanan = $tampil["nama_pelayanan"];
					$kode_profit = $tampil["kode_profit"];
					$umum = $tampil["umum"];
					$member = $tampil["member"];
					$perusahaan = $tampil["perusahaan"];
					$karyawan = $tampil["karyawan"];
					$jumlah = $tampil["jumlah"];
					
					$this->hasilUmum[$kode_profit]				= $umum;
					$this->hasilMember[$kode_profit]			= $member;
					$this->hasilPerusahaan[$kode_profit]		= $perusahaan;
					$this->hasilKaryawan[$kode_profit]			= $karyawan;
					$this->hasilJumlah[$kode_profit]			= $jumlah;
					//$this->
					
					
				}
				
				/**/
				
				
			
		}

		function totalUmum($kode_profit){
				$hasil = $this->hasilUmum[$kode_profit];
				return $hasil;
		}

		function totalMember($kode_profit){
				$hasil = $this->hasilMember[$kode_profit];
				return $hasil;
		}

		function totalPerusahaan($kode_profit){
				$hasil = $this->hasilPerusahaan[$kode_profit];
				return $hasil;
		}

		function totalKaryawan($kode_profit){
				$hasil = $this->hasilKaryawan[$kode_profit];
				return $hasil;
		}

		function totalJumlah($kode_profit){
				$hasil = $this->hasilJumlah[$kode_profit];
				return $hasil;
		}
	}
}
?>