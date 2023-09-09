<?php
	if (!defined("WWWROOT")) {
		$fname=dirname(__FILE__);
		$wwwroot=substr($fname,0,-14);
		define("WWWROOT",$wwwroot);

		// unset all unused local variables
		unset($wwwroot,$fname);
	}
	include WWWROOT."/_configs/global.php";
	require_once 'vendor/autoload.php';
	$urlx				=$AV_CONF["pcare"]["url"];
	$url_antrean		=$AV_CONF["pcare"]["url_antrean"];
	$service			=$AV_CONF["pcare"]["service"];
	$consid				=$AV_CONF["pcare"]["consid"];
	$consSecret			=$AV_CONF["pcare"]["conscret"];
	$userkey			=$AV_CONF["pcare"]["userkey"];
	
	class bpjs{		
		
		var $consid;
		var $consSecret;

		public $xconsid;
		public $xtimestamp;
		public $xsignature;
		public $userkey;
		public $debug;
		

		function __construct() {		
			
		}
		
		function decompress($string){
      
			return \LZCompressor\LZString::decompressFromEncodedURIComponent($string);

		}
		
		function loop($test){
			foreach($test as $key=>$val){		
				if(is_array($val)){				
						foreach($val as $key1=>$val1){		
							if(is_array($val1)){				
									// --- array --- 2 ---
									foreach($val1 as $key2=>$val2){		
										if(is_array($val2)){				
												// --- array --- 3 ---
												foreach($val2 as $key3=>$val3){		
													if(is_array($val3)){				
															// --- array --- 4 ---
															foreach($val3 as $key4=>$val4){		
																if(is_array($val4)){				
																		// --- array --- 5 ---
																		foreach($val4 as $key5=>$val5){		
																			if(is_array($val5)){				
																					// --- array --- 6 ---
																					foreach($val5 as $key6=>$val6){		
																						if(is_array($val6)){				
																								// --- array --- 7 ---
																								foreach($val6 as $key7=>$val7){		
																									if(is_array($val7)){				
																											// --- array --- 8 ---
																											foreach($val7 as $key8=>$val8){		
																												if(is_array($val8)){				
																														// --- array --- 9 ---
																														
																														// --- array --- 9 ---
																													}else{
																														echo "$key.$key1.$key2.$key3.$key4.$key5.$key6.$key7.$key8: $val8 <br>";			
																													}	
																											}
																											// --- array --- 8 ---
																										}else{
																											echo "$key.$key1.$key2.$key3.$key4.$key5.$key6.$key7: $val7 <br>";			
																										}	
																								}
																								// --- array --- 7 ---
																							}else{
																								echo "$key.$key1.$key2.$key3.$key4.$key5.$key6: $val6 <br>";			
																							}	
																					}
																					// --- array --- 6 ---
																				}else{
																					echo "$key.$key1.$key2.$key3.$key4.$key5: $val5 <br>";			
																				}	
																		}
																		// --- array --- 5 ---
																	}else{
																		echo "$key.$key1.$key2.$key3.$key4: $val4 <br>";			
																	}	
															}
															// --- array --- 4 ---
														}else{
															echo "$key.$key1.$key2.$key3: $val3 <br>";			
														}	
												}
												// --- array --- 3 ---
											}else{
												echo "$key.$key1.$key2: $val2 <br>";			
											}	
									}
									// --- array --- 2 ---
								}else{
									echo "$key.$key1: $val1 <br>";			
								}	
						}
					}else{
						echo "$key: $val <br>";				
					}	
			}
		}
		// GET
		function SendRequestBPJS($url="",$data="",$method="GET"){
			//------------------------- Set SIgnature ----------------------------------
			global $consid;
			global $consSecret;
			global $userkey;		
			
			date_default_timezone_set('UTC');
			$tStamp = strval(time()-strtotime('1970-01-01 00:00:00'));
			$signature = hash_hmac('sha256', $consid."&".$tStamp, $consSecret, true);
			$encodedSignature = base64_encode($signature);
			$keyS=$consid.$consSecret.$tStamp;
			//------------------------- Data CURL ----------------------------------
			if(is_array($data)){
				$e_jes=json_encode($data);
			}			
			//------------------------- Debug CURL ----------------------------------
			if($this->debug){
			echo "Content-Type: Application/x-www-form-urlencoded"."<br>";
			echo "X-cons-id:".$consid."<br>";
			echo "X-signature:".$encodedSignature."<br>";
			echo "X-timestamp:".$tStamp."<br>";
			echo "user_key:".$userkey."<br>";
			echo "<pre>";
			print_r($e_jes);
			echo "</pre>";
			echo "url:".$url."<br>";
			}
			//------------------------- Start CURL ----------------------------------
			$curl = curl_init();
			//------------------------- Send Request --------------------------------
			curl_setopt_array($curl, array(
			  CURLOPT_URL => "$url",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "$method",
			  CURLOPT_POSTFIELDS =>"$e_jes",
			  CURLOPT_HTTPHEADER => array(				
				"Content-Type: Application/x-www-form-urlencoded",
				"X-cons-id:".$consid,
				"X-signature:".$encodedSignature,
				"X-timestamp:".$tStamp,
				"user_key:".$userkey
			  ),
			));
			
			$response = curl_exec($curl);
			curl_close($curl);			
			$arrRes=json_decode($response,TRUE);
			$hasil=$arrRes['response'];
			
			$encrypt_method = 'AES-256-CBC';
				
			// hash
			
			$key_hash = hex2bin(hash('sha256', $keyS));

			// iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
			$iv = substr(hex2bin(hash('sha256', $keyS)), 0, 16);

			$output = openssl_decrypt(base64_decode($hasil), $encrypt_method, $key_hash, OPENSSL_RAW_DATA, $iv);
			$hasilCompress=json_decode($this->decompress($output),TRUE);
			
			$arrRes['response']=$hasilCompress;
			//------------------------- Send Request --------------------------------
			
			if($this->debug){				
					$this->loop($arrRes);				
			}
			
			if ($response === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $arrRes;
			}
		}
		
		
		function VClaimInsertLPK($data){
			
			global $urlx;			
			$url = "https://$urlx/LPK/insert";
			$result=$this->SendRequestBPJS($url,$data,"POST");
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		
		function VClaimUpdateLPK(){
			global $urlx;			
			$url = "https://$urlx/LPK/update";
			$result=$this->SendRequestBPJS($url,$data,"PUT");
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		
		function VClaimDeleteLPK(){
			
			global $urlx;			
			$url = "https://$urlx/LPK/delete";
			$result=$this->SendRequestBPJS($url,$data,"DELETE");
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		
		function VClaimDataLPK($tgl="",$layan=""){
			global $urlx;			
			$url = "https://$urlx/LPK/TglMasuk/$tgl/JnsPelayanan/$layan";
			$result=$this->SendRequestBPJS($url);
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		//-------------------------------- Monitoring --------------------------------//
		function MonitorKunjungan($tgl="",$layan=""){			
			global $urlx;			
			$url = "https://$urlx/Monitoring/Kunjungan/Tanggal/$tgl/JnsPelayanan/$layan";
			$result=$this->SendRequestBPJS($url);
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		
		function MonitorKlaim($tgl="",$layan="",$status=""){			
			global $urlx;			
			$url = "https://$urlx/Monitoring/Klaim/Tanggal/$tgl/JnsPelayanan/$layan/Status/$status";
			$result=$this->SendRequestBPJS($url);
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		
		function MonitorHisLayananPeserta($NoKartu="",$tglMulai="",$tglAkhir=""){			
			global $urlx;			
			$url = "https://$urlx/monitoring/HistoriPelayanan/NoKartu/$NoKartu/tglMulai/$tglMulai/tglAkhir/$tglAkhir";
			$result=$this->SendRequestBPJS($url);
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		
		function MonitorKlaimJasaRaharja($tglMulai="",$tglAkhir=""){			
			global $urlx;			
			$url = "https://$urlx/monitoring/JasaRaharja/tglMulai/$tglMulai/tglAkhir/$tglAkhir";
			$result=$this->SendRequestBPJS($url);
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		//-------------------------------- Peserta --------------------------------//
		function pencarianPesertaBpjs($no_kartu){
			global $urlx;		
			$tglSEP=date("Y-m-d");
			$url = "https://$urlx/Peserta/nokartu/$no_kartu/tglSEP/$tglSEP";			
			$result=$this->SendRequestBPJS($url,"");
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}

		}

		function pencarianPesertaBpjsNik($nik){
			global $urlx;			
			$tglSEP=date("Y-m-d");
			$url = "https://$urlx/Peserta/nik/$nik/tglSEP/$tglSEP";			
			$result=$this->SendRequestBPJS($url);
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		//--------------------------------  Pembuatan Rujuk Balik --------------------------------//
		function InsertPRB(){
			
			global $urlx;			
			$url = "https://$urlx/PRB/insert";
			$result=$this->SendRequestBPJS($url,$data,"POST");
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		
		function UpdatePRB(){
			
			global $urlx;			
			$url = "https://$urlx/PRB/Update";
			$result=$this->SendRequestBPJS($url,$data,"PUT");
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		
		function HapusPRB(){
			
			global $urlx;			
			$url = "https://$urlx/PRB/Delete";
			$result=$this->SendRequestBPJS($url,$data,"DELETE");
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		//--------------------------------  Pencarian Data PRB --------------------------------//
		function NomorSRB($prb="",$nosep=""){
			
			global $urlx;			
			$url = "https://$urlx/prb/$prb/nosep/$nosep";
			$result=$this->SendRequestBPJS($url);
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
			
		}
		
		function TanggalSRB(){
			
			global $urlx;			
			$url = "https://$urlx/prb/tglMulai/$tglMulai/tglAkhir/$tglAkhir";
			$result=$this->SendRequestBPJS($url);
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		//--------------------------------  Referensi --------------------------------//
		function RefDiagnosa(){
			
			global $urlx;			
			$url = "https://$urlx/referensi/diagnosa/$diagnosa";
			$result=$this->SendRequestBPJS($url);
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		
		function RefPoli($poli=""){
			
			global $urlx;			
			$url = "https://$urlx/referensi/poli/$poli";
			$result=$this->SendRequestBPJS($url);
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		
		function RefFasKes($nmfaskes="",$jnsFaskes=""){
			
			global $urlx;			
			$url = "https://$urlx/referensi/faskes/$nmfaskes/$jnsFaskes";
			$result=$this->SendRequestBPJS($url);
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		
		function RefDokterDPJP($pelayanan="",$tglPelayanan="",$Spesialis=""){
			
			global $urlx;			
			$url = "https://$urlx/referensi/dokter/pelayanan/$pelayanan/tglPelayanan/$tglPelayanan/Spesialis/$Spesialis";
			$result=$this->SendRequestBPJS($url);
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		
		function RefPropinsi(){
			
			global $urlx;			
			$url = "https://$urlx/referensi/propinsi";
			$result=$this->SendRequestBPJS($url);
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		
		function RefKabupaten($propinsi=""){
			
			global $urlx;			
			$url = "https://$urlx/referensi/kabupaten/propinsi/$propinsi";
			$result=$this->SendRequestBPJS($url);
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		
		function RefKecamatan($kabupaten=""){
			
			global $urlx;			
			$url = "https://$urlx/referensi/kecamatan/kabupaten/$kabupaten";
			$result=$this->SendRequestBPJS($url);
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		
		function RefDiagnosaProgramPRB(){
			
			global $urlx;			
			$url = "https://$urlx/referensi/diagnosaprb";
			$result=$this->SendRequestBPJS($url);
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		
		function RefObatGenerikProgramPRB($obatprb=""){
			
			global $urlx;			
			$url = "https://$urlx/obatprb/$obatprb";
			$result=$this->SendRequestBPJS($url);
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		
		function RefProcedure($procedure=""){
			
			global $urlx;			
			$url = "https://$urlx/referensi/procedure/$procedure";
			$result=$this->SendRequestBPJS($url);
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		
		function RefKelasRawat(){
			
			global $urlx;			
			$url = "https://$urlx/referensi/kelasrawat";
			$result=$this->SendRequestBPJS($url);
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		
		function RefDokter($dokter=""){
			
			global $urlx;			
			$url = "https://$urlx/referensi/dokter/$dokter";
			$result=$this->SendRequestBPJS($url);
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		
		function RefSpesialistik(){
			
			global $urlx;			
			$url = "https://$urlx/referensi/spesialistik";
			$result=$this->SendRequestBPJS($url);
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		
		function RefRuangRawat(){
			
			global $urlx;			
			$url = "https://$urlx/referensi/ruangrawat";
			$result=$this->SendRequestBPJS($url);
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		
		function RefCaraKeluar(){
			
			global $urlx;			
			$url = "https://$urlx/referensi/carakeluar";
			$result=$this->SendRequestBPJS($url);
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		
		function RefPascaPulang(){
			
			global $urlx;			
			$url = "https://$urlx/referensi/pascapulang";
			$result=$this->SendRequestBPJS($url);
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		
		//--------------------------------  Pembuatan Rencana Kontrol/SPRI --------------------------------//
		function InsertRencanaKontrol($data=""){
			
			global $urlx;			
			$url = "https://$urlx/RencanaKontrol/insert";
			$result=$this->SendRequestBPJS($url,$data,"POST");
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		function UpdateRencanaKontrol($data=""){
			global $urlx;			
			$url = "https://$urlx/RencanaKontrol/Update";
			$result=$this->SendRequestBPJS($url,$data,"PUT");
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		function HapusRencanaKontrol($data=""){
			global $urlx;			
			$url = "https://$urlx/RencanaKontrol/Delete";
			$result=$this->SendRequestBPJS($url,$data,"DELETE");
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		function InsertSPRI($data=""){
			global $urlx;			
			$url = "https://$urlx/RencanaKontrol/InsertSPRI";
			$result=$this->SendRequestBPJS($url,$data,"POST");
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		
		function UpdateSPRI($data=""){
			global $urlx;			
			$url = "https://$urlx/RencanaKontrol/UpdateSPRI";
			$result=$this->SendRequestBPJS($url,$data,"PUT");
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		
		function CariSEPRencanaKontrol($nosep=""){
			global $urlx;			
			$url = "https://$urlx/RencanaKontrol/nosep/$nosep";
			$result=$this->SendRequestBPJS($url);
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		function CariNomorSuratKontrol($noSuratKontrol=""){
			global $urlx;			
			$url = "https://$urlx/RencanaKontrol/noSuratKontrol/$noSuratKontrol";
			$result=$this->SendRequestBPJS($url);
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		
		function DataNomorSuratKontrol($tglAwal="",$tglAkhir="",$filter=""){
			global $urlx;			
			$url = "https://$urlx/RencanaKontrol/ListRencanaKontrol/tglAwal/$tglAwal/tglAkhir/$tglAkhir/filter/$filter";
			$result=$this->SendRequestBPJS($url);
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		function ReKonDataPoli($JnsKontrol="",$nomor="",$TglRencanaKontrol=""){
			
			global $urlx;			
			$url = "https://$urlx/RencanaKontrol/ListSpesialistik/JnsKontrol/$JnsKontrol/nomor/$nomor/TglRencanaKontrol/$TglRencanaKontrol";
			$result=$this->SendRequestBPJS($url);
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		
		function ReKonDataDokter($JnsKontrol="",$KdPoli="",$TglRencanaKontrol=""){
			
			global $urlx;			
			$url = "https://$urlx/RencanaKontrol/JadwalPraktekDokter/JnsKontrol/$JnsKontrol/KdPoli/$KdPoli/TglRencanaKontrol/$TglRencanaKontrol";
			$result=$this->SendRequestBPJS($url);
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		//--------------------------------  Cari Rujukan --------------------------------//
		function RujukanBerdasarkanNomorRujukanPcare($Rujukan=""){
			
			global $urlx;			
			$url = "https://$urlx/Rujukan/$Rujukan";
			$result=$this->SendRequestBPJS($url);
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		
		function RujukanBerdasarkanNomorRujukanRS($Rujukan=""){
			global $urlx;			
			$url = "https://$urlx/Rujukan/RS/$Rujukan";
			$result=$this->SendRequestBPJS($url);
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		function RujukanBerdasarkanNomorKartuPcare($NoKartu=""){
			global $urlx;			
			$url = "https://$urlx/Rujukan/Peserta/$NoKartu";
			$result=$this->SendRequestBPJS($url);
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		
		function RujukanBerdasarkanNomorKartuRS($NoKartu=""){
			global $urlx;			
			$url = "https://$urlx/Rujukan/RS/Peserta/$NoKartu";
			$result=$this->SendRequestBPJS($url);
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		function RujukanNomorKartuMultiPcare($NoKartu=""){
			global $urlx;			
			$url = "https://$urlx/Rujukan/List/Peserta/$NoKartu";
			$result=$this->SendRequestBPJS($url);
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		function RujukanNomorKartuMultiRS($NoKartu=""){
			global $urlx;			
			$url = "https://$urlx/Rujukan/RS/List/Peserta/$NoKartu";
			$result=$this->SendRequestBPJS($url);
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		//--------------------------------  Pembuatan Rujukan --------------------------------//
		function InsertRujukan($data=""){
			global $urlx;			
			$url = "https://$urlx/Rujukan/insert";
			$result=$this->SendRequestBPJS($url,$data,"POST");
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		function UpdateRujukan($data=""){
			global $urlx;			
			$url = "https://$urlx/Rujukan/update";
			$result=$this->SendRequestBPJS($url,$data,"PUT");
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		function DeleteRujukan($data=""){
			global $urlx;			
			$url = "https://$urlx/Rujukan/delete";
			$result=$this->SendRequestBPJS($url,$data,"DELETE");
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		function InsertRujukanKhusus($data=""){
			global $urlx;			
			$url = "https://$urlx/Rujukan/Khusus/insert";
			$result=$this->SendRequestBPJS($url,$data,"POST");
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		
		function DeleteRujukanKhusus($data=""){
			global $urlx;			
			$url = "https://$urlx/Rujukan/Khusus/delete";
			$result=$this->SendRequestBPJS($url,$data,"POST");
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		function ListRujukanKhusus($Bulan="",$Tahun=""){
			global $urlx;			
			$url = "https://$urlx/Rujukan/Khusus/List/Bulan/$Bulan/Tahun/$Tahun";
			$result=$this->SendRequestBPJS($url,$data,"POST");
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		function InsertRujukanV2($data=""){
			global $urlx;			
			$url = "https://$urlx/Rujukan/2.0/insert";
			$result=$this->SendRequestBPJS($url,$data,"POST");
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		function UpdateRujukanV2($data=""){
			global $urlx;			
			$url = "https://$urlx/Rujukan/2.0/Update";
			$result=$this->SendRequestBPJS($url,$data,"PUT");
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		function ListSpesialistikRujukan($kodePPK="",$TglRujukan=""){
			global $urlx;			
			$url = "https://$urlx/Rujukan/ListSpesialistik/PPKRujukan/$kodePPK/TglRujukan/$TglRujukan";
			$result=$this->SendRequestBPJS($url);
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		function ListSarana($kodePPK=""){
			global $urlx;			
			$url = "https://$urlx/Rujukan/ListSarana/PPKRujukan/$kodePPK";
			$result=$this->SendRequestBPJS($url);
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		//--------------------------------  Pembuatan SEP --------------------------------//
		function InsertSEPV1($data=""){
			global $urlx;			
			$url = "https://$urlx/SEP/1.1/insert";
			$result=$this->SendRequestBPJS($url,$data,"POST");
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		function UpdateSEPV1(){
			global $urlx;			
			$url = "https://$urlx/SEP/1.1/Update";
			$result=$this->SendRequestBPJS($url,$data,"PUT");
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		function HapusSEPV1($data){
			global $urlx;			
			$url = "https://$urlx/SEP/Delete";
			$result=$this->SendRequestBPJS($url,$data,"DELETE");
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		
		function hapusSep($data){
			global $urlx;			
			$url = "https://$urlx/SEP/2.0/delete";
			$result=$this->SendRequestBPJS($url,$data,"DELETE");
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		//--------------------------------  Potensi Suplesi Jasa Raharja --------------------------------//
		function SuplesiJasaRaharja($NoKartu="",$tglPelayanan=""){
			global $urlx;			
			$url = "https://$urlx/sep/JasaRaharja/Suplesi/$NoKartu/tglPelayanan/$tglPelayanan";
			$result=$this->SendRequestBPJS($url);
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		function DataIndukKecelakaan($NoKartu=""){
			global $urlx;			
			$url = "https://$urlx/sep/KllInduk/List/$NoKartu";
			$result=$this->SendRequestBPJS($url);
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		//--------------------------------  Approval Penjaminan SEP --------------------------------//
		function Pengajuan($data=""){
			global $urlx;			
			$url = "https://$urlx/Sep/pengajuanSEP";
			$result=$this->SendRequestBPJS($url,$data,"POST");
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		
		function AprovalPengajuanSEP(){			
			global $urlx;			
			$url = "https://$urlx/Sep/aprovalSEP";
			$result=$this->SendRequestBPJS($url,$data,"POST");
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		//--------------------------------  Update Tgl Pulang SEP --------------------------------//
		function updateTglPlgSep($data=""){
			global $urlx;			
			$url = "https://$urlx/SEP/2.0/updtglplg";
			$result=$this->SendRequestBPJS($url,$data,"PUT");
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		function UpdateTanggalPulang($data=""){
			
			global $urlx;			
			$url = "https://$urlx/Sep/updtglplg";
			$result=$this->SendRequestBPJS($url,$data,"PUT");
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		//--------------------------------  Integrasi SEP dan Inacbg --------------------------------//
		function IntegrasiSEPInacbg(){
			global $urlx;			
			$url = "https://$urlx/sep/cbg/$NoSEP";
			$result=$this->SendRequestBPJS($url);
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		//--------------------------------  SEP Internal --------------------------------//
		function DataSEPIntern($noSEP=""){
			global $urlx;			
			$url = "https://$urlx/SEP/Internal/$noSEP";
			$result=$this->SendRequestBPJS($url);
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		function HapusSEPIntern($data=""){			
			global $urlx;			
			$url = "https://$urlx/SEP/Internal/delete";
			$result=$this->SendRequestBPJS($url,$data,"DELETE");
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		//--------------------------------  Finger Print --------------------------------//
		function GetFingerPrint($noKartu="",$TglLayanan=""){
			global $urlx;			
			$url = "https://$urlx/SEP/FingerPrint/Peserta/$noKartu/TglPelayanan/$TglLayanan";
			$result=$this->SendRequestBPJS($url);
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		function GetListFingerPrint($TglLayanan=""){
			global $urlx;			
			$url = "https://$urlx/SEP/FingerPrint/List/Peserta/TglPelayanan/$TglLayanan";
			$result=$this->SendRequestBPJS($url);
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		//--------------------------------  Finger Print --------------------------------//
		function refKelas(){
			global $urlx;			
			$tglSEP=date("Y-m-d");
			$url = "https://$urlx/referensi/kelasrawat";			
			$result=$this->SendRequestBPJS($url);
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		
		function getPoli(){
			global $url_antrean;		
			$url = "$url_antrean/ref/poli";		
			$result=$this->SendRequestBPJS($url);
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		
		function getFasilitasKesehatan($namaFaskes=""){
			
			global $urlx;			
			$url = "https://$urlx/referensi/faskes/$namaFaskes/2";		
			$result=$this->SendRequestBPJS($url);
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		function getDpjpLayan($jenis_pelayanan="",$kodeSpesialis=""){
			
			global $urlx;
			$tglPelayanan=date("Y-m-d");
			
			$url = "https://$urlx/referensi/dokter/pelayanan/$jenis_pelayanan/tglPelayanan/$tglPelayanan/Spesialis/$kodeSpesialis";		
			$result=$this->SendRequestBPJS($url);
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		function getRujukanBpjs($no_rujuk_bpjs){
			
			global $urlx;			
			$url = "https://$urlx/Rujukan/$no_rujuk_bpjs";	
			$result=$this->SendRequestBPJS($url);
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		
		function insertSep($data){
			global $urlx;			
			$url = "https://$urlx/SEP/2.0/insert";
			$result=$this->SendRequestBPJS($url,$data,"POST");
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		
		function UpdateSEP($data){
			global $urlx;			
			$url = "https://$urlx/SEP/2.0/update";
			$result=$this->SendRequestBPJS($url,$data,"PUT");
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		function CariSep($sep=""){
			global $urlx;			
			$url = "https://$urlx/SEP/$sep";
			$result=$this->SendRequestBPJS($url,$data);
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		
		
		
		
		
		
		function MonitoringSep($TglSep="",$JenisLayan=""){
			global $urlx;			
			$url = "https://$urlx/Monitoring/Kunjungan/Tanggal/$TglSep/JnsPelayanan/$JenisLayan";
			$result=$this->SendRequestBPJS($url,$data);
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		
		function getRefDokter(){
			
			global $url_antrean;
			$url = "$url_antrean/ref/dokter";		
			$result=$this->SendRequestBPJS($url);
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else {
				
				return $result;
			}
		}
		
		function getDiagnosa($kode=""){
			global $urlx;			
			$url = "https://$urlx/referensi/diagnosa/$kode";
			$result=$this->SendRequestBPJS($url);
			
			if ($result === false){
		 		return "Tidak dapat menyambung ke server"; 
			} else {				
				return $result;
			}
		}
		
	}
	
?>