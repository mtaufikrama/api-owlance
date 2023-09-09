<?
class Coa {
	public $pola;
	public $max_level;
	public $coa_length;

	function __construct($pola) {
		$this->pola = $pola;
		$arr = str_split($pola);
		foreach ($arr as $v) if (is_numeric($v)) {
			$this->max_level += 1;
			$this->coa_length += $v;
		}
	}

	function get_parent($coa, $level) {
		// Next: kalo level=null, ngambil parent langsung dari coa itu
		$level = intval($level);
		if ($level<1 || $level>$this->max_level) return false;

		$str = "";
		$pos = 0;
		$arr = str_split(substr($this->pola, 0, ($level-1)*2+1));
		foreach ($arr as $v) if (is_numeric($v)) {
			$str .= substr($coa, $pos, $v);
			$pos += $v;
		}
		return str_pad($str, $this->coa_length, "0");
	}

	function to_rs($coa) {
		if (strlen($coa)==0) return "";

		$str = "";
		$pos = 0;
		$arr = str_split($this->pola);
		foreach ($arr as $v) {
			if (is_numeric($v)) {
				$str .= substr($coa, $pos, $v);
				$pos += $v;
			} else {
				$str .= $v;
			}
		}
		return $str;
	}

	function to_rs_custom($coa, $level=null) {
		if ($level==null || $level==$this->max_level) return $this->to_rs($coa);
		if (intval($level)<1 || intval($level)>$this->max_level) return false;
		$level = intval($level);

		$str = "";
		$pos = 0;
		$arr = str_split(substr($this->pola, 0, ($level-1)*2+1));
		foreach ($arr as $v) {
			if (is_numeric($v)) {
				$str .= substr($coa, $pos, $v);
				$pos += $v;
			} else {
				$str .= $v;
			}
		}
		return $str;
	}

	function to_rs_custom2($coa, $level=null) {
		if ($level==null || $level==$this->max_level) return $this->to_rs($coa);
		if (intval($level)<1 || intval($level)>$this->max_level) return false;
		$level = intval($level);

		$arr = str_split(str_replace(".", "", $this->pola));
		$str = $this->to_rs_custom($coa, $level);
		while ($level < $this->max_level) {
			$str .= ".".str_repeat("0", $arr[$level]);
			$level++;
		}
		return $str;
	}

	function to_sys($coa) {
		return str_replace(".", "", $coa);
	}

	function to_sys_custom($coa, $level=null) {
		if ($level==null || $level==$this->max_level) return $this->to_sys($coa);
		if (intval($level)<1 || intval($level)>$this->max_level) return false;
		$level = intval($level);

		$str = "";
		$pos = 0;
		$arr = str_split(substr($this->pola, 0, ($level-1)*2+1));
		foreach ($arr as $v) {
			if (is_numeric($v)) {
				$str .= substr($coa, $pos, $v);
				$pos += $v;
			} else {
				$pos += 1;
			}
		}
		return $str;
	}

	function to_sys_custom2($coa, $level=null) {
		if ($level==null || $level==$this->max_level) return $this->to_sys($coa);
		if (intval($level)<1 || intval($level)>$this->max_level) return false;
		return str_pad($this->to_sys_custom($coa, $level), $this->coa_length, "0");
	}
}
?>