<?php
if (!function_exists("date_time")) {
	function date_time()
	{
		include_once WWWROOT . 'db_login.php';
		$data = '';

		$tgl = "select current_timestamp";
		$run = $db->Execute($tgl);
		while ($get = $run->fetchRow()) {
			$data = $get['current_timestamp'];
		}
		return $data;
	}
}

if (!function_exists("umur")) {
	function umur($a = "")
	{

		if ($a == "") {
			$umurnya = "-";
		} else {
			list($fulltgl, $wkt) = split('[ ]', $a);
			list($tahun, $bulan, $tanggal) = split('[/.-]', $fulltgl);

			$tgl_skrg = date("d");
			$bln_skrg = date("m");
			$thn_skrg = date("Y");

			if ($bln_skrg == $bulan) {
				if ($tgl_skrg < $tanggal) {
					$umurnya = $thn_skrg - $tahun - 0.1;
				} else {
					$umurnya = $thn_skrg - $tahun;
				}
			} elseif ($bln_skrg < $bulan) {
				$umurnya = $thn_skrg - $tahun - 1;
				$koma = (12 - $bulan) + $bln_skrg;
				$koma = $koma / 12;
			} else {
				$umurnya = $thn_skrg - $tahun;
				$koma = $bln_skrg - $bulan;
				$koma = $koma / 12;
			}

			if ($umurnya > 0) {
				$umurnya = number_format($umurnya, 0);
			} else {
				$umurnya = number_format($umurnya + $koma, 1);
			}

			return $umurnya;
		}
	}
}
// ----------------------- FUNCTION  -----------------------
if (!function_exists("hitungTahunLahir")) {

	function hitungTahunLahir($th_lahir, $bl_lahir, $tgl_lahir, $thn_skrg, $bln_skrg, $tgl_skrg)
	{


		if ($th_lahir <= $thn_skrg && $bl_lahir <= $bln_skrg && $tgl_lahir <= $tgl_skrg)
			return ($thn_skrg - $th_lahir);
		else {
			if ($bl_lahir > $bln_skrg && $tgl_lahir > $tgl_skrg)
				return ($thn_skrg - $th_lahir - 1);
			else {
				if ($bl_lahir > $bln_skrg)
					return ($thn_skrg - $th_lahir - 1);
				else {
					if ($bl_lahir == $bln_skrg && $tgl_lahir > $tgl_skrg)
						return ($thn_skrg - $th_lahir - 1);
					else
						return ($thn_skrg - $th_lahir);
				}
			}
		}
	}
}
if (!function_exists("hitungBulanLahir")) {

	function hitungBulanLahir($th_lahir, $bl_lahir, $tgl_lahir, $thn_skrg, $bln_skrg, $tgl_skrg)
	{
		if ($bl_lahir <= $bln_skrg && $tgl_lahir <= $tgl_skrg) {
			return $bln_skrg - $bl_lahir;
		} else {
			if ($bl_lahir <= $bln_skrg) {
				if ($tgl_lahir > $tgl_skrg) {
					if ($th_lahir < $thn_skrg) {
						if ($bl_lahir == $bln_skrg) {
							return 12 - ($bln_skrg - $bl_lahir + 1);
						} else {
							return $bln_skrg - $bl_lahir - 1;
						}
					} else {
						return $bln_skrg - $bl_lahir - 1;
					}
				}
			} else {
				if ($tgl_lahir <= $tgl_skrg)
					return 12 - ($bl_lahir - $bln_skrg);
				else return 12 - ($bl_lahir - $bln_skrg) - 1;
			}
		}
	}
}

if (!function_exists("hitungHariLahir")) {

	function hitungHariLahir($th_lahir, $bl_lahir, $tgl_lahir, $thn_skrg, $bln_skrg, $tgl_skrg)
	{

		if ($tgl_lahir <= $tgl_skrg) return $tgl_skrg - $tgl_lahir;
		else {
			switch ($bl_lahir) {
				case 1:
				case 3:
				case 5:
				case 7:
				case 8:
				case 10:
				case 12:
					return 31 - $tgl_lahir + $tgl_skrg;
					break;
				case 2:
					if ($th_lahir % 4 == 0) return 29 - $tgl_lahir + $tgl_skrg;
					else 28 - $tgl_lahir + $tgl_skrg;
					break;
				default:
					return 30 - $tgl_lahir + $tgl_skrg;
					break;
			}
		}
	}
}
