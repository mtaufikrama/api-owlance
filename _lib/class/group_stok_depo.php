<?
if(!class_exists("group_stok_depo")){
	class group_stok_depo{
		var $db;
				function group_stok_depo($db,$kode_bagian){

				if($kode_bagian=='011801'){//poli umum
					$group_bagiannya="011801";
				}else if(($kode_bagian=='011501')||($kode_bagian=='011601')){//poli gigi
					$group_bagiannya="011001";
				}else if(($kode_bagian=='012801')||($kode_bagian=='012701')){//poli bedah
					$group_bagiannya=AV_KAMAR_BEDAH;
				}else if(($kode_bagian=='030601')||($kode_bagian=='030301')){//anggrek
					$group_bagiannya="030101";
				}else if(($kode_bagian=='030801')||($kode_bagian=='031301')||($kode_bagian=='031401')){//dahlia
					$group_bagiannya="030401";
				}else if(($kode_bagian=='013201')|| ($kode_bagian=='012901') ){//VK
					$group_bagiannya="030501";
				}else if($kode_bagian=='030701'){//VK
					$group_bagiannya="030701";
				}else{
					$group_bagiannya=$kode_bagian;
				}
				$this->hasilGroupBagian[$kode_bagian]				= $group_bagiannya;
			
		}

		function GroupBagian($kode_bagian){
				$hasil = $this->hasilGroupBagian[$kode_bagian];
				return $hasil;
		}

		
	}
}
?>