<? if(!class_exists("sensusinap")){
/********************************************/
/*		isi variabel ket_sensus :			*/
/*		# 0 : Pasien Masuk Asli				*/
/*		# 1 : Pasien Masuk Pindah			*/
/*		# 2 : Pasien Keluar Pindah			*/
/*		# 3 : Pasien Keluar	Sembuh			*/
/*		# 4 : Pasien Keluar Meninggal		*/
/*											*/
/********************************************/
class sensusinap{

	var $db;
	var $hasilCariTotal;
	var $hasilCariKelas;
	var $hasilCariPasienMasuk;
	var $hasilCariPasienPindahan;
	var $hasilCariPasienKeluarHidup;
	var $hasilCariPasienKeluarMati;
	var $bulanKlas;
	var $tahunKlas;
	var $dbKlas;

	function sensusinap ($db,$bln,$thn) 
	{
		
		$con_id=$db;
		$this->dbKlas=$con_id;
		
		$this->bulanKlas=$bln;
		$this->tahunKlas=$thn;

		
		$sql = "(
		SELECT 
			case b.kode_bagian when 0306 then 'Bayi' else 'Umum' end as golongan,
			case when bagian_tujuan=0306 then 'odc' when bagian_tujuan=0309 then 'odc' else 'ri' end as kegiatan,
			count(a.kode_riw_klas) as jml, 
			day(a.tgl_masuk) as tgl, 
			month(a.tgl_masuk)as bln, 
			year(a.tgl_masuk)as thn, 
			a.kelas_tujuan, 
			c.nama_klas, 
			a.bagian_tujuan,
			a.ket_masuk as status,
			b.nama_bagian 
		FROM 
			ri_tc_riwayat_kelas as a, 
			mt_bagian as b, 
			mt_klas as c 
		WHERE  
			month(a.tgl_masuk)='$bln' and 
			year(a.tgl_masuk)='$thn' and 
			a.kelas_tujuan=c.kode_klas and 
			a.bagian_tujuan=b.kode_bagian 
		GROUP BY 
			day(a.tgl_masuk), 
			month(a.tgl_masuk), 
			year(a.tgl_masuk), 
			a.kelas_tujuan, 
			c.nama_klas, 
			a.bagian_tujuan,
			a.ket_masuk,
			b.nama_bagian,
			b.kode_bagian
			
		) union (
		
		SELECT 
			case b.kode_bagian when 0306 then 'Bayi' else 'Umum' end as golongan,
			case when bagian_tujuan=0306 then 'odc' when bagian_tujuan=0309 then 'odc' else 'ri' end as kegiatan,
			count(a.kode_riw_klas) as jml, 
			day(a.tgl_pindah) as tgl, 
			month(a.tgl_pindah)as bln, 
			year(a.tgl_pindah)as thn, 
			a.kelas_tujuan, 
			c.nama_klas, 
			a.bagian_tujuan,
			a.ket_keluar as status,
			b.nama_bagian 
		FROM 
			ri_tc_riwayat_kelas as a, 
			mt_bagian as b, 
			mt_klas as c
		WHERE  
			month(a.tgl_pindah)='$bln' and 
			year(a.tgl_pindah)='$thn' and 
			a.kelas_tujuan=c.kode_klas and 
			a.bagian_tujuan=b.kode_bagian 
		GROUP BY 
			day(a.tgl_pindah), 
			month(a.tgl_pindah), 
			year(a.tgl_pindah), 
			a.kelas_tujuan, 
			c.nama_klas, 
			a.bagian_tujuan, 
			a.ket_keluar,
			b.nama_bagian,
			b.kode_bagian
			)";
		//$con_id=$this->db;
		$sqlHasil =& $db->Execute($sql);
		//echo "<pre>";
		while ($tampil = $sqlHasil->FetchRow()) {
			$tgl = $tampil["tgl"];
			$bln=$tampil["bln"];
			$thn=$tampil["thn"];
			$status=$tampil["status"];
			$kelas_pas=$tampil["kelas_tujuan"];
			$bag_pas=$tampil["bagian_tujuan"];
			$golongan =$tampil["golongan"];
			$kegiatan = $tampil["kegiatan"];

			/********* Aturan Klas ??? *******/
			if ($kelas_pas>7) {
				$kelas_pas=7;
			} 
			/********* Aturan Klas *******/			
			$this->hasilCariPasien[$tgl][$status] +=$tampil["jml"];
			$this->hasilCariPasienGolongan[$tgl][$status][$golongan] +=$tampil["jml"];
			$this->hasilCariPasienKelas[$tgl][$status][$kelas_pas] +=$tampil["jml"];
			$this->hasilCariPasienKegiatan[$tgl][$kegiatan] +=$tampil["jml"];
					
		} 
		$lastMonth = mktime (0,0,0,$bln,0,$thn);
		$tglLastMonth=strftime("%d",$lastMonth);
		$blnLast=$bln-1;
		$sql_1 = "
		SELECT 
			count(kode_trans_pelayanan)as jml,
			kode_klas 
		FROM 
			tc_trans_pelayanan 
		WHERE 
			day(tgl_transaksi)='$tglLastMonth' and 
			month(tgl_transaksi)='$blnLast' and 
			year(tgl_transaksi)='$thn' and 
			jenis_tindakan=1 and 
			kode_bagian like '03%' and 
			nama_tindakan like 'ruangan%' group by kode_klas 
		";
		$sqlSisa =& $db->Execute($sql_1);
		//echo "<pre>";
		while ($tampilX = $sqlSisa->FetchRow()) {
			$jml=$tampilX["jml"];
			$kd_klas=$tampilX["kode_klas"];
			
			/********* Aturan Klas ??? *******/
			if ($kd_klas>7) {
				$kd_klas=7;
			} 
			/********* Aturan Klas *******/			

			$this -> sisaKelas[$kd_klas] +=$tampilX["jml"];
			
		}

			/*
			print_r($this->hasilCariPasien);
			//print_r($this->hasilCariPasienMasukKelas);
			//print_r($this->hasilCariPasienKegiatan);
			//print_r($this->hasilCariPasienMasuk);
			//print_r($this->hasilCariPasienKeluar);
			echo "</pre>";
			die();
				*/	
	}
	
	// index field  1
	function pasienAwal($tgl) 
	{
		$hasil0 = $this -> sisaKelas[1];
		$hasil1 = $this -> sisaKelas[2];
		$hasil2 = $this -> sisaKelas[3];
		$hasil3 = $this -> sisaKelas[4];
		$hasil4 = $this -> sisaKelas[5];
		$hasil5 = $this -> sisaKelas[6];
		$hasil6 = $this -> sisaKelas[7];
		$hasil = $hasil0 + $hasil1 + $hasil2 + $hasil3 + $hasil4 + $hasil5 + $hasil6;
		return $hasil;
	}
	// index field  2
	
	function pasienMasukUmum ($tgl) 
	{
		$hasil = $this ->hasilCariPasienGolongan[$tgl][0]['Umum'];
		return $hasil;
	}

	// index field  3
	function pasienMasukBayi ($tgl) 
	{
		$hasil = $this ->hasilCariPasienGolongan[$tgl][0]['Bayi'];
		return $hasil;
	}

	// index field  4
	function pasienMasukPindahan ($tgl) 
	{
		$hasil = $this -> hasilCariPasien[$tgl][1];
		return $hasil;
	}

	// index field  5
	function totalPasienMasuk ($tgl) 
	{
		$hasil0 = $this -> pasienMasukUmum ($tgl);
		$hasil1 = $this -> pasienMasukBayi ($tgl);
		$hasil2 = $this -> pasienMasukPindahan ($tgl);
		//$hasil3 = $this -> pasienAwal ($tgl);
		$hasil = $hasil0 + $hasil1 + $hasil2 + $hasil3;
		return $hasil;
	}
	
	// index field 6
	function pasienRawatInap ($tgl) 
	{
		$hasil = $this -> hasilCariPasienKegiatan[$tgl]['ri'];
		return $hasil;
	}
	
	// index field 7
	function pasienODC ($tgl) 
	{
		$hasil = $this -> hasilCariPasienKegiatan[$tgl]['odc'];
		return $hasil;
	}
	
	// index field 8
	function pasienKeluarHidup ($tgl) 
	{
		$hasil = $this->hasilCariPasien[$tgl][3];
		return $hasil;
	}

	// index field 9
	function pasienKeluarMati ($tgl) 
	{
		$hasil = $this ->hasilCariPasien[$tgl][4];
		return $hasil;
	}
	
	// index field 10
	function pasienKeluarPindahan ($tgl) 
	{
		$hasil = $this ->hasilCariPasien[$tgl][2];
		return $hasil;
	}
	
	// index field 11
	function totalPasienKeluar ($tgl) 
	{
		$hasil0 = $this ->hasilCariPasien[$tgl][2];
		$hasil1 = $this ->hasilCariPasien[$tgl][3];
		$hasil2 = $this ->hasilCariPasien[$tgl][4];
		$hasil = $hasil0 + $hasil1 + $hasil2;
		return $hasil;
	}
	
	// index field 12
	function totalPasienSisa ($tgl) 
	{
		
		
		$hasil0  = $this -> totalPasienMasuk ($tgl);
		$hasil0a = $this -> totalPasienKeluar ($tgl);
				
		$hasil = $hasil0 - $hasil0a;
		return $hasil;
	}

	// index field 13
	function pasienKelasSrom ($tgl) 
	{
		$hasil0 = $this-> pasienMasukKelasSRom($tgl);
		$hasil1 = $this-> pasienKeluarKelasSRom($tgl);
		$hasil5 = $this -> sisaKelas[1];
		$hasil = $hasil5 + $hasil0 - $hasil1;
		return $hasil;
	}

	// index field 14
	function pasienKelasSvip ($tgl) 
	{
		$hasil0 = $this -> pasienMasukKelasSvip($tgl);
		$hasil1 = $this -> pasienKeluarKelasSvip($tgl);
		$hasil2 = $this -> sisaKelas[2];
		$hasil = $hasil2 + $hasil0 - $hasil1;
		return $hasil;
	}

	// index field 15
	function pasienKelasVip ($tgl) 
	{
		
		$masuk		= $this -> pasienMasukKelasVip($tgl);
		$keluar		= $this -> pasienKeluarKelasVip($tgl);
		$hasil10	= $this -> sisaKelas[3];
		$hasil11	= $this -> sisaKelas[4];
		
		$hasil = ($hasil10+$hasil11)+$masuk-$keluar;
		return $hasil;
	}

	// index field 16
	function pasienKelasI ($tgl) 
	{
		$masuk	= $this -> pasienMasukKelasI($tgl);
		$keluar	= $this -> PasienKeluarKelasI($tgl);
		$hasil0 = $this -> sisaKelas[5];
		$hasil	= $hasil0 + $masuk - $keluar;  
		return $hasil;
	}

	// index field 17
	function pasienKelasII ($tgl) 
	{
		$masuk	= $this -> pasienMasukKelasII($tgl);
		$keluar	= $this -> PasienKeluarKelasII($tgl);
		$hasil0 = $this -> sisaKelas[6];
		$hasil	= $hasil0 + $masuk - $keluar;
		return $hasil;
	}

	// index field 18
	function pasienKelasIII ($tgl) 
	{
		$masuk	= $this -> pasienMasukKelasIII($tgl);
		$keluar	= $this -> PasienKeluarKelasIII($tgl);
		$hasil0 = $this -> sisaKelas[7];
		$hasil	= $hasil0 + $masuk - $keluar;
		return $hasil;
	}

	// index field 19
	function pasienMasukKelasSrom ($tgl) 
	{
		$hasil0 = $this->hasilCariPasienKelas[$tgl][0][1];
		$hasil1 = $this->hasilCariPasienKelas[$tgl][1][1];
		$hasil = $hasil0 + $hasil1;
		return $hasil;
	}

	// index field 20
	function pasienMasukKelasSvip ($tgl) 
	{
		$hasil0 = $this->hasilCariPasienKelas[$tgl][0][2];
		$hasil1 = $this->hasilCariPasienKelas[$tgl][1][2];
		$hasil = $hasil0 + $hasil1;
		return $hasil;
	}

	// index field 21
	function pasienMasukKelasVip ($tgl) 
	{
		$hasil0 = $this->hasilCariPasienKelas[$tgl][0][3];
		$hasil1 = $this->hasilCariPasienKelas[$tgl][1][3];
		$hasil2 = $this->hasilCariPasienKelas[$tgl][0][4];
		$hasil3 = $this->hasilCariPasienKelas[$tgl][1][4];
		$hasil = $hasil0 + $hasil1 + $hasil2 + $hasil3;
		return $hasil;
	}

	// index field 22
	function pasienMasukKelasI ($tgl) 
	{
		$hasil0 = $this->hasilCariPasienKelas[$tgl][0][5];
		$hasil1 = $this->hasilCariPasienKelas[$tgl][1][5];
		$hasil = $hasil0 + $hasil1;
		return $hasil;
	}

	// index field 23
	function pasienMasukKelasII ($tgl) 
	{
		$hasil0 = $this->hasilCariPasienKelas[$tgl][0][6];
		$hasil1 = $this->hasilCariPasienKelas[$tgl][1][6];
		$hasil = $hasil0 + $hasil1;
		return $hasil;
	}

	// index field 24
	function pasienMasukKelasIII ($tgl) 
	{
		$hasil0 = $this->hasilCariPasienKelas[$tgl][0][7];
		$hasil1 = $this->hasilCariPasienKelas[$tgl][1][7];
		$hasil  = $hasil0 + $hasil1;
		return $hasil;
	}

	// index field 25
	function pasienKeluarKelasSrom ($tgl) 
	{
		$hasil0 = $this->hasilCariPasienKelas[$tgl][2][1];
		$hasil1 = $this->hasilCariPasienKelas[$tgl][3][1];
		$hasil2 = $this->hasilCariPasienKelas[$tgl][4][1];
		$hasil = $hasil0 + $hasil1 + $hasil2;
		return $hasil;
	}

	// index field 26
	function pasienKeluarKelasSvip ($tgl) 
	{
		$hasil0 = $this->hasilCariPasienKelas[$tgl][2][2];
		$hasil1 = $this->hasilCariPasienKelas[$tgl][3][2];
		$hasil2 = $this->hasilCariPasienKelas[$tgl][4][2];
		$hasil = $hasil0 + $hasil1 + $hasil2;
		return $hasil;
	}

	// index field 27
	function pasienKeluarKelasVip ($tgl) 
	{
		$hasil0 = $this->hasilCariPasienKelas[$tgl][2][3];
		$hasil1 = $this->hasilCariPasienKelas[$tgl][3][3];
		$hasil2 = $this->hasilCariPasienKelas[$tgl][4][3];

		$hasil3 = $this->hasilCariPasienKelas[$tgl][2][4];
		$hasil4 = $this->hasilCariPasienKelas[$tgl][3][4];
		$hasil5 = $this->hasilCariPasienKelas[$tgl][4][4];
		$hasil = $hasil0 + $hasil1 + $hasil2 + $hasil3 + $hasil4 + $hasil5;
		return $hasil;
	}

	// index field 28
	function pasienKeluarKelasI ($tgl) 
	{
		$hasil0 = $this->hasilCariPasienKelas[$tgl][2][5];
		$hasil1 = $this->hasilCariPasienKelas[$tgl][3][5];
		$hasil2 = $this->hasilCariPasienKelas[$tgl][4][5];
		$hasil = $hasil0 + $hasil1 + $hasil2;
		return $hasil;
	}

	// index field 29
	function pasienKeluarKelasII ($tgl) 
	{
		$hasil0 = $this->hasilCariPasienKelas[$tgl][2][6];
		$hasil1 = $this->hasilCariPasienKelas[$tgl][3][6];
		$hasil2 = $this->hasilCariPasienKelas[$tgl][4][6];
		$hasil = $hasil0 + $hasil1 + $hasil2;
		return $hasil;
	}

	// index field 30
	function pasienKeluarKelasIII ($tgl) 
	{
		$hasil0 = $this->hasilCariPasienKelas[$tgl][2][7];
		$hasil1 = $this->hasilCariPasienKelas[$tgl][3][7];
		$hasil2 = $this->hasilCariPasienKelas[$tgl][4][7];
		$hasil = $hasil0 + $hasil1 + $hasil2;
		return $hasil;
	}
	
	// index field 30
	function saveToTabelRekap($tgl) 
	{
		$thn=$this->tahunKlas;
		$bln=$this->bulanKlas;
		$con_id=$this->dbKlas;
		
		$nama_kolom[1]="tgl_input";
			$isi_kolom[]="";
		$nama_kolom[2]="tgl";
			$isi_kolom[]="";
		$nama_kolom[3]="bln";
			$isi_kolom[]="";
		$nama_kolom[4]="thn";
			$isi_kolom[]="";
		$nama_kolom[5]="awal";
			$isi_kolom[]="";
		$nama_kolom[6]="masuk_umum";
			$isi_kolom[]="";
		$nama_kolom[7]="masuk_bayi";
			$isi_kolom[]="";
		$nama_kolom[8]="masuk_pindah";
			$isi_kolom[]="";
		$nama_kolom[9]="masuk_jml";
			$isi_kolom[]="";
		$nama_kolom[10]="kegiatan_rwi";
			$isi_kolom[]="";
		$nama_kolom[11]="kegiatan_odc";
			$isi_kolom[]="";
		$nama_kolom[12]="keluar_hidup";
			$isi_kolom[]="";
		$nama_kolom[13]="keluar_mati";
			$isi_kolom[]="";
		$nama_kolom[14]="keluar_pindah";
			$isi_kolom[]="";
		$nama_kolom[15]="keluar_jml";
			$isi_kolom[]="";
		$nama_kolom[16]="";
			$isi_kolom[]="";
		$nama_kolom[17]="";
			$isi_kolom[]="";
		$nama_kolom[18]="";
			$isi_kolom[]="";
		$nama_kolom[19]="";
			$isi_kolom[]="";
		$nama_kolom[20]="";
			$isi_kolom[]="";
		$nama_kolom[21]="";
			$isi_kolom[]="";
		$nama_kolom[22]="";
			$isi_kolom[]="";
		$nama_kolom[23]="";
			$isi_kolom[]="";
		$nama_kolom[24]="";
			$isi_kolom[]="";
		$nama_kolom[25]="";
			$isi_kolom[]="";
		$nama_kolom[26]="";
			$isi_kolom[]="";
		$nama_kolom[27]="";
			$isi_kolom[]="";
		$nama_kolom[28]="";
			$isi_kolom[]="";
		$nama_kolom[29]="";
			$isi_kolom[]="";
		$nama_kolom[30]="";
			$isi_kolom[]="";

		//$sqlInsert="insert into tbl_rekap_harian_rawat_inap ($nama_kolom) values ($isi_kolom)";
		//$sqlCekInsert="select from tbl_rekap_harian_rawat_inap where";
		$sqlHasilCek =& $db->Execute($sqlCekInsert);
		while ($tampilY = $sqlHasilCek->FetchRow()) {
					$bln= $tampilY["bln"];
				}
		if ($bln ==""){
			$sqlHasilInsert =& $db->Execute($sqlInsert);
		}
		
		return $hasil;
	}


	//

	function updateToTblRiwKlas($tgl) 
	{
		$thn=$this->tahunKlas;
		$bln=$this->bulanKlas;

		$con_id=$this->dbKlas;

		// update ket_masuk=========================================================================

		$sql="select * from ri_tc_riwayat_kelas where 
			day(tgl_masuk) =$tgl and 
			month(tgl_masuk)=$bln and 
			year(tgl_masuk)=$thn and ket_masuk is null ";

        $sqlHasil  =& $db->Execute($sql);

		while ($tampilZ = $sqlHasil->FetchRow()) {
			
				$kode_riw_klas= $tampilZ["kode_riw_klas"];
				$kode_ri= $tampilZ["kode_ri"];
				

				$sql_cek="select kode_riw_klas from ri_tc_riwayat_kelas where 
							day(tgl_pindah) =$tgl and 
							month(tgl_pindah)=$bln and
							year(tgl_pindah)=$thn and kode_riw_klas<>$kode_riw_klas and kode_ri=$kode_ri";
                 $sqlcekHasil  =& $db->Execute($sql_cek);

                 while ($tampilW = $sqlcekHasil->FetchRow()) {

					$kode_riw_klas_cek= $tampilW["kode_riw_klas"];
				}

				/*if($kode_riw_klas_cek>0)
					{
						$sqlUpdate1="update ri_tc_riwayat_kelas set ket_masuk=1 where kode_riw_klas=$kode_riw_klas";
					}
					else
					{
						$sqlUpdate1="update ri_tc_riwayat_kelas set ket_masuk=0 where kode_riw_klas=$kode_riw_klas";
					}
				*/
				 $sqlUpdateHasil  =& $db->Execute($sqlUpdate1);
				
		

		}

		// end of update ket_masuk=========================================================================

		// update status_keluar=========================================================================

		$sql2="select * from ri_tc_riwayat_kelas where 
			day(tgl_pindah) =$tgl and
			month(tgl_pindah)=$bln and
			year(tgl_pindah)=$thn and ket_keluar is null ";

        $sqlHasil2  =& $db->Execute($sql2);

        while ($tampilD = $sqlHasil2->FetchRow()) {
	
				$kode_riw_klas2= $tampilD["kode_riw_klas"];
				$kode_ri2= $tampilD["kode_ri"];
				

				$sql_cek2="select kode_riw_klas from ri_tc_riwayat_kelas where 
							day(tgl_masuk) =$tgl and
							month(tgl_masuk)=$bln and
							year(tgl_masuk)=$thn and kode_riw_klas<>$kode_riw_klas2 and kode_ri=$kode_ri2";
				$sqlcekHasil2  =& $db->Execute($sql_cek2);

				 while ($tampilT = $sqlcekHasil2->FetchRow()) {

					$kode_riw_klas_cek2= $tampilT["kode_riw_klas"];
				}

				/*if($kode_riw_klas_cek2>0)
					{
						$sqlUpdate2="update ri_tc_riwayat_kelas set ket_keluar=2 where kode_riw_klas=$kode_riw_klas2";
					}
					else
					{
						$sql_cek_keluar="select kode_ri,waktu_kematian from pulang_sendiri where kondisi like '%meninggal%' and kode_ri=$kode_ri2";
						
						$sql_cek_keluar_hasil  =& $db->Execute($sql_cek_keluar);

                            while ($tampilK = $sql_cek_keluar_hasil->FetchRow()) {

								$kode_ri_cek_keluar= $tampilK["kode_ri"];
								$waktu_kematian= $tampilK["waktu_kematian"];
								}

						if($kode_ri_cek_keluar>0)
						{
							if($waktu_kematian==">48")
							{
								$sqlUpdate2="update ri_tc_riwayat_kelas set ket_keluar=4,kode_kematian=0 where kode_riw_klas=$kode_riw_klas2";
							}
							else
							{
								$sqlUpdate2="update ri_tc_riwayat_kelas set ket_keluar=4,kode_kematian=1 where kode_riw_klas=$kode_riw_klas2";
							}
							
						}
						else
						{
							$sqlUpdate2="update ri_tc_riwayat_kelas set ket_keluar=3 where kode_riw_klas=$kode_riw_klas2";
						}
						
					}
				$sqlUpdateHasil2  =& $db->Execute($sqlUpdate2);
				*/
				
				
		

		}

		// end of update status_keluar=========================================================================
		

		return $hasil;
	}

		}
}
?>