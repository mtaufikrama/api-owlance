<?
/*
################################

Author	: Suwi D. Utomo
Versi	: 1.7
Tanggal	:19/01/2010 14:40

################################
* [Create Permutation]
* 
* Fungsi ini mengenerate permutasi dari kalimat (kumpulan kata-kata), memotong kalimat menjadi kata. 
* kata-kata yang menyusun kalimat ini kemudian disusun sebagai permutasi
* namun masih menghasilkan permutasi dengan jumlah kata yang tidak sesuai dengan jumlah kata penyusun
*
* Contoh : Kalimat "Loreng Ceria Abadi" masih menghasilkan "Loreng" atau "Loreng Ceria"
*
* @param	[kata]	Kata yang akan dibuat permutasinya
* @param	[atas]	Kata yang akan menjadi awalan
*
* @return	[array];
*/

if (!function_exists("wordPerms")) {
	function wordPerms($kata,$atas='') {
		$output = array();
		$panjangHuruf = strlen($kata);
		if (is_array($kata)) {
				$potongan_kata = $kata;
		}
		else {
				$potongan_kata = explode(' ',$kata);
		}
		$potongan_atas = explode(' ',$atas);
		foreach ($potongan_kata as $potong) {
				if (!in_array($atas.$potong,$output) && !in_array($potong,$potongan_atas)) {
						$output[] = $atas.$potong;
						$output = array_merge($output,wordPerms($potongan_kata,$atas.$potong.' '));
				}
		}
		return $output;
	}
}

/*
* [Filter Permutation]
*
* fungsi ini sebagai fungsi bersih-bersih data hasil permutasi fungsi wordPerms Diatas
* dengan mengambil veriabel wordAsli sebagai pembatas panjang character sehingga diasumsikan
* nilai return array/value dari input merupakan satu kalimat dengan kata-kata penyusun yang sama dengan
* kata sebelum dipermutasikan. fungsi ini tidak bisa berdiri sendiri. 
* 
* @param	[input]				[array]		inputan kata yang sudah dipermutasi
* @param	[wordAsli]			[string]	kata yang akan dipermutasi
* @param	[jenisPencarian]	[int]		menentukan jenis pencarian global atau termasuk. 1=global else termasuk
* @return	[array] or [string];
*/

if (!function_exists("parsePerms")) {
	function parsePerms($input,$wordAsli,$jenisPencarian=""){
		$isArray = 0;
		$permutWord = "";
		if (is_array($input)){
			foreach ($input as $hasil){
				//if (strlen($hasil)<strlen($wordAsli)) continue;
				if ($isArray==1){
					$permutWord[] = $hasil;
				} else {
					
					if ($jenisPencarian=="3"){
						$permutWord	.= "nm_persero LIKE '%".$hasil."%' OR ";
					} else {
						$permutWord	.= "nm_persero LIKE '".$hasil."%' OR ";
					}
				}
			}
		} else {
			echo "Input Is Not an Array..!!";
		}
		if ($isArray!=1){
			$permutWord = substr($permutWord,0,-3);
		}
		return $permutWord;
	}
}

/*
* [Generate Clean Result]
* 
* fungsi ini merupakan fungsi yang menggabungkan dua fungsi diatas dengan satu variabel
* menghasilkan array permutasi dari sebuah kalimat inputan
*
* @param	[words]			[string]	inputan kata yang akan dipermutasi
* @param	[JenisPencarian][int]		menentukan jenis pencarian global atau termasuk 
* @return	[array]
*/

if (!function_exists("word_permutation")) {
	function word_permutation($words,$jenisPencarian){
		$words = strtoupper(strtolower($words));
		$wordPerms = parsePerms(wordPerms($words),$words,$jenisPencarian);
		return $wordPerms;
	}
}
?>