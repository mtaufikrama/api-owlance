<?
if(!class_exists("stok_bagian")){
	class stok_bagian{
		var $db;
		
		function stok_bagian($db,$kode_bagian,$frekuensi,$tahun,$bulan,$tgl){
			$kodeBagian = substr($kode_bagian,0,4);
			
			// define start date
			switch ($frekuensi){
				case "1":
					// harian
					$sqlPlus = " AND MONTH(tgl_input)=$bulan AND DAY(tgl_input)=$tgl";
					$sqlStokAwal = $sqlPlus;
					break;
				case "2":
					// bulanan
					$sqlPlus = " AND MONTH(tgl_input)=$bulan";
					$sqlStokAwal = $sqlPlus." AND DAY(tgl_input)=1";
					break;
				case "3":
					// tahunan
					$sqlPlus = "";
					$sqlStokAwal = " AND MONTH(tgl_input)=1 AND DAY(tgl_input)=1";
					break;
				case "4":
					// triwulan
					switch ($triwulan){
						case "1":
							$sqlPlus = " AND MONTH(tgl_input) between 1 AND 3";
							$sqlStokAwal = " AND MONTH(tgl_input)=1 AND DAY(tgl_input)=1";
							break;
						case "2":
							$sqlPlus = " AND MONTH(tgl_input) between 4 AND 6";
							$sqlStokAwal = " AND MONTH(tgl_input)=4 AND DAY(tgl_input)=1";
							break;
						case "3":
							$sqlPlus = " AND MONTH(tgl_input) between 7 AND 9";
							$sqlStokAwal = " AND MONTH(tgl_input)=7 AND DAY(tgl_input)=1";
							break;
						case "4":
							$sqlPlus = " AND MONTH(tgl_input) between 10 AND 12";
							$sqlStokAwal = " AND MONTH(tgl_input)=10 AND DAY(tgl_input)=1";
							break;
					}
					break;
			}
			$sql = "SELECT kode_brg,sum(pemasukan) AS masuk, SUM(pengeluaran)AS keluar FROM tc_kartu_stok WHERE kode_bagian LIKE '$kodeBagian%' AND YEAR(tgl_input)=$tahun $sql GROUP BY kode_brg";

			$hasil = $db->Execute($sql);

			$i = 1;
			while ($tampil = $hasil->FetchRow()) {
				$kode_brg	= $tampil["kode_brg"];
				$masuk		= $tampil["masuk"];
				$keluar		= $tampil["keluar"];
				
				$stokAwal = baca_tabel("tc_kartu_stok","stok_awal","WHERE kode_brg='$kode_brg' AND YEAR(tgl_input)=$tahun $sqlsqlStokAwal");
				$stokAkhir = $stokAwal + $masuk - $keluar;
				$this->stokBarangAwal[$kode_brg]	= $stokAwal;
				$this->stokBarangMasuk[$kode_brg]	= $masuk;
				$this->stokBarangKeluar[$kode_brg]	= $keluar;
				$this->stokBarangAkhir[$kode_brg]	= $stokAhir;
			}
			/*
			echo "<pre>";
			print_r($this->JmlPasienPoliBln);
			echo "</pre>";
			*/
		}
	}
}
?>