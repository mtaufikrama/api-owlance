<?php
	if (!defined("WWWROOT")) {
		$fname=dirname(__FILE__);
		$wwwroot=substr($fname,0,-14);
		define("WWWROOT",$wwwroot);

		// unset all unused local variables
		unset($wwwroot,$fname);
	}
	include WWWROOT."/_lib/function/db.php";
	include WWWROOT."/_lib/function/function.olah_tabel.php";
	/*------------------ Get Konfigurasi ------------------*/
	/*------------------ Get Konfigurasi ------------------*/
	// $db->debug=true;
	$SqlGetKonf="select url_api from ref_api_url where name_api='demo->prod'";
	$RunGetKonf=$db->Execute($SqlGetKonf);
	while($TplGetKonf=$RunGetKonf->fetchRow()){
		$urlx=$TplGetKonf['url_api'];
	}
	/*------------------ Get Konf Multi ID ------------------*/	
	
	
	class adok{		

		function __construct() {		
			
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
		function get_par($hasil=""){	
			foreach($hasil as $key=>$val){
				if(is_array($val)){
					foreach($val as $key1=>$val1){
						if(is_array($val1)){
							foreach($val1 as $key2=>$val2){
								if(is_array($val2)){
									foreach($val2 as $key3=>$val3){
										if(is_array($val3)){
											foreach($val3 as $key4=>$val4){
												if(is_array($val4)){
													foreach($val4 as $key5=>$val5){
														$GLOBALS[$key5]=$val5;
													}
												}else{
													$GLOBALS[$key4]=$val4;
												}
												
											}
										}else{
											$GLOBALS[$key3]=$val3;
										}
									}
								}else{
									$GLOBALS[$key2]=$val2;
								}
							}
						}else{
							$GLOBALS[$key1]=$val1;
						}
					}
				}else{
					$GLOBALS[$key]=$val;
				}
			}
		}
		// GET
		function SendRequestURL($url="",$data="",$method="GET"){
			//------------------------- Set SIgnature ----------------------------------	
			global $db;
			date_default_timezone_set('UTC');
			$tStamp = strval(time()-strtotime('1970-01-01 00:00:00'));
			//------------------------- Authorization ----------------------------------
					
			//------------------------- Data CURL ----------------------------------
			if(is_array($data)){
				$e_jes=json_encode($data);
			}			
			//------------------------- Debug CURL ----------------------------------
			if($this->debug){
			echo "Content-Type: Application/x-www-form-urlencoded"."<br>";
			echo "<pre>";
			print_r($e_jes);
			echo "</pre>";
			echo "url:".$url."<br>";
			}
			//------------------------- Start CURL ----------------------------------
			$curl = curl_init();
			//------------------------- Send Request --------------------------------
			$header=array(				
				"Content-Type: Application/x-www-form-urlencoded"
			  );
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
				"Content-Type: Application/x-www-form-urlencoded"
			  ),
			));
			
			$response = curl_exec($curl);
			if($this->debug){
				print_r($response);
				echo "<br>";
			}
			curl_close($curl);			
			$arrRes=json_decode($response,TRUE);
			
			
			
			//------------------------- Simpan Request --------------------------------
			if($this->debug){				
					$db->debug=true;			
			}
			$db->BeginTrans();
			$dataReq['url']		=$url;
			$dataReq['method']	=$method;
			$dataReq['user']	=$loginInfo['username'];
			$dataReq['payload']	=$e_jes;
			$dataReq['time_req']	=date("Y-m-d H:i:s");
			$dataReq['result']	=json_encode($arrRes);
			$dataReq['header']	=json_encode($header);
			insert_tabel("tc_api_post",$dataReq);
			$db->CommitTrans();
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
	
		/* ---------- Diagnosa ---------- */
		function get_daftar_dokter($data=""){
			global $urlx;			
			$url = "$urlx/api/get_verifikasi_json.php";
			$result=$this->SendRequestURL($url,$data,"GET");
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		
		function verif_data_dokter($data=""){
			global $urlx;			
			$url = "$urlx/api/verifikasi_dokter.php";
			$result=$this->SendRequestURL($url,$data,"POST");
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		
		function aktivasi_mitra_dokter($data=""){
			global $urlx;			
			$url = "$urlx/api/aktivasi_mitra.php";
			$result=$this->SendRequestURL($url,$data,"POST");
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		
		
	}
?>