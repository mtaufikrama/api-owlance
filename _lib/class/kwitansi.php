<?
 
   class Kuitansi
     { 
       var $puluh         = "PULUH ";
       var $ratus         = "RATUS ";
       
       var $ribu          = "RIBU ";
       var $juta          = "JUTA ";   
       var $milyar        = "MILYAR ";
       var $triliun       = "TRILIUN ";
       
       var $satu_a        = " SE";
       var $satu          = " SATU ";
       var $dua           = " DUA ";
       var $tiga          = " TIGA ";
       var $empat         = " EMPAT ";
       var $lima          = " LIMA ";
       var $enam          = " ENAM ";
       var $tujuh         = " TUJUH ";
       var $delapan		  = " DELAPAN ";
       var $sembilan      = " SEMBILAN ";
       
       var $sepuluh       = " SEPULUH ";
       var $sebelas       = " SEBELAS ";
       var $duabelas      = " DUA BELAS ";
       var $tigabelas     = " TIGA BELAS ";
       var $empatbelas    = " EMPAT BELAS ";
       var $limabelas     = " LIMA BELAS ";
       var $enambelas     = " ENAM BELAS ";
       var $tujuhbelas    = " TUJUH BELAS ";
       var $delapanbelas  = " DELAPAN BELAS ";
       var $sembilanbelas = " SEMBILAN BELAS ";
       
       var $value;
       var $total_part;
       var $length;
       
       function Kuitansi($value)//---------------------------------------------function kwitansi
          { 
			$this->value	  = trim($value);
		    $this->length     = strlen($value);
		    $this->total_part = ceil ($this->length/3);
	      }//------------------------------------------------------------------end function kwitansi
	   
	   function terbilang()
		  { $value=$this->value;
		    if ($this->length <= 15)
		       {
				   if($value<0) {
					$hasil = "minus ". trim($this->penyebut($value));
					} else {
						$hasil = trim($this->penyebut($value));
					}     		
					return $hasil;
			   }
			else
			   { return "Atasnya trilyun apa hayoh ?? "; }
	     
	      }//------------------------------------------------------------------end function 
       function penyebut($nilai) {
			$nilai = abs($nilai);
			$huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
			$temp = "";
			if ($nilai < 12) {
				$temp = " ". $huruf[$nilai];
			} else if ($nilai <20) {
				$temp = $this->penyebut($nilai - 10). " belas";
			} else if ($nilai < 100) {
				$temp = $this->penyebut($nilai/10)." puluh". $this->penyebut($nilai % 10);
			} else if ($nilai < 200) {
				$temp = " seratus" . $this->penyebut($nilai - 100);
			} else if ($nilai < 1000) {
				$temp = $this->penyebut($nilai/100) . " ratus" . $this->penyebut($nilai % 100);
			} else if ($nilai < 2000) {
				$temp = " seribu" . $this->penyebut($nilai - 1000);
			} else if ($nilai < 1000000) {
				$temp = $this->penyebut($nilai/1000) . " ribu" . $this->penyebut($nilai % 1000);
			} else if ($nilai < 1000000000) {
				$temp = $this->penyebut($nilai/1000000) . " juta" . $this->penyebut($nilai % 1000000);
			} else if ($nilai < 1000000000000) {
				$temp = $this->penyebut($nilai/1000000000) . " milyar" . $this->penyebut(fmod($nilai,1000000000));
			} else if ($nilai < 1000000000000000) {
				$temp = $this->penyebut($nilai/1000000000000) . " trilyun" . $this->penyebut(fmod($nilai,1000000000000));
			}     
			return ucfirst($temp);
		}
       function conversi($part_value,$part)//----------------------------------function conversi
          {
	        $part_length=strlen($part_value);
	    
			for ( $b=0 ; $b<=$part_length-1 ; $b++)
				{ $part_detail=substr($part_value,$b,1);
		          
				  if ($part_detail==0)
				     { /*  do nothing  */ }
				  else if ($b==$part_length-2 && substr($part_value,$part_length-2,1)==1)
					 { switch (substr($part_value,$part_length-1,1))
		                { 
							case 0 : $tmp_return.= $this->sepuluh ; break;    
			            case 1 : $tmp_return.= $this->sebelas ; break;
			            case 2 : $tmp_return.= $this->duabelas ; break;
						   case 3 : $tmp_return.= $this->tigabelas ; break;
						   case 4 : $tmp_return.= $this->empatbelas ; break;
						   case 5 : $tmp_return.= $this->limabelas ; break;
						   case 6 : $tmp_return.= $this->enambelas ; break;
						   case 7 : $tmp_return.= $this->tujuhbelas ; break;
						   case 8 : $tmp_return.= $this->delapanbelas ; break;
						   case 9 : $tmp_return.= $this->sembilanbelas ; break;
			             }//---------------------------------------------------end switch
		           }//-------------------------------------------------------end else if
		          else
		             { if ( $part_length<>1 && $b==$part_length-1 && substr($part_value,$part_length-2,1)==1 )
		                  { /*  do nothing  */ }
		               else
		                  { switch ($part_detail)
		                        { case 0 : /*  do nothing  */ 
								           break;
		                          case 1 : 
										   if ($part_length==1)
											   { if ($part==2){
												$tmp_return.=$this->satu_a; } 
										   else
												{ $tmp_return.=$this->satu; }}
										   else
												 { if ($b==$part_length-1)
												 { $tmp_return.=$this->satu; }
										   else
												{ $tmp_return.=$this->satu_a; }
												 }
											break;  
								  case 2 : $tmp_return.=$this->dua;
									       break;
			   					  case 3 : $tmp_return.=$this->tiga;
										   break;
								  case 4 : $tmp_return.=$this->empat;
										   break;
								  case 5 : $tmp_return.=$this->lima;
										   break;
								  case 6 : $tmp_return.=$this->enam;
										   break;
								  case 7 : $tmp_return.=$this->tujuh;
										   break;
								  case 8 : $tmp_return.=$this->delapan;
										   break;
			 					  case 9 : $tmp_return.=$this->sembilan;
										   break;
							    }//--------------------------------------------end switch
						
							switch ($b)//--------------------------------------switch $b
								{ case $part_length-1 : break;
								  case $part_length-2 : $tmp_return.=$this->puluh; break;
			   					  case $part_length-3 : $tmp_return.=$this->ratus; break;
								}//--------------------------------------------end switch $b

					     }//---------------------------------------------------end else
						 
		             }//-------------------------------------------------------end else
		   
				}//------------------------------------------------------------end for
		 
			   return $tmp_return;
		  }//------------------------------------------------------------------end function
	  
       function split_part($part,$sisa_part)//---------------------------------function split_part
          { $value=$this->value;

		    if ( $sisa_part<1)
		       { $sisa_part=3; }
	 
			if ( $part==$this->total_part )
	           { $tmp_return=substr($value,0,$sisa_part); }
	        else 
	           { $tmp_return=substr($value,($this->total_part-$part-1)*3+$sisa_part,3); }
	    
	        return $tmp_return;
	      }//------------------------------------------------------------------end function 
       
     }//-----------------------------------------------------------------------end class
     

     
     //$test=new kuitansi(trim($value));
	 //echo "Nilai &nbsp; &nbsp; &nbsp; &nbsp;: ".$test->value."<br>";
	 //echo "Length &nbsp; &nbsp; : ".$test->length."<br>";
	 //echo "Terbilang : <br>".$test->terbilang();
	 
?>
