<?php
include "cek-token.php";

// no_regisrasi

$no_kunjungan = baca_tabel('tc_kunjungan','no_kunjungan',"where no_registrasi=$no_registrasi");
$no_kunjungan = baca_tabel('tc_kunjungan','no_kunjungan',"where no_registrasi=$no_registrasi");
$kode_dokter = baca_tabel('tc_kunjungan', 'kode_dokter',"where no_kunjungan=$no_kunjungan");
$kode_bagian = baca_tabel('tc_kunjungan', 'kode_bagian_asal',"where no_kunjungan=$no_kunjungan");
$no_induk = baca_tabel('mt_karyawan','no_induk',"where kode_dokter='$kode_dokter'");

if(!empty($no_induk)){
	$nama_user=baca_tabel("dd_user","username","WHERE no_induk=$no_induk");
}

else{
  	$nama_user = $loginInfo["nama_user"];
}
	
	//echo $nama_user;
	//Perusahaan : ddd
	$sqlPr = "SELECT * FROM dd_konfigurasi";
	$hasil=&$db->Execute($sqlPr);
	$nama_perusahaan=$hasil->fields["nama_perusahaan"];
	$telpon=$hasil->fields["telpon"];
	$alamat=$hasil->fields["alamat"];
	$fax=$hasil->fields["fax"];

	if($dokter==""){
	$dokter=0;
	}

	if(trim($bagian)==""){
	$bagian=0;
	}
	
  // Informasi Registrasi
  
  $sql_kunjungan = read_tabel("tc_kunjungan","*","WHERE no_kunjungan=$no_kunjungan ");
  $tgl_jam_masuk 	= $sql_kunjungan->fields["tgl_masuk"];
  $no_mr 			= $sql_kunjungan->fields["no_mr"];
  $dokter 			= $sql_kunjungan->fields["kode_dokter"];
  $bagian 			= $sql_kunjungan->fields["kode_bagian_tujuan"];
  $periodeAwal		= explode(" ",$tgl_jam_masuk);
  $jam_masuk		=date("H:i",strtotime($periodeAwal[1]));
	//list($tgl_masuk, $jam_masuk) = split("[ ]",$tgl_jam_masuk);
	
  // Informasi Pasien
 
  $sql_pasien=read_tabel("mt_master_pasien","*","where no_mr='$no_mr'");
  $nama_pasien=$sql_pasien->fields["nama_pasien"];
  $nama_kel_pasien=$sql_pasien->fields["nama_kel_pasien"];
  $kode_kelompok=$sql_pasien->fields["kode_kelompok"];
  $kode_perusahaan=$sql_pasien->fields["kode_perusahaan"];
  $kode_agama = $sql_pasien->fields["kode_agama"];
  $no_mr_lama = $sql_pasien->fields["no_mr_lama"];
  if (trim($kode_agama)!=""){
	$agama = baca_tabel("dc_agama","agama","WHERE id_dc_agama=$kode_agama");
  }
  $nama_dokter=baca_tabel("mt_dokter_v","nama_pegawai","where kode_dokter='$dokter'");
  $nama_bagian=baca_tabel("mt_bagian","nama_bagian","where kode_bagian='$bagian'");

	if($no_kunjungan==""){
		$no_antrian=0;
	}
	$no_antrian=baca_tabel("pl_tc_poli","no_antrian","WHERE no_kunjungan=$no_kunjungan");
	if($kode_kelompok!=3 && $kode_kelompok!=2){
		$nama_kelompok=baca_tabel("mt_nasabah","nama_kelompok","where kode_kelompok='$kode_kelompok'");
		$nasabah =  $nama_kelompok;
	}else{
		if(is_numeric($kode_perusahaan)){
		$nama_company=baca_tabel("mt_perusahaan","nama_perusahaan","where kode_perusahaan='$kode_perusahaan'");
		}
		$nasabah =  $nama_company;
	}
	$nama_hari=array("Minggu","Senin","Selasa","Rabu","Kamis","Jum'at","Sabtu");

/*cetak tracer-----------------------------------------------------------------------------------*/
$cekKunjungan=baca_tabel("tc_tracer","no_kunjungan"," where no_kunjungan=".$no_kunjungan);

if($cekKunjungan == ""){

	$result = true;

	$db->BeginTrans();

	//////////////////////////////////////////////////////////////////////

	unset($insertTcTracer);

	$insertTcTracer["no_kunjungan"]			= $no_kunjungan;
	$insertTcTracer["no_registrasi"]		= baca_tabel("tc_kunjungan","no_registrasi"," where no_kunjungan=".$no_kunjungan);
	$insertTcTracer["url_tracer"]			= $url_tracer;
	$insertTcTracer["id_dd_user"]			= $loginInfo["id_dd_user"];
	$insertTcTracer["tgl_input"]			= date("Y-m-d H:i:s");
	$insertTcTracer["status_tracer"]		= 1;
	$result = insert_tabel("tc_tracer", $insertTcTracer);

	//////////////////////////////////////////////////////////////////////

	$db->CommitTrans($result !== false);
}
/*----------------------------------------------------------------------------------------------*/
$os_agent=$HTTP_USER_AGENT;

if (strpos($os_agent,"Windows")) {
   // $spacingx="550";
    $spacingx="400";
	//$padding_linux="padding-left:20px";
	$padding_linux="padding-left:0px";
	$lef_linux="left:0px";
} else {
   $spacingx="330";
   $padding_linux="padding-left:0px";
   $lef_linux="left:0px";
}
	//$spacingx="";

$content = "<html>
<head>
<title>Cetak Antrian Pasien</title>
    <link href='/_css/main.css' rel='stylesheet' type='text/css' media='screen' />
	<link rel='stylesheet' href='/_css/print.css' type='text/css' media='print'>
	<style type='text/css' media='screen'>
		#headNamaPerusahaan {
			width:100%;
			text-align:center;
			font:bolder 18px ;
			font-family:arial;
			padding:5px
		}
		#headAlamat {
			width:100%;
			text-align:center;
			font:10px;
			font-family:arial;
		}
		@media print{
			#boxAntrianKiri
			{
				top:500px;
				position:absolute;
			}
		}
		#headTracer {
			width:100%;
			text-align:center;
			font:bolder 20px;
			font-family:arial;
			letter-spacing:5px;
			padding-top:5px
		}
		#content {
			width:90%;
			padding:3px
		}
		.fieldname {
			font:12px ;
			font-family:arial;
		}
		.isiname {
			font:12px;
			font-family:arial;                  
                        
		}
		.isinameBig {
			font:bolder 14px;
			font-family:arial;
		}
		#boxAntrianKiri {
			border:2px double black;
			position:absolute;
			left:25%;
			top:0px;
			width:150px;
			height:120px;
			text-align:center;
			margin-left:0px;
			margin-top:220px;
		}
		#boxAntrianKanan {
			border:2px double black;
			position:absolute;
			left:765px;
			top:65px;
			width:70px;
			height:50px;
			text-align:center;	
			margin-left:-105px;
		}
		#boxAntrianKiri #headAntrian, #boxAntrianKanan #headAntrian{
			background:black;
			color:white;
			font:bold;
			font-family:arial;
			height:25px;
			padding:2px;
			margin-right:75px;
			margin-left:-80px;
			font-size:19px;
		}
		#boxAntrianKiri #isiAntrian, #boxAntrianKanan #isiAntrian{
			font:bold;
			font-family:arial;
			padding:1px 5px 5px 5px
			margin-right:95px;
			margin-left:-160px;
			margin-top:15px;
		}
		td{
			padding:5px;		
		}
	</style>
</head>

<body style='overflow-y: auto'>
<div id='topLayer' class='loading'></div>
<div id='barPrint'>
				<span class='judul'><b>Cetak Antrian Pasien</b></span>
				<button class='submit01' onclick='window.close()'>Tutup</button>
				<button class='submit01' onclick='window.print()'>Cetak</button>
			</div>

	<table id='table_cetak' BORDER='0' cellspacing='0' cellpadding='0' width='$spacingx' style='$lef_linux;position:absolute;padding-top:0px;'>
		<tr>
			<td style='float:left;vertical-align:top;padding-right:20px;$padding_linux;' align='center'>
				<div id='isiUtama' style='width:100%;'>
				<div id='headTracer'>
					<b style='font-size:24px;letter-spacing: 10px;'>ANTRIAN PASIEN</b>
				</div>";
$os_agent=$HTTP_USER_AGENT;


	if (strpos($os_agent,"Windows")) {
    $spacing="letter-spacing: 1px";
} else {
   $spacing="letter-spacing: 1px";
}
	$spacing;
$content .="<hr style='width:$spacingx;border:1px solid black'/>
	<div style='content' style='padding-left:10px'>
		<table cellspacing='0' cellpadding='0' width='$spacingx' align='left' style='$spacing;' border='0'>
				<tr>
					<td width='35%' class='fieldname' style='font-size:12px;'>No Medical Record</td>
					<td style='width:1px;' style='font-size:12px;'>:&nbsp;</td>
					<td width='65%' class='isiname' style='font-size:20px;'><b>".$no_mr."</b></td>
					
				</tr>";
	if($no_mr_lama!=''){
	$content .="<tr>
					<td width='35%' class='fieldname' style='font-size:12px;'>No MR Lama</td>
					<td style='width:1px;' style='font-size:12px;'>:&nbsp;</td>
					<td width='65%' class='isiname' style='font-size:12px;'>".$no_mr_lama."</td>
				</tr>
				
				";
				}
				
	$content .="<tr>
					<td width='35%' class='fieldname' style='font-size:12px;' valign='top'>Nama Pasien</td>
					<td style='font-size:12px;' valign='top'>:&nbsp;</td>
					<td width='65%' class='isiname' style='font-size:20px;' valign='top'><b>".$nama_pasien."</b> </td>
				</tr>				
				<tr>
					<td width='35%' class='fieldname' style='font-size:12px;' valign='top'>Penjamin</td>
					<td width='1%' style='font-size:12px;' valign='top'>:&nbsp;</td>
					<td width='65%' class='isiname'  style='font-size:12px;' valign='top'><b>".$nasabah."</b></td>
				</tr>
				<tr>
					<td width='40%' class='fieldname' valign='top' style='font-size:12px;'>Nama Dokter</td>
					<td valign='top' style='font-size:12px;'>:&nbsp;</td>
					<td width='60%'class='isiname' style='font-size:18px;' valign='top'><b>".$nama_dokter."</b></td>
				</tr>
				<tr>
					<td width='35%' class='fieldname' style='font-size:12px;'>Tanggal Periksa</td>
					<td style='font-size:12px;'>:&nbsp;</td>
					<td width='65%' class='isiname' style='font-size:12px;'>".$nama_hari[date('w')].",".date2str($tgl_jam_masuk)."</td>
				</tr>
				<tr>
					<td width='35%' class='fieldname' style='font-size:12px;'>Jam Periksa</td>
					<td style='font-size:12px;'>:&nbsp;</td>
					<td width='65%' class='isiname' style='font-size:12px;'>".$jam_masuk."</td>
				</tr>";
				if($pasien!=''){
	$content .="<tr>
					<td width='35%' class='fieldname' style='font-size:12px;'>Pasien</td>
					<td style='font-size:12px;'>:&nbsp;</td>
					<td width='65%' class='isiname' style='font-size:12px;'>".$pasien."</td>
				</tr>
				
				";
				}
				if (substr($bagian,0,2)=="01" && $bagian!=AV_MCU){
				$content.="
				<tr>
					<td colspan='3' align='center'>&nbsp;</td>
					
				</tr>
				<tr>
					<td colspan='3' align='center'>
						<table style='border:1px solid black;'>
						  
							<tr>
								<td align='center' style='font-size:24px;background-color: black;color:white'>ANTRIAN</td>
							</tr>
							<tr>
								<td align='center' style='font-size:60px;'>$no_antrian</td>
							</tr>
						</table>
					</td>
					
				</tr>";
				}
$content .="</table>
			
		</div>
	</div>

			</td>
			
		</tr>
	</table>";

$content .="</body>

</html>";

$content2.="<page backleft='0mm'>
".$content."
</page>";
echo $content2;
die;
	/**/require_once('../../_contrib/html2pdf_v4.03/html2pdf.class.php');
	/*require_once('../_contrib/html2pdf_v4.03/html2pdf.class.php');*/
	//$width_in_mm = $width_in_inches * 25.4; 
	//$height_in_mm = $height_in_inches * 25.4;
    //$html2pdf = new HTML2PDF('P','cm','en', true, 'UTF-8', array(12, 14, 12, 14));
	$width_in_mm = 180; 
	$height_in_mm = 140;
	$html2pdf = new HTML2PDF('L', array($width_in_mm,$height_in_mm), 'en', true, 'UTF-8', array(0, 0, 0, 0));
    $html2pdf->WriteHTML($content2);
    $html2pdf->Output('tracer_'.$bagian.'_'.$no_antrian.'.pdf');
?>