<?php
	session_start();
	if (!defined("WWWROOT")) {
		$fname=dirname(__FILE__);
		$wwwroot=substr($fname,0,-14);
		define("WWWROOT",$wwwroot);

		// unset all unused local variables
		unset($wwwroot,$fname);
	}
	include WWWROOT."/_lib/function/db.php";
	/*------------------ Get Konfigurasi ------------------*/
	// $db->debug=true;
	$SqlGetKonf="SELECT
	ref_privy_konek.id,
	ref_privy_konek.base_url,
	ref_privy_konek.username,
	ref_privy_konek.`password`,
	ref_privy_konek.privyidown,
	ref_privy_konek.enterpriseToken,
	ref_privy_konek.channel_id
	FROM
	ref_privy_konek
	";
	$RunGetKonf=$db->Execute($SqlGetKonf);
	while($TplGetKonf=$RunGetKonf->fetchRow()){
		foreach($TplGetKonf as $key=>$val){
			$$key=$val;
		}
	}
	$bearer_token;
	
	class sign{
		
		public $xconsid;
		public $xtimestamp;
		public $xsignature;
		public $username;
		public $password;
		

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
		function SendRequest($url="",$data="",$method="GET",$imgclear="0"){
			//------------------------- Set SIgnature ----------------------------------
			global $username;
			global $password;
			global $bearer_token;
			//------------------------- Image Clear  -------------------------------
			/*
			case 1 : image daftar clear
			*/
			$body=$data;
			if($imgclear==1){
				unset($body["selfie"]);
				unset($body["identity"]);
			}else if($imgclear==2){
				unset($body["document"]);
			}
			//------------------------- Data CURL ----------------------------------
			
			if(is_array($data)){
				$e_jes=json_encode($data);
			}			
			//------------------------- Data CURL ----------------------------------
			//date_default_timezone_set('Asia/Jakarta');
			$body =json_encode($body);
			$apikey = $username;
			$apisecret = $password;
			$httpVerb = $method;
			$day=date("Y-m-d");
			$time=date("H:i:s");
			$timestamp = $day."T".$time."+0700";			
			$raw_text = str_replace(" ","",$body);			
			$body_md5 = base64_encode(md5($raw_text, true));			
			$hmac_signature = $timestamp.":".$apikey.":".$httpVerb.":".$body_md5;			
			$hmac_base64 = base64_encode(hash_hmac('sha256', $hmac_signature, $apisecret, true));			
			$auth_string = $apikey.":".$hmac_base64;			
			$encodedSignature = base64_encode($auth_string);
			if($this->debug){
				echo "<hr>Prosess Signature : <br>";
				echo "timestamp : $timestamp<br>";
				echo "raw_text : $raw_text<br>";
				echo "body_md5 : $body_md5<br>";
				echo "hmac_signature : $hmac_signature<br>";
				echo "hmac_base64 : $hmac_base64<br>";
				echo "auth_string : $auth_string<br>";
				echo "Signature : $encodedSignature<br><hr>";
			}
			
			//------------------------- Debug CURL ----------------------------------
			if($this->debug){
			echo "Content-Type: application/json"."<br>";
			echo "Authorization:Bearer ".$bearer_token."<br>";
			echo "Privy-Merchant-Key:".$Key."<br>";
			echo "Timestamp:".$timestamp."<br>";
			echo "Signature:".$encodedSignature."<br>";
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
				"Content-Type: application/json",
				"Authorization:Bearer ".$bearer_token,
				"Privy-Merchant-Key:".$Key,
				"Timestamp:".$timestamp,
				"Signature:".$encodedSignature
			  ),
			));
			
			$response = curl_exec($curl);			
			curl_close($curl);			
			$arrRes=json_decode($response,TRUE);			
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
		
		//------------------------- REGISTER --------------------------------
		function Register($data){
			global $base_url;
			$url = "$base_url/web/api/v2/register";
			/* --- get data pasien --- */
			
			/* --- get data pasien --- */
			$result=$this->SendRequest($url,$data,"POST",1);
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		
		function ReSubmit($data){
			global $base_url;
			$url = "$base_url/web/api/v2/register/resend";
			$result=$this->SendRequest($url,$data,"POST");
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		
		function CheckStatus($data){			
			global $base_url;			
			$url = "$base_url/web/api/v2/register/status";
			$result=$this->SendRequest($url,$data,"POST");
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		//------------------------- OTP --------------------------------
		function OTPRequest($data){
			global $base_url;			
			$url = "$base_url/web/api/v2/register/otp";
			$result=$this->SendRequest($url,$data,"POST");
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		
		function OTPValidation($data){
			global $base_url;			
			$url = "$base_url/web/api/v2/register/otp-validation";
			$result=$this->SendRequest($url,$data,"POST");
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		
		function OTPResend($data){
			global $base_url;			
			$url = "$base_url/web/api/v2/register/otp-resend";
			$result=$this->SendRequest($url,$data,"POST");
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		//-------------------------------- Upload Document --------------------------------//
		function DocSigning($data){
			global $base_url;			
			$url = "$base_url/web/api/v2/doc-signing";
			$result=$this->SendRequest($url,$data,"POST",2);
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		
		function DocStatus($data){
			global $base_url;			
			$url = "$base_url/web/api/v2/doc-signing/status";
			$result=$this->SendRequest($url,$data,"POST");
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		
		function BulkSignNotification($data){
			global $base_url;			
			$url = "$base_url/web/api/v2/doc-signing/notification";			
			$result=$this->SendRequest($url,$data,"POST");
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}

		}
		//-------------------------------- OAUTH --------------------------------//
		function token(){
			global $base_url;
			global $username;
			global $password;
			global $bearer_token;
			
			$data['client_id']= $username;
			$data['client_secret']= $password;
			$data['grant_type']= "client_credentials";
			$url = "$base_url/oauth2/api/v1/token";			
			$result=$this->SendRequest($url,$data,"POST");
			$bearer_token=$result['data']['access_token'];
			$_SESSION['bearer_token']=$bearer_token;
		}
		//-------------------------------- SET IMAGE SIGNATURE --------------------------------//
		function SetImagesignature($data){			
			global $base_url;			
			$url = "$base_url/web/api/v2/signature";
			$result=$this->SendRequest($url,$data,"POST");
			
			if ($result === false){ 
		 		return "Tidak dapat menyambung ke server"; 
			} else { 	
				
				return $result;
			}
		}
		
		
		
	}
	
?>