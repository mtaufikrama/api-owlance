<?
if(!class_exists("pajak_fee_dokter")){
	class pajak_fee_dokter{
		var $db;

		function pajak_fee_dokter($db,$kode_dokter,$jumlah_tagihan,$bln_mulai,$thn_mulai){
			
			$sql_paramter1=read_tabel("mt_pajak_progresif","nilai_min,nilai_max,persentase_pajak","where id_mt_pajak_progresif=1");
			$nilai_min1=$sql_paramter1->fields["nilai_min"] ; 
			$nilai_max1=$sql_paramter1->fields["nilai_max"] ; 
			$persentase_pajak1=$sql_paramter1->fields["persentase_pajak"] ; 

			$sql_paramter2=read_tabel("mt_pajak_progresif","nilai_min,nilai_max,persentase_pajak","where id_mt_pajak_progresif=2");
			$nilai_min2=$sql_paramter2->fields["nilai_min"] ; 
			$nilai_max2=$sql_paramter2->fields["nilai_max"] ; 
			$persentase_pajak2=$sql_paramter2->fields["persentase_pajak"] ; 

			$sql_paramter3=read_tabel("mt_pajak_progresif","nilai_min,nilai_max,persentase_pajak","where id_mt_pajak_progresif=3");
			$nilai_min3=$sql_paramter3->fields["nilai_min"] ; 
			$nilai_max3=$sql_paramter3->fields["nilai_max"] ; 
			$persentase_pajak3=$sql_paramter3->fields["persentase_pajak"] ;

			$sql_paramter4=read_tabel("mt_pajak_progresif","nilai_min,nilai_max,persentase_pajak","where id_mt_pajak_progresif=4");
			$nilai_min4=$sql_paramter4->fields["nilai_min"] ; 
			$nilai_max4=$sql_paramter4->fields["nilai_max"] ; 
			$persentase_pajak4=$sql_paramter4->fields["persentase_pajak"] ;

			$bulan_sebelum=$bln_mulai-1;
			$status=baca_tabel("tc_pajak_dokter","status","where kode_dokter=$kode_dokter and bulan_fee_dokter = $bulan_sebelum and thn_fee_dokter=$thn_mulai");

			$sql_saldo_awal=baca_tabel("tc_pajak_dokter","saldo_awal_dpp","where kode_dokter=$kode_dokter and kode_dokter=$kode_dokter  and bulan_fee_dokter = $bulan_sebelum and thn_fee_dokter=$thn_mulai");

			if($sql_saldo_awal==''){
				$saldo_awal_dpp=$sql_saldo_awal;
			}else{
				
				$saldo_awal_dpp=baca_tabel("tc_pajak_dokter","dpp_kumulatif","where kode_dokter=$kode_dokter and bulan_fee_dokter = $bulan_sebelum and thn_fee_dokter=$thn_mulai");
			}
				$dpp_kumulatif=baca_tabel("tc_pajak_dokter","sum(dpp_kumulatif)","where kode_dokter=$kode_dokter and bulan_fee_dokter = $bln_mulai and thn_fee_dokter=$thn_mulai");
			

			//$cek_pajak_masuk=baca_tabel("tc_pajak_fee_dokter","sum(nominal_akumulasi_pendapatan)","where kd_dokter=$kode_dokter and bulan_fee_dokter < $bln_mulai and thn_fee_dokter=$thn_mulai");
			$cek_pajak_masuk=baca_tabel("tc_pajak_dokter","sum(dpp)","where kode_dokter=$kode_dokter and bulan_fee_dokter < $bln_mulai and thn_fee_dokter=$thn_mulai");
			$tot_bruto=$jumlah_tagihan * 0.5;
			$tot_brutonya=$cek_pajak_masuk + $tot_bruto;
			$this->hasilDpp[$kode_dokter]=$tot_brutonya;

		
					

			if($tot_brutonya < $nilai_max1){
				
				$nilai_pajak=$tot_brutonya * $persentase_pajak1/100;

			/////////////////////////////////////////////////////////////////////////////
				$result = true;
				$db->BeginTrans();
				unset($tcPajakDokter);
				$dpp_kumulatif=$saldo_awal_dpp+$tot_bruto;
				
				$tcPajakDokter["bulan_fee_dokter"] = $bln_mulai;
				$tcPajakDokter["thn_fee_dokter"] = $thn_mulai;
				$tcPajakDokter["kode_dokter"] = $kode_dokter;
				$tcPajakDokter["total_dr"] = $jumlah_tagihan;
				$tcPajakDokter["saldo_awal_dpp"] = $saldo_awal_dpp;
				$tcPajakDokter["dpp"] = $tot_bruto;
				$tcPajakDokter["dpp_kumulatif"] = $dpp_kumulatif;
				$tcPajakDokter["lima_persen"] = '0';
				$tcPajakDokter["dua_lima_persen"] = '0';
				$tcPajakDokter["tiga_puluh_persen"] = '0';;
	
				$result = insert_tabel("tc_pajak_dokter", $tcPajakDokter);

				$sql_pph21 = read_tabel("tc_pajak_dokter","dpp_kumulatif,lima_persen,lima_belas_persen,dua_lima_persen,tiga_puluh_persen","where kode_dokter=$kode_dokter and bulan_fee_dokter = $bln_mulai and thn_fee_dokter=$thn_mulai");	
					 $lima_persen = $sql_pph21->fields["lima_persen"];
					 $lima_belas_persen = $sql_pph21->fields["lima_belas_persen"];
					 $dua_lima_persen = $sql_pph21->fields["dua_lima_persen"];
					 $tiga_puluh_persen = $sql_pph21->fields["tiga_puluh_persen"];
					 $dpp_kumulatif = $sql_pph21->fields["dpp_kumulatif"];
					 $lima_belas_persen* $persentase_pajak2;
				

				unset($editTcPajakDokter);
				$editTcPajakDokter["lima_persen"] = $dpp_kumulatif * $persentase_pajak1/100;
				$result = update_tabel("tc_pajak_dokter", $editTcPajakDokter, "where kode_dokter=$kode_dokter and bulan_fee_dokter = $bln_mulai and thn_fee_dokter=$thn_mulai");

				$lima_persen=baca_tabel("tc_pajak_dokter","lima_persen","where kode_dokter=$kode_dokter and bulan_fee_dokter = $bln_mulai and thn_fee_dokter=$thn_mulai");
				$pph_21=$lima_persen;

					unset($editPph21);
					$editPph21["pph_21"] = $pph_21;
					
					$result = update_tabel("tc_pajak_dokter", $editPph21, "where kode_dokter=$kode_dokter and bulan_fee_dokter = $bln_mulai and thn_fee_dokter=$thn_mulai");
				
				$db->CommitTrans($result !== false);

			/////////////////////////////////////////////////////////////////////////////
			
			}else if(($tot_brutonya > $nilai_min2) && ($tot_brutonya < $nilai_max2)){
				
				if($status=='1'){
					
					$nilai_pajak=$tot_brutonya* $persentase_pajak2/100;

				/////////////////////////////////////////////////////////////////////////////
				$result = true;
				$db->BeginTrans();
				unset($tcPajakDokter);
				$dpp_kumulatif=$saldo_awal_dpp+$tot_bruto;
				
				$tcPajakDokter["bulan_fee_dokter"] = $bln_mulai;
				$tcPajakDokter["thn_fee_dokter"] = $thn_mulai;
				$tcPajakDokter["kode_dokter"] = $kode_dokter;
				$tcPajakDokter["total_dr"] = $jumlah_tagihan;
				$tcPajakDokter["saldo_awal_dpp"] = $saldo_awal_dpp;
				$tcPajakDokter["dpp"] = $tot_bruto;
				$tcPajakDokter["dpp_kumulatif"] = $dpp_kumulatif;
				$tcPajakDokter["dua_lima_persen"] = '0';
				$tcPajakDokter["tiga_puluh_persen"] = '0';
				$tcPajakDokter["status"] = "1";
	
				$result = insert_tabel("tc_pajak_dokter", $tcPajakDokter);

				$sql_pph21 = read_tabel("tc_pajak_dokter","dpp,lima_persen,lima_belas_persen,dua_lima_persen,tiga_puluh_persen","where kode_dokter=$kode_dokter and bulan_fee_dokter = $bln_mulai and thn_fee_dokter=$thn_mulai");	
					 $dpp = $sql_pph21->fields["dpp"];
					 $lima_persen = $sql_pph21->fields["lima_persen"];
					 $lima_belas_persen = $sql_pph21->fields["lima_belas_persen"];
					 $dua_lima_persen = $sql_pph21->fields["dua_lima_persen"];
					 $tiga_puluh_persen = $sql_pph21->fields["tiga_puluh_persen"];
					 $pph_21=$lima_persen+$lima_belas_persen+$dua_lima_persen;


				unset($editTcPajakDokter);
				$editTcPajakDokter["pph_21"] = $pph_21;
				$editTcPajakDokter["lima_belas_persen"] = $dpp *$persentase_pajak2/100;
				$result = update_tabel("tc_pajak_dokter", $editTcPajakDokter, "where kode_dokter=$kode_dokter and bulan_fee_dokter = $bln_mulai and thn_fee_dokter=$thn_mulai");

				
				$lima_belas_persen_08=baca_tabel("tc_pajak_dokter","lima_belas_persen","where kode_dokter=$kode_dokter and bulan_fee_dokter = $bln_mulai and thn_fee_dokter=$thn_mulai");
				$pph_21_08=$lima_belas_persen_08;

					unset($editPph21_02);
					$editPph21_02["pph_21"] = $pph_21_08;
					$editPph21_02["lima_persen"] = '';
					
					$result = update_tabel("tc_pajak_dokter", $editPph21_02, "where kode_dokter=$kode_dokter and bulan_fee_dokter = $bln_mulai and thn_fee_dokter=$thn_mulai");
				
				$db->CommitTrans($result !== false);

				/////////////////////////////////////////////////////////////////////////////
				
				}else{
					
					$nilai_pajak1=($tot_brutonya-$nilai_max1)* $persentase_pajak2/100;
					$nilai_pajak2=($nilai_max1-$tot_brutonya) * $persentase_pajak1/100;
					$nilai_pajak=$nilai_pajak1 + $nilai_pajak2;
					//insert status=1

					/////////////////////////////////////////////////////////////////////////////
				$result = true;
				$db->BeginTrans();
				unset($tcPajakDokter1);
				$dpp_kumulatif=$saldo_awal_dpp+$tot_bruto;
				
				$tcPajakDokter1["bulan_fee_dokter"] = $bln_mulai;
				$tcPajakDokter1["thn_fee_dokter"] = $thn_mulai;
				$tcPajakDokter1["kode_dokter"] = $kode_dokter;
				$tcPajakDokter1["total_dr"] = $jumlah_tagihan;
				$tcPajakDokter1["saldo_awal_dpp"] = $saldo_awal_dpp;
				$tcPajakDokter1["dpp"] = $tot_bruto;
				$tcPajakDokter1["dpp_kumulatif"] = $dpp_kumulatif;
				$tcPajakDokter1["dua_lima_persen"] = '0';
				$tcPajakDokter1["tiga_puluh_persen"] = '0';
				$tcPajakDokter1["status"] = "1";
	
				$result = insert_tabel("tc_pajak_dokter", $tcPajakDokter1);

				$sql_pph21 = read_tabel("tc_pajak_dokter","saldo_awal_dpp,dpp_kumulatif,lima_persen,lima_belas_persen,dua_lima_persen,tiga_puluh_persen","where kode_dokter=$kode_dokter and bulan_fee_dokter = $bln_mulai and thn_fee_dokter=$thn_mulai");	
					 $dpp_kumulatif = $sql_pph21->fields["dpp_kumulatif"];
					 $saldo_awal_dpp = $sql_pph21->fields["saldo_awal_dpp"];
					 $lima_persen = $sql_pph21->fields["lima_persen"];
					 $lima_belas_persen = $sql_pph21->fields["lima_belas_persen"];
					 $dua_lima_persen = $sql_pph21->fields["dua_lima_persen"];
					 $tiga_puluh_persen = $sql_pph21->fields["tiga_puluh_persen"];
					 $pph_21=$lima_persen+$lima_belas_persen+$dua_lima_persen+$tiga_puluh_persen;


				unset($editTcPajakDokter1);
				$editTcPajakDokter1["lima_persen"] =($nilai_max1-$saldo_awal_dpp)* $persentase_pajak1/100;
				$editTcPajakDokter1["lima_belas_persen"] =($dpp_kumulatif-$nilai_max1)* $persentase_pajak2/100;
				$editTcPajakDokter1["pph_21"] = $pph_21;
				$result = update_tabel("tc_pajak_dokter", $editTcPajakDokter1, "where kode_dokter=$kode_dokter and bulan_fee_dokter = $bln_mulai and thn_fee_dokter=$thn_mulai");

				$lima_persen_02=baca_tabel("tc_pajak_dokter","lima_persen","where kode_dokter=$kode_dokter and bulan_fee_dokter = $bln_mulai and thn_fee_dokter=$thn_mulai");
				$lima_belas_persen_02=baca_tabel("tc_pajak_dokter","lima_belas_persen","where kode_dokter=$kode_dokter and bulan_fee_dokter = $bln_mulai and thn_fee_dokter=$thn_mulai");
				$pph_21_02=$lima_persen_02 + $lima_belas_persen_02;

					unset($editPph21_02);
					$editPph21["pph_21"] = $pph_21_02;
					
					$result = update_tabel("tc_pajak_dokter", $editPph21, "where kode_dokter=$kode_dokter and bulan_fee_dokter = $bln_mulai and thn_fee_dokter=$thn_mulai");
				
				$db->CommitTrans($result !== false);

				/////////////////////////////////////////////////////////////////////////////
				}
				
			
			}else if(($tot_brutonya > $nilai_min3) && ($tot_brutonya < $nilai_max3)){


				if($status=='2'){
					$nilai_pajak2=($tot_brutonya-$nilai_max2)* $persentase_pajak3/100;
					$nilai_pajak3=($jumlah_tagihan-$nilai_max2) * $persentase_pajak2/100;
					$nilai_pajak=$nilai_pajak2 + $nilai_pajak3;
					//insert status=2

					$result = true;
					$db->BeginTrans();
					unset($tcPajakDokter04);
					$dpp_kumulatif=$saldo_awal_dpp+$tot_bruto;
					
					$tcPajakDokter04["bulan_fee_dokter"] = $bln_mulai;
					$tcPajakDokter04["thn_fee_dokter"] = $thn_mulai;
					$tcPajakDokter04["kode_dokter"] = $kode_dokter;
					$tcPajakDokter04["total_dr"] = $jumlah_tagihan;
					$tcPajakDokter04["saldo_awal_dpp"] = $saldo_awal_dpp;
					$tcPajakDokter04["dpp"] = $tot_bruto;
					$tcPajakDokter04["dpp_kumulatif"] = $dpp_kumulatif;
					$tcPajakDokter04["dua_lima_persen"] = '0';
					$tcPajakDokter04["tiga_puluh_persen"] = '0';
					$tcPajakDokter04["status"] = "2";
		
					$result = insert_tabel("tc_pajak_dokter", $tcPajakDokter04);
					
					$sql_pph21_04 = read_tabel("tc_pajak_dokter","saldo_awal_dpp,dpp_kumulatif,dpp,lima_persen,lima_belas_persen,dua_lima_persen,tiga_puluh_persen","where kode_dokter=$kode_dokter and bulan_fee_dokter = $bln_mulai and thn_fee_dokter=$thn_mulai");	
						 $dpp_kumulatif = $sql_pph21_04->fields["dpp_kumulatif"];
						 $saldo_awal_dpp = $sql_pph21_04->fields["saldo_awal_dpp"];
						 $dpp = $sql_pph21_04->fields["dpp"];

						unset($editTcPajakDokter04);
						$editTcPajakDokter04["lima_persen"] ='0';
						$editTcPajakDokter04["lima_belas_persen"] ='0';
						$editTcPajakDokter04["dua_lima_persen"] =$dpp * $persentase_pajak3/100;
						$result = update_tabel("tc_pajak_dokter", $editTcPajakDokter04, "where kode_dokter=$kode_dokter and bulan_fee_dokter = $bln_mulai and thn_fee_dokter=$thn_mulai");

						$lima_belas_persen_04=baca_tabel("tc_pajak_dokter","lima_belas_persen","where kode_dokter=$kode_dokter and bulan_fee_dokter = $bln_mulai and thn_fee_dokter=$thn_mulai");
						$dua_lima_persen_04=baca_tabel("tc_pajak_dokter","dua_lima_persen","where kode_dokter=$kode_dokter and bulan_fee_dokter = $bln_mulai and thn_fee_dokter=$thn_mulai");
						$pph_21_04=$lima_belas_persen_04+$dua_lima_persen_04;

						unset($editPph21_04);
						$editPph21_04["pph_21"] = $pph_21_04;
						$result = update_tabel("tc_pajak_dokter", $editPph21_04, "where kode_dokter=$kode_dokter and bulan_fee_dokter = $bln_mulai and thn_fee_dokter=$thn_mulai");

					
					$db->CommitTrans($result !== false);

					/////////////////////////////////////////////////////////////////////////////

				}else{
					$nilai_pajak=$tot_brutonya* $persentase_pajak3/100;
					/////////////////////////////////////////////////////////////////////////////
					
					
					$result = true;
					$db->BeginTrans();
					unset($tcPajakDokter04);
					$dpp_kumulatif=$saldo_awal_dpp+$tot_bruto;
					
					$tcPajakDokter03["bulan_fee_dokter"] = $bln_mulai;
					$tcPajakDokter03["thn_fee_dokter"] = $thn_mulai;
					$tcPajakDokter03["kode_dokter"] = $kode_dokter;
					$tcPajakDokter03["total_dr"] = $jumlah_tagihan;
					$tcPajakDokter03["saldo_awal_dpp"] = $saldo_awal_dpp;
					$tcPajakDokter03["dpp"] = $tot_bruto;
					$tcPajakDokter03["dpp_kumulatif"] = $dpp_kumulatif;
					$tcPajakDokter03["dua_lima_persen"] = '0';
					$tcPajakDokter03["tiga_puluh_persen"] = '0';
					$tcPajakDokter03["status"] = "2";
		
					$result = insert_tabel("tc_pajak_dokter", $tcPajakDokter03);
					
					$sql_pph21_03 = read_tabel("tc_pajak_dokter","saldo_awal_dpp,dpp_kumulatif,dpp,lima_persen,lima_belas_persen,dua_lima_persen,tiga_puluh_persen","where kode_dokter=$kode_dokter and bulan_fee_dokter = $bln_mulai and thn_fee_dokter=$thn_mulai");	
						 $dpp_kumulatif = $sql_pph21_03->fields["dpp_kumulatif"];
						 $saldo_awal_dpp = $sql_pph21_03->fields["saldo_awal_dpp"];
						 $dpp = $sql_pph21_03->fields["dpp"];
						

						 
						 


					unset($editTcPajakDokter3);
					$editTcPajakDokter3["lima_persen"] ='0';
					$editTcPajakDokter3["lima_belas_persen"] =($nilai_min3-$saldo_awal_dpp)* $persentase_pajak2/100;
					$editTcPajakDokter3["dua_lima_persen"] =($dpp_kumulatif-$nilai_max2)* $persentase_pajak3/100;
					$result = update_tabel("tc_pajak_dokter", $editTcPajakDokter3, "where kode_dokter=$kode_dokter and bulan_fee_dokter = $bln_mulai and thn_fee_dokter=$thn_mulai");

					$lima_belas_persen_03=baca_tabel("tc_pajak_dokter","lima_belas_persen","where kode_dokter=$kode_dokter and bulan_fee_dokter = $bln_mulai and thn_fee_dokter=$thn_mulai");
					 $dua_lima_persen_03=baca_tabel("tc_pajak_dokter","dua_lima_persen","where kode_dokter=$kode_dokter and bulan_fee_dokter = $bln_mulai and thn_fee_dokter=$thn_mulai");
					 $pph_21_03=$lima_belas_persen_03+$dua_lima_persen_03;

					unset($editPph21_03);
					$editPph21_03["pph_21"] = $pph_21_03;
					$result = update_tabel("tc_pajak_dokter", $editPph21_03, "where kode_dokter=$kode_dokter and bulan_fee_dokter = $bln_mulai and thn_fee_dokter=$thn_mulai");

					
					$db->CommitTrans($result !== false);

					/////////////////////////////////////////////////////////////////////////////
				}
				
				//$nilai_pajak1=$nilai_max1 * $persentase_pajak1/100;
				$nilai_pajak2=($nilai_max2-$nilai_max1) * $persentase_pajak2/100;
				$hitung=$tot_brutonya-($nilai_max1+($nilai_max2-$nilai_max1)) ;
				$nilai_pajak3=$hitung * $persentase_pajak3/100;
				$nilai_pajak=$nilai_pajak1 + $nilai_pajak2 + $nilai_pajak3;

			}else if(($tot_brutonya > $nilai_min4) && ($tot_brutonya < $nilai_max4)){
				
				$nilai_dua=$nilai_max2-$nilai_max1;
				$nilai_pajak1=$nilai_max1 * $persentase_pajak1/100;
				$nilai_pajak2=($nilai_max2-$nilai_max1)* $persentase_pajak2/100;
				$nilai_pajak3=$nilai_min3 * $persentase_pajak3/100;
				$hitung=$tot_brutonya-($nilai_max1+$nilai_dua+$nilai_min3) ;
				$nilai_pajak4=$hitung * $persentase_pajak4/100;
				$nilai_pajak=$nilai_pajak1 + $nilai_pajak2 + $nilai_pajak3 + $nilai_pajak4;
			}else{
				$nilai_pajak=0;
			}

			$this->hasilPajak[$kode_dokter]=$nilai_pajak;
			$this->hasilDppkumulatif[$kode_dokter]=$dpp_kumulatif;
			
			/*echo "<pre>";
			print_r($this->hasilPajak);
			echo "</pre>";
			*/			
		}

		function NilaiPajak($kode_dokter){
			$hasil = $this->hasilPajak[$kode_dokter];
			return $hasil;
		}
	
		function NilaiDpp($kode_dokter){
			$hasil = $this->hasilDpp[$kode_dokter];
			return $hasil;
		}
	
		function NilaiDppKumulatif($kode_dokter){
			$hasil = $this->hasilDppkumulatif[$kode_dokter];
			return $hasil;
		}	
	}
}
?>