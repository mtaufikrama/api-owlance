<?
require_once("../_lib/function/db.php");
loadlib("function","function.olah_tabel");
loadlib("class","Barang");

function inventori($kode_brg_asli,$kode_jumlah_asli,$jumlah_obat,$pemakaian_obat){

	$obat=new Barang();
	
	if ($kode_brg_asli != $pemakaian_obat) {
		$obat->tambah_kartu_stok($kode_brg_asli,$jumlah_asli,$kode_bagian,6,"");
		$obat->tambah_depo_stok($kode_brg_asli,$jumlah_asli,$kode_bagian);
		$obat->kurang_depo_stok($pemakaian_obat,$jumlah_obat,$kode_bagian);
		$obat->kurang_kartu_stok($pemakaian_obat,$jumlah_obat,$kode_bagian,6,"");
	} else {
		if ($jumlah_asli!=$jumlah_obat) {
			$obat->tambah_kartu_stok($pemakaian_obat,$jumlah_asli,$kode_bagian,6,"");
			$obat->tambah_depo_stok($pemakaian_obat,$jumlah_asli,$kode_bagian);
			$obat->kurang_depo_stok($pemakaian_obat,$jumlah_obat,$kode_bagian);
			$obat->kurang_kartu_stok($pemakaian_obat,$jumlah_obat,$kode_bagian,6,"");
		} else {
			$obat->tambah_kartu_stok($pemakaian_obat,$jumlah_obat,$kode_bagian,6,"");
			$obat->tambah_depo_stok($pemakaian_obat,$jumlah_obat,$kode_bagian);
			$obat->kurang_depo_stok($pemakaian_obat,$jumlah_obat,$kode_bagian);
			$obat->kurang_kartu_stok($pemakaian_obat,$jumlah_obat,$kode_bagian,6,"");
		}
	}
 
}
?>