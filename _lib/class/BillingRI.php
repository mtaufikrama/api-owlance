<?
/*
################################

Author	: Suwi D. Utomo
Versi	: 1.7
Tanggal	:05/04/2010 16:07

################################
*/

if(!class_exists("BillingRI")){
	class BillingRI{
		var $_db;
		var $_usrtmp= array();
		var $_billKamarPerawatan;
		var $_billTotal;
		var $_bagian;

		function __construct() {	
			global $db;
			global $usrtmp;
			global $bagian;
			global $_kelas;

			$this->_db					= $db;			
			$this->_usrtmp				= $usrtmp;
			$this->_bagian				= $bagian;
			$this->_kelas				= $_kelas;
			
			$this->_global_biasa_rs		= "sum(case bill_rs when null then 0 else bill_rs end) as totalan";
			$this->_global_biasa_total	= "sum((case bill_dr1 when null then 0 else bill_dr1 end)+(case bill_dr2 when null then 0 else bill_dr2 end)+(case bill_dr3 when null then 0 else bill_dr3 end)+(case bill_rs when null then 0 else bill_rs end)) as totalan";
			
			$tgl_now					= date("d");
			$bln_now					= date("m");
			$thn_now					= date("Y");
			$this->billTotal			= 0;
			$this->billKamarPerawatan	= 0;
			$this->billKamarICU			= 0;
			$this->billTindakanInap		= 0;
			$this->billTindakanBedah	= 0;
			$this->billTindakanVK		= 0;
			$this->billObatAlkes		= 0;
			$this->billAmbulan			= 0;
			$this->billBiayaDokter		= 0;
			$this->billBiayaApotik		= 0;
			$this->billLuarRI			= 0;
			$this->billLuarRs			= 0;
			$this->billSewaAlat			= 0;
			$this->billLainLain			= 0;
		}

		function hitungBilling($no_registrasi,$kode_ri){
			global $PHP_SELF;
			
		}

		function kamarPerawatan($no_registrasi,$kode_ri){
			$_tot_kmr = read_tabel("tc_trans_pelayanan",$this->_global_biasa_rs,"where no_registrasi = $no_registrasi and nama_tindakan like 'Ruangan %' and kode_bagian not like '0310%' and status_selesai <= 3 ");
			$tot_kmr = $_tot_kmr->fields["totalan"];
			
			if ($tot_kmr > 0) {
				$hargaRNow = baca_tabel("tc_trans_pelayanan","kode_trans_pelayanan","where no_registrasi = $no_registrasi and nama_tindakan like 'Ruangan %' and kode_bagian not like '0310%' and status_selesai <= 3 and day(tgl_transaksi) = '$tgl_now' and month(tgl_transaksi) = '$bln_now' and year(tgl_transaksi) = '$thn_now' ");
				
				if (( $hargaRNow == 0 ) && ( $bagian != '031001' )) {
					$hargaR = baca_tabel("mt_master_tarif_ruangan","harga_r","where kode_bagian = ".$this->_bagian." and kode_klas = ".$this->_kelas);
				} else {
					$hargaR = 0;
				}
				
				$tot_kmr = $tot_kmr + $hargaR;
				$this->billKamarPerawatan = uang($tot_kmr,true); 

			} else if (( $kode_trans == "" ) && ( $bagian != '031001' )) {
				$tot_kmr = baca_tabel("mt_master_tarif_ruangan","harga_r","where kode_bagian = ".$this->_bagian." and kode_klas = ".$this->_kelas);
				$this->billKamarPerawatan = uang($tot_kmr,true);
			} else {
				$this->billKamarPerawatan = uang(0,true);
			}
			return $this->billKamarPerawatan;
		}

		function kamarICU($no_registrasi,$kode_ri){
			$_tot_kamar = read_tabel("tc_trans_pelayanan",$this->_global_biasa_rs,"where no_registrasi = $no_registrasi and nama_tindakan like 'Ruangan %' and kode_bagian like '0310%' and status_selesai <= 3 ");
			$tot_kamar = $_tot_kamar->fields["totalan"];

			if ($tot_kamar > 0) {
				$cekICU = baca_tabel("tc_trans_pelayanan","kode_trans_pelayanan","where no_registrasi = $no_registrasi and jenis_tindakan = 1  and day(tgl_transaksi) = '$tgl_now' and month(tgl_transaksi) = '$bln_now' and year(tgl_transaksi) = '$thn_now' and kode_bagian = '031001' order by kode_trans_pelayanan desc");

					if (( $cekICU == 0 ) && ( $bagian == '031001' ))
						$tarifICU = baca_tabel("mt_master_tarif_ruangan","harga_r","where kode_bagian = '031001' and kode_klas = 11");
					else
						$tarifICU = 0;

				$tot_kamar = $tot_kamar + $tarifICU;
				$this->billKamarICU = uang($tot_kamar,true); 
			} elseif (( $kode_trans == "" ) && ( $bagian == '031001' )) {
				$tot_kamar = baca_tabel("mt_master_tarif_ruangan","harga_r","where kode_bagian like '0310%' and kode_klas = 11");
				$this->billKamarICU = uang($tot_kamar,true);
			} else {
				$tot_kamar = 0;
				$this->billKamarICU = uang($tot_kamar,true);
			}
			return $this->billKamarICU;
		}
		
		function tindakanInap($no_registrasi){
			$sql_tin = read_tabel("tc_trans_pelayanan",$this->_global_biasa_total,"where no_registrasi = $no_registrasi and (jenis_tindakan = 3 or jenis_tindakan = 12) and (kode_bagian like '03%') AND (kode_bagian <> '030501') AND (kode_bagian <> '".AV_KAMAR_BEDAH."') and status_selesai <= 3 ");
			$tot_tin = $sql_tin->fields["totalan"];
			$this->billTindakanInap = uang($tot_tin,true);
			return $this->billTindakanInap;
		}

		function tindakanBedah($no_registrasi){
			$sql_bed = read_tabel("tc_trans_pelayanan",$this->_global_biasa_total,"where no_registrasi = $no_registrasi and kode_bagian = '".AV_KAMAR_BEDAH."' and status_selesai <= 3 ");
			$tot_bed = $sql_bed->fields["totalan"];
			$this->billTindakanBedah = uang($tot_bed,true);
			return $this->billTindakanBedah;
		}

		function tindakanVK($no_registrasi){
			$sql_vk = read_tabel("tc_trans_pelayanan",$this->_global_biasa_total,"where no_registrasi = $no_registrasi and kode_bagian = '030501' and status_selesai <= 3 ");
			$tot_vk = $sql_vk->fields["totalan"];		
			$this->billTindakanVK = uang($tot_vk,true);
			return $this->billTindakanVK;
		}
		
		function obatAlkes($no_registrasi){
			$_tot_ob = read_tabel("tc_trans_pelayanan","$this->_global_biasa_rs","where no_registrasi = $no_registrasi and jenis_tindakan = 9 and status_selesai <= 3 and kode_bagian like '03%' AND kode_bagian not in ('030501','".AV_KAMAR_BEDAH."')");
			$tot_ob = $_tot_ob->fields["totalan"];
			$this->billObatAlkes= uang($tot_ob,true);
			return $this->billObatAlkes;
		}

		function ambulan($no_registrasi){
			$_tot_amb = read_tabel("tc_trans_pelayanan","$this->_global_biasa_rs","where no_registrasi = $no_registrasi and jenis_tindakan = 6 and status_selesai <= 3 ");
			$tot_amb = $_tot_amb->fields["totalan"];
			$this->billAmbulan = uang($tot_amb,true);
			return $this->billAmbulan;
		}
		
		function biayaDokter($no_registrasi){
			$_tot_dok = read_tabel("tc_trans_pelayanan","$this->_global_biasa_dr","where no_registrasi = $no_registrasi  and jenis_tindakan = 4 and status_selesai <= 3 and kode_bagian like '03%'");
			$tot_dok = $_tot_dok->fields["totalan"];
			$this->billBiayaDokter = uang($tot_dok,true);
			return $this->billBiayaDokter;
		}

		function biayaApotik($no_registrasi){
			$apoA = read_tabel("tc_trans_pelayanan","sum(case when bill_rs IS NULL then 0 else bill_rs end) as bi_apo,sum(case when lain_lain IS NULL then 0 else lain_lain end) as bi_lain,status_selesai","where no_registrasi = $no_registrasi and kode_bagian like '06%' and status_selesai <= 3 and (status_kredit = 0 OR status_kredit is null) group by status_selesai");
					  
		   $_statusA = $apoA->fields["status_selesai"];
		   
		   $_bi_apoA = $apoA->fields["bi_apo"];
		   $_bi_lainA = $apoA->fields["bi_lain"];
		   

		   $apoB = read_tabel("tc_trans_pelayanan","sum(case when bill_rs IS NULL then 0 else bill_rs end) as bi_apo,sum(case when lain_lain IS NULL then 0 else lain_lain end) as bi_lain","where no_registrasi = $no_registrasi and kode_bagian like '06%' and status_selesai <= 3 and status_kredit = 1 ");
							   
		   $_bi_apoB = $apoB->fields["bi_apo"];
		   $_bi_lainB = $apoB->fields["bi_lain"];

		   if ( $_statusA == 3 ) {
			 $bi_apo = ( $_bi_apoA + $_bi_lainA ) - ( $_bi_apoB + $_bi_lainB ) ;
			 $billApo = 0 ;
		   } else {
			 $bi_apo = ( $_bi_apoA + $_bi_lainA ) - ( $_bi_apoB + $_bi_lainB ) ;
			 $billApo = $bi_apo ;
		   }
			$this->billBiayaApotik = uang($billApo);
			return $this->billBiayaApotik;
		}

		function luarRI($no_registrasi){
			$a=0;
			$temp = "";

			$sql_bag = read_tabel("tc_trans_pelayanan","kode_bagian","where no_registrasi = $no_registrasi and (kode_bagian not like '06%' and kode_bagian not like '03%') group by kode_bagian");

			while ($res = $sql_bag->FetchRow()) {
				$kode_bagian = $res["kode_bagian"];
				$bagis = baca_tabel("mt_bagian","nama_bagian","where kode_bagian = '$kode_bagian'");

				$duit = read_tabel("tc_trans_pelayanan","$this->_global_biasa_total","where no_registrasi = $no_registrasi and kode_bagian = '$kode_bagian' and kode_bagian not like '03%' and kode_bagian <> '06%' and nama_tindakan <> 'Ruangan ".$bagis."' and status_selesai <= 3");

				$tot_duit = $duit->fields["totalan"];

				if ($tot_duit > 0) {
					$tot_bag_lain = $tot_bag_lain + $tot_duit ;
					
				}
				$this->billLuarRI[$a][$kode_bagian] += $tot_bag_lain;
				$this->namaBillLuarRI[$kode_bagian] = $bagis;
				$a++;
			}
			return $this->billLuarRI;
		}

		function luarRs($no_registrasi){
			$sql_lr = read_tabel("tc_trans_pelayanan","$this->_detail_biasa_total","where status_selesai <= 3 and jenis_tindakan = 10 AND no_registrasi = $no_registrasi and kode_bagian like '03%' group by kode_dokter1,kode_dokter2,kode_dokter3,nama_tindakan,tgl_transaksi,jumlah,kode_trans_pelayanan");
			//echo $sql_read_tabel;
			
				while ($res_lr = $sql_lr->FetchRow()) {

				    $rs					= $res_lr["nama_tindakan"];
				    $bi_lr				= $res_lr["totalan"];
 				    $kodeTrans			= $res_lr["kode_trans_pelayanan"];
					$tot_lr				= $tot_lr + $bi_lr;
					$this->billLuarRs	+= $tot_lr;
				}
				
			return $this->billLuarRs;
		}
		
		function sewaAlat($no_registrasi){
			$_bi_sw = read_tabel("tc_trans_pelayanan","$this->_global_biasa_rs","where no_registrasi = $no_registrasi and jenis_tindakan = 5 and kode_bagian like '03%' and status_selesai < 3");
			$bi_sw = $_bi_sw->fields["totalan"];
			$this->billSewaAlat = $bi_sw;
			return $this->billSewaAlat;
		}

		function lainLain($no_registrasi){
			$sql_ln = read_tabel("tc_trans_pelayanan","$this->_global_biasa_total","where no_registrasi = $no_registrasi and jenis_tindakan = 8 and status_selesai <= 3 and kode_bagian like '03%' AND (kode_bagian <> '030501' AND kode_bagian <> '".AV_KAMAR_BEDAH."')");
			$ye = $sql_read_tabel;

			$bi_ln = $sql_ln->fields["totalan"];
			$this->billLainLain = $bi_ln;
			return $this->billLainLain;
		}
	
	}	
		
}
?>