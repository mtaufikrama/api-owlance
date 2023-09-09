<?
if (!function_exists("mapping_transaksi_online")) {
	function mapping_transaksi_online($kode_bagian='',$kode_proses='',$kode_jenis_proses='',$kode_komponen='') {
		
		$eksekusi=data_tabel("ak_dd_mapping_transaksi"," where kode_bagian='$kode_bagian' AND kode_proses='$kode_proses' AND kode_jenis_proses='$kode_jenis_proses' AND kode_komponen='$kode_komponen'");
		
		if(($eksekusi["acc_debet"]!="") AND ($eksekusi["acc_debet"]!="0") )
		{
			$hasil['tipe_tx']='D';
			$hasil['acc_no']=$eksekusi["acc_debet"];
			$hasil['kode_bagian']=$kode_bagian;
		}
		else
		{
			$hasil['tipe_tx']='K';
			$hasil['acc_no']=$eksekusi["acc_kredit"];
			$hasil['kode_bagian']=$kode_bagian;
		}
		
		

		return $hasil;
	}
}
if (!function_exists("mapping_transaksi_pdp")) {
	function mapping_transaksi_pdp($kode_proses='',$kode_jenis_proses='') {
		
		$eksekusi=data_tabel("ak_dd_mapping_transaksi"," where  kode_proses='$kode_proses' AND kode_jenis_proses='$kode_jenis_proses' ");
		
		if(($eksekusi["acc_debet"]!="") AND ($eksekusi["acc_debet"]!="0") )
		{
			$hasil['tipe_tx']='D';
			$hasil['acc_no']=$eksekusi["acc_debet"];
		}
		else
		{
			$hasil['tipe_tx']='K';
			$hasil['acc_no']=$eksekusi["acc_kredit"];
		}
		
		

		return $hasil;
	}
}
?>