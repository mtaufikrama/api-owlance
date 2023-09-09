<?
include "db.php";

function field_pasien($no_mr,$keterangan)
{
global $db;

$sql_pasien_f = "SELECT * FROM mt_master_pasien WHERE no_mr =$no_mr";
$res_pasien_f = &$db->Execute($sql_pasien_f);

$kode_kelompok=$res_pasien_f->fields["kode_kelompok"];
$kode_perusahaan=$res_pasien_f->fields["kode_perusahaan"];
$kode_pendidikan=$res_pasien_f->fields["kode_pendidikan"];
$kd_bgn=$res_pasien_f->fields["kd_bgn"];
$keterangan=$res_pasien_f->fields["keterangan"];
$nama_pasien=$res_pasien_f->fields["nama_pasien"];


$sql_umur_f = "SELECT year(tgl_lhr) as thn_lahir  FROM mt_master_pasien WHERE no_mr = $no_mr";
$res_umur_f = &$db->Execute($sql_umur_f);
$thn_lahir=$res_umur_f->fields["thn_lahir"];


	if ($kode_kelompok)
		{
		$sqlkelompok_f = "SELECT * FROM tabel_kelompok WHERE kode_kelompok =$kode_kelompok";
		$reskelompok_f = &$db->Execute($sqlkelompok_f);	
		$nama_kelompok=$reskelompok_f->fields["nama_kelompok"];
		};

	if($kode_perusahaan)
		{
		$sqlperusahaan_f = "SELECT * FROM mt_perusahaan WHERE kode_perusahaan=$kode_perusahaan" ;
		$resperusahaan_f = &$db->Execute($sqlperusahaan_f);
		$nama_perusahaan=$resperusahaan_f ->fields["nama_perusahaan"];
		};


	if($kode_pendidikan)
		{
		$sqlpendidikan_f = "SELECT * FROM tbl_pendidikan WHERE kode_pendidikan=$kode_pendidikan" ;
		$respendidikan_f = &$db->Execute($sqlpendidikan_f);
		$nama_pendidikan=$respendidikan_f->fields["nama_pendidikan"];
		};

	if($kd_bgn)
		{
		$sqlbagian_f = "SELECT * FROM bagian WHERE kode_bagian=$kd_bgn" ;
		$resbagian_f = &$db->Execute($sqlbagian_f);
		$nama_bagian=$resbagian_f->fields["nama_bagian"];
		};

	
  	$umur_f=date("Y") - $thn_lahir;

switch($keterangan){
		

		case "umur" :
			$nilai_f=$umur_f;
			break;

		case "pendidikan" :
			if($kode_pendidikan)
			$nilai_f=$nama_pendidikan;
			break;

		case "nasabah" :
			if($kode_kelompok)
			$nilai_f=$nama_kelompok;
			break;
		
		case "perusahaan" :
			if($kode_perusahaan)
			$nilai_f=$nama_perusahaan;
			break;

		case "bagian" :
			if($kd_bgn)
			$nilai_f=$nama_bagian;
			break;

		case $keterangan :
			if($$keterangan)
			$nilai_f=$keterangan;
			break;
}

  

return $nilai_f;
}
?>

<!-- ************************************************************************************ -->
<!--									buat menampilkan data pasien		    		  -->
<!-- ************************************************************************************ -->

<?
function data_pasien($a,$mode="1")
{
global $db;
	
$sql_pasien_f = "SELECT * FROM mt_master_pasien WHERE no_mr = '" . $a . "'";
	$res_pasien_f = &$db->Execute($sql_pasien_f );

	if ($kode_kelompok)
		{
		$sqlkelompok_f = "SELECT * FROM tabel_kelompok WHERE kode_kelompok =$kode_kelompok" ;
		$reskelompok_f = &$db->Execute($sqlkelompok_f);	
		};

		$sqlperusahaan_f = "SELECT * FROM perusahaan WHERE kode_perusahaan=$kode_perusahaan" ;
		$resperusahaan_f = &$db->Execute($sqlperusahaan_f);

if ($kode_kelompok =='3')
	{
	$tulisan1="Perusahaan";	
	$tulisan2="-";
	$tulisan3=$nama_perusahaan;
	$warna="#A7D1A7";
	}
	elseif ($kode_kelompok =='5')
	{
	$sql_bagian_f="select nama_bagian from bagian where kode_bagian=$kd_bgn";
	$res_bagian_f=&$db->Execute($sql_bagian_f);
	$tulisan1="Bagian";	
	$tulisan2=":";
	$tulisan3=$nama_bagian;
	$warna="#A7D1A7";
	}
	elseif ($kode_kelompok=='5')
	{
	$sql_bagian_f="select nama_bagian from bagian where kode_bagian=$kd_bgn";
	$res_bagian_f=&$db->Execute($sql_bagian_f);
	$tulisan1="";	
	$tulisan2="";
	$tulisan3="";
	$warna="";
	};


	list ($fulltgl, $wkt) = split ('[ ]',$tgl_lhr);
	list ($tahun, $bulan, $tanggal) = split ('[/.-]', $fulltgl);
	$tanggal_f=$tanggal."/".$bulan."/".$tahun;
  
	list ($fulltgl, $wkt) = split ('[ ]',$tgl_lhr);
	list ($tahun, $bulan, $tanggal) = split ('[/.-]', $fulltgl);
	$umur_f=date("Y") - $tahun;

#=========== jika mode=1 ======================================================================
if($mode=="1")
	{
$satu="<table width='98%' border='1' cellspacing='0' cellpadding='3' align='center' bordercolor='#009900'>
  <tr> 
    <td bgcolor='#009900'><font size='2' face='Arial, Helvetica, sans-serif'><b><font color='#FFFFFF'>&nbsp;&nbsp;Data 
      Umum Pasien</font></b></font></td>
  </tr>
  <tr> 
    <td> 
      <table width='99%' border='0' cellspacing='2' cellpadding='2' align='center'>
        <tr> 
          <td width='110'><font face='Arial, Helvetica, sans-serif' size='2'>Nama 
            Pasien</font></td>
          <td width='190' bgcolor='#A7D1A7'><FONT SIZE='2' face='Arial, Helvetica, sans-serif'><B>". 
           $Nama_Pasien."&nbsp;".$Nama_kel_Pasien."</B></FONT></td>
          <td colspan='2' bgcolor='#A7D1A7'><b><font face='Arial, Helvetica, sans-serif' size='2'>( 
            ". odbc_result($res_pasien_f, 'Nama_Panggilan')." ) </font></b></td>
          <td width='120' colspan='2' bgcolor='#FFFFE8'> 
            <div align='center'><b><font face='Arial, Helvetica, sans-serif' size='3'>M.R.&nbsp; 
              ".odbc_result($res_pasien_f,'No_Mr')."</font></b></div>
          </td>
        </tr>
        <tr> 
          <td width='110'><font face='Arial, Helvetica, sans-serif' size='2'>Alamat</font></td>
          <td colspan='5' bgcolor='#A7D1A7'><B><font face='Arial, Helvetica, sans-serif' size='2'>".ereg_replace(chr 
            (13),"<br>
            ",odbc_result($res_pasien_f,"almt_ttp_pasien"))."</font></B></td>
        </tr>
        <tr> 
          <td width='110'><font face='Arial, Helvetica, sans-serif' size='2'>Tempat/
            Tgl Lahir</font></td>
          <td colspan='3' bgcolor='#A7D1A7'><b><font size='2' face='Arial, Helvetica, sans-serif'> 
            ".odbc_result($res_pasien_f,'Tempat_lahir').", ".$tanggal_f." </font></b> 
            <div align='right'></div>
            <div align='left'></div>
          </td>
          <td width='51'><font face='Arial, Helvetica, sans-serif' size='2'>Umur 
            </font></td>
          <td bgcolor='#A7D1A7' width='69'>&nbsp;<b><font size='2' face='Arial, Helvetica, sans-serif'> 
            ".$umur_f." Thn</font></b></td>
        </tr>
        <tr> 
          <td width='110'><font size='2' face='Arial, Helvetica, sans-serif'>Nasabah</font></td>
          <td colspan='3' bgcolor='#A7D1A7'><font face='Arial, Helvetica, sans-serif' size='2'> 
            <b>". odbc_result($reskelompok_f, 'Nama_Kelompok')." ".$tulisan2." ".$tulisan3."</b></font> 
            <div align='left'></div>
          </td>
          <td width='51'> <font face='Arial, Helvetica, sans-serif' size='2'>Kelamin</font></td>
          <td width='69' bgcolor='#A7D1A7'>&nbsp;<font face='Arial, Helvetica, sans-serif' size='2'><b>". 
            odbc_result($res_pasien_f,'jen_kelamin')."</b></font></td>
        </tr>
        <tr> 
          <td width='110'><font face='Arial, Helvetica, sans-serif' size='2'>Alergi 
            </font></td>
          <td colspan='3' bgcolor='#A7D1A7'><font face='Arial, Helvetica, sans-serif' size='2'><b> 
            ". ereg_replace(chr (13),"<br>
            ",odbc_result($res_pasien_f,'alergi')) ." </b></font> </td>
          <!-- <td width='114'> 
            <div align='right'><font size='2' face='Arial, Helvetica, sans-serif'>".$tulisan1." 
              </font></div>
          </td>
          <td width='4'><font size='2' face='Arial, Helvetica, sans-serif'>".$tulisan2."</font></td>
          <td bgcolor='".$warna."'> <b><font face='Arial, Helvetica, sans-serif' size='2'> 
            </font></b> </td>
          <td bgcolor='".$warna."'>&nbsp;</td> -->
          <td width='51'><font size='2' face='Arial, Helvetica, sans-serif'>Gol. 
            Drh</font></td>
          <td bgcolor='#A7D1A7' width='69'>&nbsp;<b><font face='Arial, Helvetica, sans-serif' size='2'> 
            ". odbc_result($res_pasien_f,'gol_darah')." </font></b> </td>
        </tr>
        <!-- 

  <tr> 
    <td width='110'><font size='2' face='Arial, Helvetica, sans-serif'>Nasabah 
      </font></td>
    <td width='7'>:</td>
    <td width='144' bgcolor='#A7D1A7'>&nbsp;<font face='Arial, Helvetica, sans-serif' size='2'>
      <b>". odbc_result($reskelompok_f, 'Nama_Kelompok')."</b></font></td>
    <td width='114'> 
      <div align='right'><font size='2' face='Arial, Helvetica, sans-serif'>Golongan 
        Darah </font></div>
    </td>
    <td width='4'><font size='2' face='Arial, Helvetica, sans-serif'>:</font></td>
    <td width='56' bgcolor='#A7D1A7'> 
      <div align='center'><b><font face='Arial, Helvetica, sans-serif' size='2'> 
        ". odbc_result($res_pasien_f,'gol_darah')." </font></b></div>
    </td>
    <td width='71'><b><font face='Arial, Helvetica, sans-serif' size='2'> </font></b></td>
  </tr> -->
      </table>
</td></tr>
</table>";
	}
#=========== End of jika mode=1 ======================================================================

#=========== jika mode=2 ======================================================================

if($mode=="2")
	{
$satu="<table width='98%' border='0' cellspacing='2' cellpadding='2' align='center'>
        <tr> 
          <td width='110'><font face='Arial, Helvetica, sans-serif' size='2'>Nama 
            Pasien</font></td>
          <td width='190' bgcolor='#A7D1A7'><FONT SIZE='2' face='Arial, Helvetica, sans-serif'><B>". 
            odbc_result($res_pasien_f, 'Nama_Pasien')."&nbsp;".odbc_result($res_pasien_f, 
            'Nama_kel_Pasien')."</B></FONT></td>
			          <td colspan='2' bgcolor='#FFFFE8'> 
            <div align='center'><b><font face='Arial, Helvetica, sans-serif' size='2'>M.R.&nbsp; 
              ".odbc_result($res_pasien_f,'No_Mr')."</font></b></div>
          </td>
			          <td width='51'><font face='Arial, Helvetica, sans-serif' size='2'>Umur 
            </font></td>
          <td bgcolor='#A7D1A7' width='69'>&nbsp;<b><font size='2' face='Arial, Helvetica, sans-serif'> 
            ".$umur_f." Thn</font></b></td>

        </tr>
		        <tr> 
          <td width='110'><font size='2' face='Arial, Helvetica, sans-serif'>Nasabah</font></td>
          <td colspan='3' bgcolor='#A7D1A7'><font face='Arial, Helvetica, sans-serif' size='2'> 
            <b>". odbc_result($reskelompok_f, 'Nama_Kelompok')." ".$tulisan2." ".$tulisan3."</b></font> 
            <div align='left'></div>
          </td>
          <td width='51'> <font face='Arial, Helvetica, sans-serif' size='2'>Kelamin</font></td>
          <td width='69' bgcolor='#A7D1A7'>&nbsp;<font face='Arial, Helvetica, sans-serif' size='2'><b>". 
            odbc_result($res_pasien_f,'jen_kelamin')."</b></font></td>
        </tr>
        <tr> 
          <td width='110'><font face='Arial, Helvetica, sans-serif' size='2'>Alamat</font></td>
          <td colspan='5' bgcolor='#A7D1A7'><B><font face='Arial, Helvetica, sans-serif' size='2'>".ereg_replace(chr 
            (13),"<br>
            ",odbc_result($res_pasien_f,"almt_ttp_pasien"))."</font></B></td>
        </tr>
      </table>
";
	}
#=========== End of jika mode=2 ======================================================================


#=========== jika mode=3 ======================================================================

if($mode=="3")
	{
$satu="<table width='580' border='1' cellspacing='0' cellpadding='3' align='center' bordercolor='#009900'>
  <tr> 
    <td bgcolor='#009900'><font size='2' face='Arial, Helvetica, sans-serif'><b><font color='#FFFFFF'>&nbsp;&nbsp;Data 
      Umum Pasien</font></b></font></td>
  </tr>
  <tr> 
    <td> 
      <table width='572' border='0' cellspacing='4' cellpadding='3' align='center'>
        <tr> 
          <td width='110'><font face='Arial, Helvetica, sans-serif' size='2'>Nama 
            Pasien</font></td>
          <td width='190' bgcolor='#A7D1A7'><FONT SIZE='2' face='Arial, Helvetica, sans-serif'><B>". 
            odbc_result($res_pasien_f, 'Nama_Pasien')."&nbsp;".odbc_result($res_pasien_f, 
            'Nama_kel_Pasien')."</B></FONT></td>
          <td colspan='2' bgcolor='#A7D1A7'><b><font face='Arial, Helvetica, sans-serif' size='2'>( 
            ". odbc_result($res_pasien_f, 'Nama_Panggilan')." ) </font></b></td>
          <td width='120' colspan='2' bgcolor='#FFFFE8'> 
            <div align='center'><b><font face='Arial, Helvetica, sans-serif' size='3'>M.R.&nbsp; 
              ".odbc_result($res_pasien_f,'No_Mr')."</font></b></div>
          </td>
        </tr>
        <tr> 
          <td width='110'><font face='Arial, Helvetica, sans-serif' size='2'>Alamat</font></td>
          <td colspan='5' bgcolor='#A7D1A7'><B><font face='Arial, Helvetica, sans-serif' size='2'>".ereg_replace(chr 
            (13),"<br>
            ",odbc_result($res_pasien_f,"almt_ttp_pasien"))."</font></B></td>
        </tr>
        <tr> 
          <td width='110'><font face='Arial, Helvetica, sans-serif' size='2'>Tempat/
            Tgl Lahir</font></td>
          <td colspan='3' bgcolor='#A7D1A7'><b><font size='2' face='Arial, Helvetica, sans-serif'> 
            ".odbc_result($res_pasien_f,'Tempat_lahir').", ".$tanggal_f." </font></b> 
            <div align='right'></div>
            <div align='left'></div>
          </td>
          <td width='51'><font face='Arial, Helvetica, sans-serif' size='2'>Umur 
            </font></td>
          <td bgcolor='#A7D1A7' width='69'>&nbsp;<b><font size='2' face='Arial, Helvetica, sans-serif'> 
            ".$umur_f." Thn</font></b></td>
        </tr>
        <tr> 
          <td width='110'><font size='2' face='Arial, Helvetica, sans-serif'>Nasabah</font></td>
          <td colspan='3' bgcolor='#A7D1A7'><font face='Arial, Helvetica, sans-serif' size='2'> 
            <b>". odbc_result($reskelompok_f, 'Nama_Kelompok')." ".$tulisan2." ".$tulisan3."</b></font> 
            <div align='left'></div>
          </td>
          <td width='51'> <font face='Arial, Helvetica, sans-serif' size='2'>Kelamin</font></td>
          <td width='69' bgcolor='#A7D1A7'>&nbsp;<font face='Arial, Helvetica, sans-serif' size='2'><b>". 
            odbc_result($res_pasien_f,'jen_kelamin')."</b></font></td>
        </tr>
        <tr> 
          <td width='110'><font face='Arial, Helvetica, sans-serif' size='2'>Alergi 
            </font></td>
          <td colspan='3' bgcolor='#A7D1A7'><font face='Arial, Helvetica, sans-serif' size='2'><b> 
            ". ereg_replace(chr (13),"<br>
            ",odbc_result($res_pasien_f,'alergi')) ." </b></font> </td>
          <!-- <td width='114'> 
            <div align='right'><font size='2' face='Arial, Helvetica, sans-serif'>".$tulisan1." 
              </font></div>
          </td>
          <td width='4'><font size='2' face='Arial, Helvetica, sans-serif'>".$tulisan2."</font></td>
          <td bgcolor='".$warna."'> <b><font face='Arial, Helvetica, sans-serif' size='2'> 
            </font></b> </td>
          <td bgcolor='".$warna."'>&nbsp;</td> -->
          <td width='51'><font size='2' face='Arial, Helvetica, sans-serif'>Gol. 
            Drh</font></td>
          <td bgcolor='#A7D1A7' width='69'>&nbsp;<b><font face='Arial, Helvetica, sans-serif' size='2'> 
            ". odbc_result($res_pasien_f,'gol_darah')." </font></b> </td>
        </tr>
        <!-- 

  <tr> 
    <td width='110'><font size='2' face='Arial, Helvetica, sans-serif'>Nasabah 
      </font></td>
    <td width='7'>:</td>
    <td width='144' bgcolor='#A7D1A7'>&nbsp;<font face='Arial, Helvetica, sans-serif' size='2'>
      <b>". odbc_result($reskelompok_f, 'Nama_Kelompok')."</b></font></td>
    <td width='114'> 
      <div align='right'><font size='2' face='Arial, Helvetica, sans-serif'>Golongan 
        Darah </font></div>
    </td>
    <td width='4'><font size='2' face='Arial, Helvetica, sans-serif'>:</font></td>
    <td width='56' bgcolor='#A7D1A7'> 
      <div align='center'><b><font face='Arial, Helvetica, sans-serif' size='2'> 
        ". odbc_result($res_pasien_f,'gol_darah')." </font></b></div>
    </td>
    <td width='71'><b><font face='Arial, Helvetica, sans-serif' size='2'> </font></b></td>
  </tr> -->
      </table>
</td></tr>
</table>";
	}
#=========== End of jika mode=3 ======================================================================



return $satu;
}

/*


switch($keterangan){
        case "nama_lengkap" :
			$nilai_f=odbc_result($res_pasien_f,"nama_pasien");
			break;
		case "nama_panggilan" :
			$nilai_f=odbc_result($res_pasien_f,"nama_panggilan");
			break;
		case "nama_keluarga" :
			$nilai_f=odbc_result($res_pasien_f,"nama_kel_pasien");
			break;
		case "nama_ayah" :
			$nilai_f=odbc_result($res_pasien_f,"nama_lengkap");
			break;
		case "umur" :
			$nilai_f=$umur_f;
			break;
		case "tanggal_lahir" :
			$nilai_f=$tanggal_f;
			break;
		case "no_ktp" :
			$nilai_f=odbc_result($res_pasien_f,"no_ktp");
			break;

		case "pekerjaan" :
			$nilai_f=odbc_result($res_pasien_f,"pekerjaan");
			break;

			case "tempat_lahir" :
			$nilai_f=odbc_result($res_pasien_f,"tempat_lahir");
			break;
		case "alamat_tetap" :
			$nilai_f=odbc_result($res_pasien_f,"alamat_ttp_pasien");
			break;

		case "telepon_tetap" :
			$nilai_f=odbc_result($res_pasien_f,"Tlp_almt_ttp");
			break;
		case "status_perkawinan" :
			$nilai_f=odbc_result($res_pasien_f,"status_perkawinan");
			break;

		case "kode_pendidikan" :
			if(odbc_result($res_pasien_f,"kode_pendidikan"))
			$nilai_f=odbc_result($res_pasien_f,"kode_pendidikan");
			break;
		case "pendidikan" :
			if(odbc_result($res_pasien_f,"kode_pendidikan"))
			$nilai_f=odbc_result($respendidikan_f,"nama_pendidikan");
			break;

		case "kode_nasabah" :
			if(odbc_result($res_pasien_f,"kode_kelompok"))
			$nilai_f=odbc_result($res_pasien_f,"kode_kelompok");
			break;
		case "nasabah" :
			if(odbc_result($res_pasien_f,"kode_kelompok"))
			$nilai_f=odbc_result($reskelompok_f,"nama_kelompok");
			break;
		case "kode_perusahaan" :
			if(odbc_result($res_pasien_f,"kode_perusahaan"))
			$nilai_f=odbc_result($res_pasien_f,"kode_perusahaan");
			break;
		case "perusahaan" :
			if(odbc_result($res_pasien_f,"kode_perusahaan"))
			$nilai_f=odbc_result($resperusahaan_f,"nama_perusahaan");
			break;
		case "jenis_kelamin" :
			$nilai_f=odbc_result($res_pasien_f,"jen_kelamin");
			break;

}


*/


?>