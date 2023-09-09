<?
require_once("../_lib/function/db.php");
loadlib("function","function.olah_tabel");
loadlib("function","function.datetime");
//$db->debug=true;
/*
Nama		: Puji Risdianto
Tanggal		: 8/5/2009
Description : Class buat modul Registrasi
*/

if(!class_exists("registrasi")){

	class registrasi {
		var $no_mr;
		var $nama_pasien;
		var $id_mt_master_pasien;
		var $hubungan;
		var $no_urutan;
		var $kode_login;
		var $kota;
		var $nama_panggilan;
		var $nama_kel_pasien;
		var $no_ktp;
		var $pekerjaan;
		var $tgl_lhr;
		var $tempat_lahir;
		var $umur_pasien;
		var $almt_ttp_pasien;
		var $tlp_kode_area;
		var $tlp_almt_ttp;
		var $jen_kelamin;
		var $status_perkaw;
		var $suku;
		var $kode_agama;
		var $kebangsaan;
		var $alamat_lokal;
		var $nama_kel_ter;
		var $nama_almt_kel;
		var $hubungan_kel;
		var $tlp_kel;
		var $kode_pendidikan;
		var $kode_kelompok;
		var $kode_perusahaan;
		var $kd_bgn;
		var $prosedur_rs;
		var $nama_almt_kantor;
		var $jabatan;
		var $gol_darah;
		var $alergi;
		var $nama_ayah;					
		var $umur_ayah;				
		var $pekerjaan_ayah	;		
		var $nama_ibu;				
		var $umur_ibu;			
		var $pekerjaan_ibu;	
		var $no_askes;		
		var $nm_inst_askes;	
		var $tgl_ctk_kartu;	
		var $jth_kelas;	
		var $masa_mulai;	
		var $masa_selesai;		
		var $flag_member;		
		var $jam_lahir;	
		var $berat_badan;					
		var $panjang_badan;				
		var $warna_kulit;					
		var $no_gelang;					
		var $pemberi_no;					
		var $mr_ibu;						
		var $dok_penolong;					
		var $user_id;						
		var $penanggung;					
		var $kode_klas;					
		var $milik;						
		var $status_meninggal;				
		var $tgl_input;					
		var $jatah_ruang;					
		var $id_dc_kota;					
		var $id_dc_kecamatan;				
		var $id_dc_kelurahan;				
		var $no_hp;						
		var $kode_askes;					
		var $foto_pasien;					
		var $flag_bayi_lahir;				
		var $nasabah;
		var $pendidikan;
		var $sex;
		var $agama;
		var $nama_peserta;
		var $kelurahan;
		var $kecamatan;
		var $kotanya;
		var $umur;


		function pasien_view($no_mr){
			$sql_view=read_tabel("mt_master_pasien","*"," WHERE no_mr='".$no_mr."'");
			while($tampil=$sql_view->FetchRow()){
				$this->nama_pasien					=$tampil["nama_pasien"];
				$this->id_mt_master_pasien			= $tampil["id_mt_master_pasien"];
				$this->no_mr						= $tampil["no_mr"];
				$this->hubungan						= $tampil["hubungan"];
				$this->no_urutan					= $tampil["no_urutan"];
				$this->kode_login					= $tampil["kode_login"];
				$this->kota							= $tampil["kota"];
				$this->nama_panggilan				= $tampil["nama_panggilan"];
				$this->nama_kel_pasien				= $tampil["nama_kel_pasien"];
				$this->no_ktp						= $tampil["no_ktp"];
				$this->pekerjaan					= $tampil["pekerjaan"];
				$this->tgl_lhr						= $tampil["tgl_lhr"];
				$this->tempat_lahir					= $tampil["tempat_lahir"];
				$this->umur_pasien					= $tampil["umur_pasien"];
				$this->almt_ttp_pasien				= $tampil["almt_ttp_pasien"];
				$this->tlp_kode_area				= $tampil["tlp_kode_area"];
				$this->tlp_almt_ttp					= $tampil["tlp_almt_ttp"];
				$this->jen_kelamin					= $tampil["jen_kelamin"];
				$this->status_perkaw				= $tampil["status_perkaw"];
				$this->suku							= $tampil["suku"];
				$this->kode_agama					= $tampil["kode_agama"];
				$this->kebangsaan					= $tampil["kebangsaan"];
				$this->alamat_lokal					= $tampil["alamat_lokal"];
				$this->tlp_almt_lkl					= $tampil["tlp_almt_lkl"];
				$this->nama_kel_ter					= $tampil["nama_kel_ter"];
				$this->nama_almt_kel				= $tampil["nama_almt_kel"];
				$this->hubungan_kel					= $tampil["hubungan_kel"];
				$this->tlp_kel						= $tampil["tlp_kel"];
				$this->kode_pendidikan				= $tampil["kode_pendidikan"];
				$this->kode_kelompok				= $tampil["kode_kelompok"];
				$this->kode_perusahaan				= $tampil["kode_perusahaan"];
				$this->kd_bgn						= $tampil["kd_bgn"];
				$this->prosedur_rs					= $tampil["prosedur_rs"];
				$this->nama_almt_kantor				= $tampil["nama_almt_kantor"];
				$this->jabatan						= $tampil["jabatan"];
				$this->gol_darah					= $tampil["gol_darah"];
				$this->alergi						= $tampil["alergi"];
				$this->nama_ayah					= $tampil["nama_ayah"];
				$this->umur_ayah					= $tampil["umur_ayah"];
				$this->pekerjaan_ayah				= $tampil["pekerjaan_ayah"];
				$this->nama_ibu						= $tampil["nama_ibu"];
				$this->umur_ibu						= $tampil["umur_ibu"];
				$this->pekerjaan_ibu				= $tampil["pekerjaan_ibu"];
				$this->no_askes						= $tampil["no_askes"];
				$this->nm_inst_askes				= $tampil["nm_inst_askes"];
				$this->tgl_ctk_kartu				= $tampil["tgl_ctk_kartu"];
				$this->jth_kelas					= $tampil["jth_kelas"];
				$this->masa_mulai					= $tampil["masa_mulai"];
				$this->masa_selesai					= $tampil["masa_selesai"];
				$this->flag_member					= $tampil["flag_member"];
				$this->jam_lahir					= $tampil["jam_lahir"];
				$this->berat_badan					= $tampil["berat_badan"];
				$this->panjang_badan				= $tampil["panjang_badan"];
				$this->warna_kulit					= $tampil["warna_kulit"];
				$this->no_gelang					= $tampil["no_gelang"];
				$this->pemberi_no					= $tampil["pemberi_no"];
				$this->mr_ibu						= $tampil["mr_ibu"];
				$this->dok_penolong					= $tampil["dok_penolong"];
				$this->user_id						= $tampil["user_id"];
				$this->penanggung					= $tampil["penanggung"];
				$this->kode_klas					= $tampil["kode_klas"];
				$this->milik						= $tampil["milik"];
				$this->status_meninggal				= $tampil["status_meninggal"];
				$this->tgl_input					= $tampil["tgl_input"];
				$this->jatah_ruang					= $tampil["jatah_ruang"];
				$this->id_dc_kota					= $tampil["id_dc_kota"];
				$this->id_dc_kecamatan				= $tampil["id_dc_kecamatan"];
				$this->id_dc_kelurahan				= $tampil["id_dc_kelurahan"];
				$this->no_hp						= $tampil["no_hp"];
				$this->kode_askes					= $tampil["kode_askes"];
				$this->foto_pasien					= $tampil["foto_pasien"];
				$this->flag_bayi_lahir				= $tampil["flag_bayi_lahir"];
				$this->nama_peserta					= $tampil["nama_peserta"];
				$this->umur							= umur($this->tgl_lhr);

	
				if(is_numeric($this->kode_kelompok)){
					if($this->kode_kelompok=='1' || $this->kode_kelompok=='2' || $this->kode_kelompok=='4'){
						$this->nasabah=baca_tabel("mt_nasabah","nama_kelompok","where kode_kelompok=".$this->kode_kelompok);					
					}elseif($this->kode_kelompok=='3'){
							if(is_numeric($this->kode_perusahaan)){
								$this->nasabah=baca_tabel("mt_perusahaan","nama_perusahaan","where kode_perusahaan=".$this->kode_perusahaan);
							}
					}elseif($this->kode_kelompok=='5' || $this->kode_kelompok=='6' || $this->kode_kelompok=='7'){
							if(is_numeric($this->kode_askes)){
								$this->nasabah=baca_tabel("mt_askes","nama_askes","where kode_askes=".$this->kode_askes);
							}
					}
				}

				if(is_numeric($this->kode_pendidikan)){
					$this->pendidikan=baca_tabel("dc_pendidikan","pendidikan","Where id_dc_pendidikan=".$this->kode_pendidikan);
				}
				
				$this->jen_kelamin=strtoupper($this->jen_kelamin);

				if($this->jen_kelamin=="P"){
					$this->sex="P";
				}else{
					$this->sex="L";
				}	

				if(is_numeric($this->kode_agama)){
					$this->agama=baca_tabel("dc_agama","agama","where id_dc_agama=".$this->kode_agama);
				}

				if(is_numeric($this->id_dc_kelurahan)){
					$this->kelurahan=baca_tabel("dc_kelurahan","nama_kelurahan","where id_dc_kelurahan=".$this->id_dc_kelurahan);
				}

				if(is_numeric($this->id_dc_kecamatan)){
					$this->kecamatan=baca_tabel("dc_kecamatan","nama_kecamatan","where id_dc_kecamatan=".$this->id_dc_kecamatan);
				}

				if(is_numeric($this->id_dc_kota)){
					$this->kotanya=baca_tabel("dc_kota","nama_kota","where id_dc_kota=".$this->id_dc_kota);
				}

			}
		}
			function pasien_add_dewasa($mrID,$no_urutan='',$txt_nama_pasien='',$txt_nama_gelar='',$txt_nama_kel='',$txt_tempat_lahir='',$date_tanggal_lahir='',$txt_kelamin='',$txt_agama='',$txt_alamat_tetap='',$txt_telp_tetap='',$txt_kode_kelompok,$txt_perusahaan='',$txt_bagian='',$masa_mulainya='',$masa_berlakunya='',$txt_no_askes='',$txt_kode_klas='',$txt_milik='',$id_dc_kota='',$id_dc_kecamatan='',$id_dc_kelurahan='',$kode_askes='',$pekerjaan='',$kode_pendidikan='',$gol_darah='',$txt_nama_peserta=''){

				$isi_pasien["no_mr"]=$mrID;
				$isi_pasien["no_urutan"]=$no_urutan;
				$isi_pasien["nama_pasien"]=strtoupper($txt_nama_pasien)." ".$txt_nama_gelar;
				$isi_pasien["nama_kel_Pasien"]=$txt_nama_kel;
				$isi_pasien["tempat_lahir"]=$txt_tempat_lahir;
				$isi_pasien["tgl_lhr"]=$date_tanggal_lahir;
				$isi_pasien["jen_kelamin"]=$txt_kelamin;
				$isi_pasien["kode_agama"]=$txt_agama;
				$isi_pasien["almt_ttp_pasien"]=$txt_alamat_tetap;
				$isi_pasien["tlp_almt_ttp"]=$txt_telp_tetap;
				$isi_pasien["kode_kelompok"]=$txt_kode_kelompok ;
				$isi_pasien["kode_perusahaan"]=$txt_perusahaan;
				$isi_pasien["kd_bgn"]=$txt_bagian;
				$isi_pasien["masa_mulai"]=$masa_mulainya;
				$isi_pasien["masa_selesai"]=$masa_berlakunya;
				$isi_pasien["no_askes"]=$txt_no_askes;
				$isi_pasien["jth_kelas"]=$txt_kode_klas;
				$isi_pasien["milik"]=$txt_milik;
				$isi_pasien["id_dc_kota"]=$id_dc_kota;
				$isi_pasien["id_dc_kecamatan"]=$id_dc_kecamatan;
				$isi_pasien["id_dc_kelurahan"]=$id_dc_kelurahan;
				$isi_pasien["kode_askes"]=$kode_askes;
				$isi_pasien["pekerjaan"]=$pekerjaan;
				$isi_pasien["kode_pendidikan"]=$kode_pendidikan;
				$isi_pasien["gol_darah"] = $gol_darah;
				$isi_pasien["nama_peserta"] = $txt_nama_peserta;
				insert_tabel("mt_master_pasien",$isi_pasien);
			
			}

			function pasien_add_bayi($mrID,$no_urutan='',$txt_nama_pasien='',$txt_nama_gelar='',$txt_tempat_lahir='',$date_tanggal_lahir='',$txt_mr_ibu='',$txt_nama_ayah='',$txt_pekerjaan_ayah='',$txt_nama_ibu='',$jam,$menit='',$txt_bb='',$txt_pb='',$user_id='',$txt_kulit='',$txt_gelang='',$txt_pemberi='',$txt_kode_kelompok='',$txt_perusahaan='',$txt_bagian='',$txt_alamat_tetap='',$txt_telp_tetap='',$dok_penolong='',$masa_mulainya='',$masa_berlakunya='',$txt_no_askes='',$txt_kode_klas='',$txt_milik='',$txt_agama='',$id_dc_kotaX='',$id_dc_kecamatanX='',$id_dc_kelurahanX='',$txt_kelamin='',$kode_askes='',$gol_darah='',$txt_nama_peserta=''){

				$isi_pasien["no_mr"]=$mrID;
				$isi_pasien["no_urutan"]=$no_urutan;
				$isi_pasien["nama_pasien"]=strtoupper($txt_nama_pasien)." ".$txt_nama_gelar;
				$isi_pasien["tempat_lahir"]=$txt_tempat_lahir;
				$isi_pasien["tgl_lhr"]=$date_tanggal_lahir;
				$isi_pasien["mr_ibu"]=$txt_mr_ibu;

				if($txt_mr_ibu !=""){
					$txt_alamat_tetap=baca_tabel("mt_master_pasien","almt_ttp_pasien","where no_mr='".$txt_mr_ibu."'");
					$txt_nama_ibu=baca_tabel("mt_master_pasien","nama_pasien","where no_mr='".$txt_mr_ibu."'");
					$txt_telp_tetap=baca_tabel("mt_master_pasien","almt_ttp_pasien","where no_mr='".$txt_mr_ibu."'");
				}

				$isi_pasien["nama_ayah"]=$txt_nama_ayah;
				$isi_pasien["pekerjaan_ayah"]=$txt_pekerjaan_ayah;
				$isi_pasien["nama_ibu"]=$txt_nama_ibu;
				$isi_pasien["jam_lahir"]=$jam.":".$menit;
				$isi_pasien["berat_badan"]=$txt_bb;
				$isi_pasien["panjang_badan"]=$txt_pb;
				$isi_pasien["user_id"]=$user_id;
				$isi_pasien["warna_kulit"]=$txt_kulit;
				$isi_pasien["no_gelang"]=$txt_gelang;
				$isi_pasien["pemberi_no"]=$txt_pemberi;
				$isi_pasien["kode_kelompok"]=$txt_kode_kelompok;
				$isi_pasien["kode_perusahaan"]=$txt_perusahaan;
				$isi_pasien["kd_bgn"]=$txt_bagian;
				$isi_pasien["almt_ttp_pasien"]=$txt_alamat_tetap;
				$isi_pasien["tlp_almt_ttp"]=$txt_telp_tetap;
				$isi_pasien["dok_penolong"]=$dok_penolong;
				$isi_pasien["masa_mulai"]=$masa_mulainya;
				$isi_pasien["masa_selesai"]=$masa_berlakunya;
				$isi_pasien["no_askes"]=$txt_no_askes;
				$isi_pasien["jth_kelas"]=$txt_kode_klas;
				$isi_pasien["milik"]=$txt_milik;
				$isi_pasien["kode_agama"]=$txt_agama;
				$isi_pasien["id_dc_kota"]=$id_dc_kotaX;
				$isi_pasien["id_dc_kecamatan"]=$id_dc_kecamatanX;
				$isi_pasien["id_dc_kelurahan"]=$id_dc_kelurahanX;
				$isi_pasien["jen_kelamin"]=$txt_kelamin;
				$isi_pasien["kode_askes"]=$kode_askes;
				$isi_pasien["flag_bayi_lahir"]=2;
				$isi_pasien["gol_darah"] = $gol_darah;
				$isi_pasien["nama_peserta"] = $txt_nama_peserta;
				
				
				insert_tabel("mt_master_pasien",$isi_pasien);
			
			}

			function pasien_edit_dewasa($no_mr,$nama_pasien='',$nama_panggilan='',$nama_kel_pasien='',$no_ktp='',$tempat_lahir='',$txt_thn_lahir='',$bulan='',$tanggal='',$kode_kelompok='',$kode_perusahaan='',$flag_member='',$kd_bgn='',$jth_kelas='',$jen_kelamin='',$status_perkaw='',$kode_agama='',$kebangsaan='',$suku='',$kode_pendidikan='',$pekerjaan='',$jabatan='',$txt_no_askes='',$gol_darah='',$alergi='',$almt_ttp_pasien='',$tlp_almt_ttp='',$alamat_lokal='',$tlp_almt_lkl='',$nama_kel_ter='',$nama_almt_kel='',$hubungan_kel='',$nama_almt_kantor='',$txt_milik='',$tahunX='',$bulanY='',$tahunY='',$id_dc_kota='',$id_dc_kecamatan='',$id_dc_kelurahan='',$kode_askes='',$nama_peserta=''){

				$editMtMasterPasien=array();
				$editMtMasterPasien["nama_pasien"] = strtoupper($nama_pasien);
				$editMtMasterPasien["nama_panggilan"] = $nama_panggilan;
				$editMtMasterPasien["nama_kel_pasien"] = $nama_kel_pasien;
				$editMtMasterPasien["no_ktp"] = $no_ktp;
				$editMtMasterPasien["tempat_lahir"] = $tempat_lahir;
				$editMtMasterPasien["tgl_lhr"] = $txt_thn_lahir."-".$bulan."-".$tanggal;
				$editMtMasterPasien["kode_kelompok"] = $kode_kelompok;
				$editMtMasterPasien["kode_perusahaan"] = $kode_perusahaan;
				$editMtMasterPasien["flag_member"] = $flag_member;
				$editMtMasterPasien["kd_bgn"] = $kd_bgn;
				$editMtMasterPasien["jth_kelas"] = $jth_kelas;
				$editMtMasterPasien["jen_kelamin"] = $jen_kelamin;
				$editMtMasterPasien["status_perkaw"] = $status_perkaw;
				$editMtMasterPasien["kode_agama"] = $kode_agama;
				$editMtMasterPasien["kebangsaan"] = $kebangsaan;
				$editMtMasterPasien["suku"] = $suku;
				$editMtMasterPasien["kode_pendidikan"] = $kode_pendidikan;
				$editMtMasterPasien["pekerjaan"] = $pekerjaan;
				$editMtMasterPasien["jabatan"] = $jabatan;
				$editMtMasterPasien["no_askes"] = $txt_no_askes;
				$editMtMasterPasien["nm_inst_askes"] = $nm_inst_askes;
				$editMtMasterPasien["gol_darah"] = $gol_darah;
				$editMtMasterPasien["alergi"] = $alergi;
				$editMtMasterPasien["almt_ttp_pasien"] = $almt_ttp_pasien;
				$editMtMasterPasien["tlp_almt_ttp"] = $tlp_almt_ttp;
				$editMtMasterPasien["alamat_lokal"] = $alamat_lokal;
				$editMtMasterPasien["tlp_almt_lkl"] = $tlp_almt_lkl;
				$editMtMasterPasien["nama_kel_ter"] = $nama_kel_ter;
				$editMtMasterPasien["nama_almt_kel"] = $nama_almt_kel;
				$editMtMasterPasien["hubungan_kel"] = $hubungan_kel;
				$editMtMasterPasien["nama_almt_kantor"] = $nama_almt_kantor;
				$editMtMasterPasien["milik"] = $txt_milik;
				$editMtMasterPasien["masa_mulai"] = $tahunX."-".$bulanX."-".$tanggalX;
				$editMtMasterPasien["masa_selesai"] = $tanggalY."-".$bulanY."-".$tahunY;
				$editMtMasterPasien["id_dc_kota"] = $id_dc_kota;
				$editMtMasterPasien["id_dc_kecamatan"] = $id_dc_kecamatan;
				$editMtMasterPasien["id_dc_kelurahan"] = $id_dc_kelurahan;
				$editMtMasterPasien["kode_askes"] = $kode_askes;
				$editMtMasterPasien["nama_peserta"] = $nama_peserta;
				update_tabel("mt_master_pasien", $editMtMasterPasien, "WHERE no_mr='$no_mr'");
			}

			function pasien_edit_anak($no_mr,$nama_pasien='',$tempat_lahir='',$tgl_lhr='',$jen_kelamin='',$kode_agama='',$kebangsaan='',$suku='',$gol_darah='',$alergi='',$almt_ttp_pasien='',$tlp_almt_ttp='',$alamat_lokal='',$nama_ayah='',$pekerjaan_ayah='',$nama_ibu='',$tlp_almt_lkl='',$kode_kelompok='',$kode_perusahaan='',$kd_bgn='',$jam_lahir='',$berat_badan='',$panjang_badan='',$mr_ibu='',$dok_penolong='',$warna_kulit='',$no_gelang='',$pemberi_no='',$jth_kelas='',$txt_no_askes='',$txt_milik='',$tahunX='',$bulanX='',$tanggalX='',$tanggalY='',$bulanY='',$tahunY='',$id_dc_kota='',$id_dc_kecamatan='',$id_dc_kelurahan='',$kode_askes='',$nama_peserta=''){

				$editMtMasterPasien=array();
				$editMtMasterPasien["no_mr"] = $no_mr;
				$editMtMasterPasien["nama_pasien"] = strtoupper($nama_pasien);
				$editMtMasterPasien["tempat_lahir"] = $tempat_lahir;
				$editMtMasterPasien["tgl_lhr"] = $tgl_lhr;
				$editMtMasterPasien["jen_kelamin"] = $jen_kelamin;
				$editMtMasterPasien["kode_agama"] = $kode_agama;
				$editMtMasterPasien["kebangsaan"] = $kebangsaan;
				$editMtMasterPasien["suku"] = $suku;
				$editMtMasterPasien["gol_darah"] = $gol_darah;
				$editMtMasterPasien["alergi"] = $alergi;
				$editMtMasterPasien["almt_ttp_pasien"] = $almt_ttp_pasien;
				$editMtMasterPasien["tlp_almt_ttp"] = $tlp_almt_ttp;
				$editMtMasterPasien["alamat_lokal"] = $alamat_lokal;
				$editMtMasterPasien["nama_ayah"] = $nama_ayah;
				$editMtMasterPasien["pekerjaan_ayah"] = $pekerjaan_ayah;
				$editMtMasterPasien["nama_ibu"] = $nama_ibu;
				$editMtMasterPasien["tlp_almt_lkl"] = $tlp_almt_lkl;
				$editMtMasterPasien["kode_kelompok"] = $kode_kelompok;
				$editMtMasterPasien["kode_perusahaan"] = $kode_perusahaan;
				$editMtMasterPasien["kd_bgn"] = $kd_bgn;
				$editMtMasterPasien["jam_lahir"] = $jam_lahir;
				$editMtMasterPasien["berat_badan"] = $berat_badan;
				$editMtMasterPasien["panjang_badan"] = $panjang_badan;
				$editMtMasterPasien["mr_ibu"] = $mr_ibu;
				$editMtMasterPasien["dok_penolong"] = $dok_penolong;
				$editMtMasterPasien["warna_kulit"] = $warna_kulit;
				$editMtMasterPasien["no_gelang"] = $no_gelang;
				$editMtMasterPasien["pemberi_no"] = $pemberi_no;
				$editMtMasterPasien["jth_kelas"] = $jth_kelas;
				$editMtMasterPasien["no_askes"] = $txt_no_askes;
				$editMtMasterPasien["milik"] = $txt_milik;
				$editMtMasterPasien["masa_mulai"] = $tahunX."-".$bulanX."-".$tanggalX;
				$editMtMasterPasien["masa_selesai"] = $tanggalY."-".$bulanY."-".$tahunY;
				$editMtMasterPasien["id_dc_kota"] = $id_dc_kota;
				$editMtMasterPasien["id_dc_kecamatan"] = $id_dc_kecamatan;
				$editMtMasterPasien["id_dc_kelurahan"] = $id_dc_kelurahan;
				$editMtMasterPasien["kode_askes"] = $kode_askes;
				$editMtMasterPasien["nama_peserta"] = $nama_peserta;
				update_tabel("mt_master_pasien", $editMtMasterPasien, "WHERE no_mr='$no_mr'");
			
			}
			
		}
	
	}

/*Example Penggunaan*/
/*$no_mr='0001094';
$nilai=new registrasi();
$nilai->pasien_view($no_mr);
$no_mr=$nilai->no_mr;
$nama_pasien =$nilai->nama_pasien;
$kode_kelompok =$nilai->kode_kelompok;

echo $no_mr." ".$nama_pasien." ".$kode_kelompok;*/
?>