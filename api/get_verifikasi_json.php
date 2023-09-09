<?php
	
	session_start();
	require_once("../_lib/function/db_login.php");
	loadlib("function","function.olah_tabel");
	loadlib("function","function.datetime");
	loadlib("class","Paging");
	
	//---------------------------------------------
	$dataSend = json_decode(file_get_contents("php://input"),TRUE);
	foreach($dataSend as $key=>$val){
		$$key=$val;
	}
	//---------------------------------------------
	
	// $sql = " SELECT k.*, d.nama_spesialisasi,b.id_dd_user,a.nama_bagian,b.input_tgl FROM mt_karyawan k left join mt_spesialisasi_dokter d on k.kode_spesialisasi=d.kode_spesialisasi left join mt_bagian a on k.kode_bagian=a.kode_bagian join dd_user b on k.no_induk=b.no_induk WHERE  tgl_verifikasi is null and k.kode_dokter>0  $sqlPlus $sqlTahun ORDER BY urutan_karyawan" ;

	$sql = " SELECT k.*, d.nama_spesialisasi,b.id_dd_user,a.nama_bagian,b.input_tgl FROM mt_karyawan k 
			LEFT JOIN mt_spesialisasi_dokter d ON k.kode_spesialisasi=d.kode_spesialisasi 
			LEFT JOIN mt_bagian a ON k.kode_bagian=a.kode_bagian 
			JOIN dd_user b ON k.no_induk=b.no_induk 
			WHERE k.tgl_verifikasi_dokter is null AND k.kode_dokter > 0  $sqlPlus $sqlTahun ORDER BY urutan_karyawan" ;
	
	//---------------------------------//
	$sql_count			="SELECT COUNT(id_mt_karyawan) AS jum FROM ($sql) AS a";
	$run_count			=$db->Execute($sql_count);
	while($tpl_count	=$run_count->fetchRow()){
		$data['count']	=$tpl_count['jum'];
	}
	
	$recperpage 		= $limit;
	$hal				=($offset/$limit)+1;
	$pagenya 			=new Paging($db, $sql, $recperpage);
	$rsPaging 			=$pagenya->ExecPage($hal);
	$NoAwal 			=($hal == "" || $hal < 1) ? 0 : ($rsPaging->_currentPage - 1) * $recperpage;
	$i 					=$pagenya->pagingVars["firstno"];
			
		while ($tampil=$rsPaging->FetchRow()) {
			$i++;
			$no_induk			= $tampil["id_mt_karyawan"];
			$kode_dokter		= $tampil["kode_dokter"];
			$nama_pegawai		= $tampil["nama_pegawai"];
			$nama_spesialisasi	= $tampil["nama_spesialisasi"];
			$tgl_masuk			= $tampil["tgl_masuk"];
			$url_sip			= $tampil["url_sip"];
			$flag_verifikasi	= $tampil["flag_verifikasi"];

			$blob_sip	=baca_tabel("tc_sip","blob_sip","WHERE kode_dokter='".$kode_dokter."'");
			if ($blob_sip!=''){
				$tampil["sip"]="<button class='btn btn-primary' onclick='lihatSip(".$kode_dokter.")'>Lihat</button>";
			} else {
				$tampil["sip"]='Belum Upload STR';
			}

            // $aksinya    =   "<a title='Lihat STR  $nama_pegawai' onclick='lihatSip($kode_dokter)'>
            //                     <i class='fa fa-file icon-lg text-primary'></i>
            //                 </a>" ;

				$tampil["detail"]			= "<button class='btn btn-primary' onclick='detailDokter(".$kode_dokter.")'>Detail</button>";
				$tampil["no"]				= $i;
                $tampil["nama_pegawai"]     = $nama_pegawai;
                $tampil["nama_spesialisasi"]= $nama_spesialisasi;
                $tampil["tgl_masuk"]        = $tgl_masuk;
                // $tampil["sip"]           = $aksinya;
				$tampil["verifikasi"]		="<button class='btn btn-primary' onclick='verifikasiPeserta(".$kode_dokter.")'>Verifikasi</button>";
				
				$data['items'][]=$tampil;
					
		}
	// //---------------------------------//
	
	// while($tampil=$rsPaging->FetchRow()){
	// 	$i++;
	// 	foreach($tampil as $key=>$val){
	// 		$$key=$val;
	// 	}
		
	// 	//----------------------------------------------------------------------------------
	// 	switch ($status_dr){
	// 		case "0":
	// 			$nm_status_dr = "Junior";
	// 			break;
	// 		case "1":
	// 			$nm_status_dr = "Senior";
	// 			break;
	// 		case "2":
	// 			$nm_status_dr = "Prof";
	// 			break;
	// 		case "3":
	// 			$nm_status_dr = "Spesialis";
	// 			break;
	// 		case "4":
	// 			$nm_status_dr = "Sub Spesialis";
	// 			break;
	// 		case "5":
	// 			$nm_status_dr = "Umum";
	// 			break;
	// 		case "6":
	// 			$nm_status_dr = "Terapis";
	// 			break;
	// 	}
		
	// 	if($flag_tenaga_medis==1){
	// 			$tenaga_medis="Full Time";
	// 		}else if($flag_tenaga_medis==2){
	// 			$tenaga_medis="Part Time";
	// 		}else{
	// 			$tenaga_medis="Dokter Tamu";
	// 		}
	// 	if($url_foto_karyawan!=""){
	// 					$url_foto_karyawan="<img src='$url_foto_karyawan' width='50' height='50'/>";
	// 				}else{
	// 					$url_foto_karyawan=	"<img src='assets/media/svg/avatars/001-boy.svg' width='50' height='50' />";
	// 				}
		// $blob_sip	=baca_tabel("tc_sip","blob_sip","WHERE kode_dokter='".$kode_dokter."'");
		// 			if ($blob_sip!=''){
		// 				$tampil["sip"]="<button class='btn btn-primary' onclick='lihatSip(".$kode_dokter.")'>Lihat</button>";
		// 			} else {
		// 				$tampil["sip"]='Belum Upload SIP';
		// 			}
	// 	$obat=baca_tabel("mt_barang","count(kode_brg)"," where id_dd_user=$id_dd_user");
	// 				$pasien=baca_tabel("mt_master_pasien","count(no_mr)"," where id_dd_user=$id_dd_user");
					
	// 				$transaksi=baca_tabel("tc_trans_pelayanan","count(kode_trans_pelayanan)"," where kode_dokter1=$kode_dokter");
					
	// 	$tampil["action_edit"]		="<a href='#' title='Edit  $nama_pegawai' onclick='ubah($kode_dokter)'>
	// 						<i class='las la-edit icon-lg text-success '></i>
	// 						</a>";
	// 				$tampil["verifikasi"]		="<button class='btn btn-primary' onclick='verifikasiPeserta(".$kode_dokter.")'>Verifikasi</button>";	
	// 	$tampil["nm_status_dr"]		=$nm_status_dr;
	// 				$tampil["foto"]				=$url_foto_karyawan;
	// 				// $tampil["url_sip"]			=$url_sip;
	// 				$tampil["jenis_dokter"]		=$fungsi_dokter;
	// 				$tampil["tenaga_medis"]		=$tenaga_medis;
	// 				$tampil["status_dokter"]	=$status_dokterX;
	// 				$tampil["nik"]				=$nik;
	// 				$tampil["tgl_lahir"]		=$tgl_lahir;
	// 				$tampil["alamat"]			=$alamat;
	// 				$tampil["obat"]				=$obat;
	// 				$tampil["pasien"]			=$pasien;
	// 				$tampil["transaksi"]		=$transaksi;
	// 				$tampil["pendidikan"]		=$pendidikan;
	// 				$tampil["input_tgl"]		=date2str($input_tgl);
	// 				$tampil["no"]				=$i;
	// 	//----------------------------------------------------------------------------------
					
	// 	$data['items'][]=$tampil;
	// }
			
	echo json_encode($data);			
?>