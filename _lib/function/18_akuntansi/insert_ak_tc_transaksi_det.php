<?
function insert_ak_tc_transaksi_det($id_ak_tc_transaksi,$mapping_acc,$nominalnya,$keterangan) {
	global $result;

	unset($fld);
	$fld['id_ak_tc_transaksi'] = $id_ak_tc_transaksi;
	$fld['acc_no'] = $mapping_acc['acc_no'];
	$fld['tipe_tx'] = $mapping_acc['tipe_tx'];
	$fld['nominal'] = $nominalnya;
	$fld['keterangan'] = $keterangan;

	if ($result !== false) $result = insert_tabel("ak_tc_transaksi_det", $fld);
}
?>