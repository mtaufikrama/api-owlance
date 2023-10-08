<?
if (!defined("SYMBOL_GREATHER_THAN")) define("SYMBOL_GREATHER_THAN",">");
if (!defined("SYMBOL_LESS_THAN")) define("SYMBOL_LESS_THAN","<");
if (!defined("SYMBOL_QUESTION_MARK")) define("SYMBOL_QUESTION_MARK","?");
if (!defined("SYMBOL_DOLLAR")) define("SYMBOL_DOLLAR","\$");
if (!defined("DIR_SEPARATOR")) define("DIR_SEPARATOR","\\");
if (!defined("HTML_BREAK")) define("HTML_BREAK","<br>\n");
if (!defined("SYMBOL_NEWLINE")) define("SYMBOL_NEWLINE","\n");
if (!defined("TAG_PHP_BEGIN")) define("TAG_PHP_BEGIN",SYMBOL_LESS_THAN.SYMBOL_QUESTION_MARK);
if (!defined("TAG_PHP_END")) define("TAG_PHP_END",SYMBOL_QUESTION_MARK.SYMBOL_GREATHER_THAN);

if (!defined("AV_LOGIN_PAGE")) define("AV_LOGIN_PAGE","/login.php");

define("USER_IP_ADDRESS",$_SERVER["REMOTE_ADDR"]);


// ------------------------------ SETUP APLIKASI ------------------------------

if (!defined("AV_KODE_NASABAH_UMUM")) define("AV_KODE_NASABAH_UMUM","1");
if (!defined("AV_KODE_NASABAH_PERUSAHAAN")) define("AV_KODE_NASABAH_PERUSAHAAN","2");
if (!defined("AV_KODE_NASABAH_BPJS")) define("AV_KODE_NASABAH_BPJS","3");
if (!defined("AV_KODE_NASABAH_KARYAWAN")) define("AV_KODE_NASABAH_KARYAWAN","4");
if (!defined("AV_KODE_NASABAH_ASKES")) define("AV_KODE_NASABAH_ASKES","5");
if (!defined("AV_KODE_NASABAH_GAKIN")) define("AV_KODE_NASABAH_GAKIN","6");
if (!defined("AV_KODE_KELAMIN_LAKI")) define("AV_KODE_KELAMIN_LAKI","1");
if (!defined("AV_KODE_KELAMIN_WANITA")) define("AV_KODE_KELAMIN_WANITA","2");


//echo "di dalam /_configs/constants.php<br>\n";
// ------------------------------ SETUP BAGIAN ------------------------------
if (!defined("AV_PENDAFTARAN")) define("AV_PENDAFTARAN","080003");
if (!defined("AV_POLI_UMUM")) define("AV_POLI_UMUM","010011");
if (!defined("AV_POLI_PSIKOLOGI")) define("AV_POLI_PSIKOLOGI","050007");
if (!defined("AV_LABORATORIUM")) define("AV_LABORATORIUM","050101");
if (!defined("AV_RADIOLOGI")) define("AV_RADIOLOGI","050201");
if (!defined("AV_EKG")) define("AV_EKG","050003");
if (!defined("AV_USG")) define("AV_USG","050005");
if (!defined("AV_EEG")) define("AV_EEG","050004");
if (!defined("AV_HYPERBARIK")) define("AV_HYPERBARIK","018101");
if (!defined("AV_FISIOTERAPI")) define("AV_FISIOTERAPI","050301");
if (!defined("AV_BAG_1"))  define("AV_BAG_1","030001");
if (!defined("AV_BAG_2"))  define("AV_BAG_2","030002");
if (!defined("AV_BAG_3"))  define("AV_BAG_3","030003");
if (!defined("AV_BAG_4"))  define("AV_BAG_4","030004");
if (!defined("AV_BAG_5"))  define("AV_BAG_5","030005");
if (!defined("AV_BAG_6"))  define("AV_BAG_6","030006");
if (!defined("AV_BAG_7"))  define("AV_BAG_7","030007");
if (!defined("AV_BAG_8"))  define("AV_BAG_8","030008");
if (!defined("AV_BAG_9"))  define("AV_BAG_9","030009");
if (!defined("AV_BAG_10")) define("AV_BAG_10","030010");
if (!defined("AV_BAG_11")) define("AV_BAG_11","030011");
if (!defined("AV_BAG_12")) define("AV_BAG_12","030012");
if (!defined("AV_BAG_13")) define("AV_BAG_13","030013");
if (!defined("AV_BAG_14")) define("AV_BAG_14","030014");
if (!defined("AV_BAG_15")) define("AV_BAG_15","030015");
if (!defined("AV_UNITENTRY")) define("AV_UNITENTRY","030002");
//if (!defined("AV_HEMODIALISA")) define("AV_HEMODIALISA","050401");
if (!defined("AV_GUDANG")) define("AV_GUDANG","060201");
if (!defined("AV_GUDANG_NM")) define("AV_GUDANG_NM","070201");
if (!defined("AV_FARMASI")) define("AV_FARMASI","060101");
if (!defined("AV_FARMASIRJ")) define("AV_FARMASIRJ","060001");
if (!defined("AV_FARMASIRI")) define("AV_FARMASIRI","060001");
if (!defined("AV_IGD")) define("AV_IGD","020101");
if (!defined("AV_MCU")) define("AV_MCU","010901");
if (!defined("AV_ODC")) define("AV_ODC","013201");
//if (!defined("AV_ODC_VK")) define("AV_ODC_VK","013201");
if (!defined("AV_ODC_VK")) define("AV_ODC_VK","013301");
//if (!defined("AV_VK")) define("AV_VK","030501");
if (!defined("AV_VK")) define("AV_VK","030701");
//if (!defined("AV_ICU")) define("AV_ICU","031001");
if (!defined("AV_ICU")) define("AV_ICU","030801");
if (!defined("AV_PICU")) define("AV_PICU","031101");
if (!defined("AV_NICU")) define("AV_NICU","031301");
if (!defined("AV_BERSALIN")) define("AV_BERSALIN","030701");
if (!defined("AV_BAYI")) define("AV_BAYI","030801");
if (!defined("AV_HCU")) define("AV_HCU","030901");
if (!defined("AV_KAMAR_BEDAH")) define("AV_KAMAR_BEDAH","031001");
if (!defined("AV_POLI_ANAK")) define("AV_POLI_ANAK","010101");
if (!defined("AV_ENDOSCOPY")) define("AV_ENDOSCOPY","016101");
if (!defined("AV_PM_LAIN")) define("AV_PM_LAIN","017101");
if (!defined("AV_HOMECARE")) define("AV_HOMECARE","015101");
if (!defined("AV_HEMODIALISA")) define("AV_HEMODIALISA","014101");
// if (!defined("AV_POLI_GIGIUMUM")) define("AV_POLI_GIGIUMUM","010004");
// if (!defined("AV_POLI_GIGISPESIALIS")) define("AV_POLI_GIGISPESIALIS","010004");
if (!defined("AV_PM_REHAB_MEDIK")) define("AV_PM_REHAB_MEDIK","050301");
if (!defined("AV_REHAB_MEDIK")) define("AV_REHAB_MEDIK","012801");
if (!defined("AV_SPESIALIS_THT")) define("AV_SPESIALIS_THT","010003");
if (!defined("AV_JANTUNG_DAN_PEMBULUH_DARAH")) define("AV_JANTUNG_DAN_PEMBULUH_DARAH","010401");

/*---------------------------------------------------------------------------*/
if (!defined("AV_IBU_DAN_ANAK")) define("AV_IBU_DAN_ANAK","010004");
if (!defined("AV_GIGI_UMUM")) define("AV_GIGI_UMUM","010001");
if (!defined("AV_GIGI_SPESIALIS_ANAK")) define("AV_GIGI_SPESIALIS_ANAK","010001");
if (!defined("AV_GIGI_SPESIALIS")) define("AV_GIGI_SPESIALIS","010006");
if (!defined("AV_SPESIALIS_MATA")) define("AV_SPESIALIS_MATA","010014");
if (!defined("AV_GIGI_UMUM_KARYAWAN")) define("AV_GIGI_UMUM_KARYAWAN","011101");
if (!defined("AV_KECANTIKAN")) define("AV_KECANTIKAN","010012");
if (!defined("AV_REKAM_MEDIS")) define("AV_REKAM_MEDIS","20");
// ------------------------------ SETUP MCU --------------------------------

if (!defined("AV_PAKET")) define("AV_PAKET","14");
if (!defined("AV_DAFTAR_MCU")) define("AV_DAFTAR_MCU","1");
if (!defined("AV_DAFTAR_SELESAI_MCU")) define("AV_DAFTAR_SELESAI_MCU","2");
if (!defined("AV_ANAMNESA_MCU")) define("AV_ANAMNESA_MCU","1");
if (!defined("AV_PEMERIKSAANFISIK_MCU")) define("AV_PEMERIKSAANFISIK_MCU","2");
if (!defined("AV_KESIMPULAN_MCU")) define("AV_KESIMPULAN_MCU","3");
// ------------------------------ SETUP IGD --------------------------------
if (!defined("AV_FLAGDOKTER")) define("AV_FLAGDOKTER","2");
if (!defined("AV_FLAGPERAWAT")) define("AV_FLAGPERAWAT","1");
if (!defined("AV_IGDPOTONG")) define("AV_IGDPOTONG","02");

// ------------------------------ SETUP LEVEL TARIF TINDAKAN ------------------------------
if (!defined("AV_LEVEL1")) define("AV_LEVEL1","1");
if (!defined("AV_LEVEL2")) define("AV_LEVEL2","2");
if (!defined("AV_LEVEL3")) define("AV_LEVEL3","3");
if (!defined("AV_LEVEL4")) define("AV_LEVEL4","4");
if (!defined("AV_LEVEL5")) define("AV_LEVEL5","5");
// ------------------------------ SETUP TINDAKAN ------------------------------
if (!defined("AV_STATUS_TINDAKAN")) define("AV_STATUS_TINDAKAN","0");
if (!defined("AV_STATUS_TINDAKAN1")) define("AV_STATUS_TINDAKAN1","1");
if (!defined("AV_STATUS_SIAP_BILLING")) define("AV_STATUS_SIAP_BILLING","2");
if (!defined("AV_STATUS_BAYAR")) define("AV_STATUS_BAYAR","3");
// ------------------------------ SETUP KARYAWAN ------------------------------
if (!defined("AV_PERAWAT")) define("AV_PERAWAT","1");
if (!defined("AV_DOKTER")) define("AV_DOKTER","0");
// ------------------------------ SETUP KODE PROVIT MARGIN ------------------------------
if (!defined("AV_PROVIT_RI")) define("AV_PROVIT_RI","1000");
if (!defined("AV_PROVIT_RJ")) define("AV_PROVIT_RJ","2000");
if (!defined("AV_PROVIT_PEMBELIANBEBAS")) define("AV_PROVIT_PEMBELIANBEBAS","4000");
if (!defined("AV_RESEPLUAR")) define("AV_RESEPLUAR","3000");
if (!defined("AV_RESEPKARYAWAN")) define("AV_RESEPKARYAWAN","5000");
// ------------------------------ SETUP KODE KLAS ------------------------------
if (!defined("AV_RAWATJALAN")) define("AV_RAWATJALAN","16");
if (!defined("AV_RAWATJALAN_IGD")) define("AV_RAWATJALAN_IGD","17");
// ------------------------------ SETUP VALIDASI ------------------------------
if (!defined("AV_VALIDASIPOLI")) define("AV_VALIDASIPOLI","010000");
if (!defined("AV_VALIDASIIGD")) define("AV_VALIDASIIGD","0200");
if (!defined("AV_VALIDASIRI")) define("AV_VALIDASIRI","030000");
if (!defined("AV_VALIDASIPM")) define("AV_VALIDASIPM","050000");
if (!defined("AV_VALIDASIFARMASI")) define("AV_VALIDASIFARMASI","060000");
// ------------------------------ CETAK KARTU ------------------------------
if (!defined("AV_CETAK_KARTU")) define("AV_CETAK_KARTU","15"); //PUNK-17/10/2012-13:57:13 lihat mt_jenis_tindakan
if (!defined("AV_BAGIAN_REGISTRASI")) define("AV_BAGIAN_REGISTRASI","080002"); //PUNK-17/10/2012-13:57:13 lihat mt_bagian
if (!defined("AV_BAGIAN_FISIOTERAPI")) define("AV_BAGIAN_FISIOTERAPI","050301"); 
if (!defined("AV_BAGIAN_MCU")) define("AV_BAGIAN_MCU","010901"); 
// ------------------------------ PRODUKSI OBAT ------------------------------
if (!defined("AV_SUPPLIER_LOKAL")) define("AV_SUPPLIER_LOKAL","10101"); //<----UBAH untuk disesuaikan dengan tambah baru supplier dengan data RS itu sendiri
// ------------------------------ nasabah dapet diskon farmasi (kode_kelompok -> mt_nasabah) ------------------------------
if (!defined("AV_DISC_FAR")) define("AV_DISC_FAR","4,7,8,9,11,12,13,14,15"); 
// ------------------------------ SETUP PENUNJANG MEDIS --------------------------------
if (!defined("AV_STATUSISITINDAHAKAN")) define("AV_STATUSISITINDAHAKAN","0");
if (!defined("AV_STATUSANTRIAN")) define("AV_STATUSANTRIAN","1");
if (!defined("AV_STATUSISIHASIL")) define("AV_STATUSISIHASIL","2");
if (!defined("AV_HARGA_CD")) define("AV_HARGA_CD","25000");
// ------------------------------ SETUP LOGIN TENAGA MEDIS --------------------------------
if (!defined("AV_PERAWAT")) define("AV_PERAWAT","1");
if (!defined("AV_BIDAN")) define("AV_BIDAN","2");
if (!defined("AV_USERADMIN")) define("AV_USERADMIN","1");
// ------------------------------ SETUP PEMBAYARAN --------------------------------
if (!defined("AV_TINDAKAN")) define("AV_TINDAKAN","1");
if (!defined("AV_TINDAKANSELESAI")) define("AV_TINDAKANSELESAI","2");
if (!defined("AV_TINDAKANSELESAIKASIR")) define("AV_TINDAKANSELESAIKASIR","3");
// ------------------------------ SETUP REGISTRASI --------------------------------
if (!defined("AV_STATUSBATAL")) define("AV_STATUSBATAL","1");

// ------------------------------ SETUP MODUL ------------------------------
if (!defined("AV_MODUL_REGISTRASI")) define("AV_MODUL_REGISTRASI","2");
if (!defined("AV_MODUL_IGD")) define("AV_MODUL_IGD","4");
if (!defined("AV_MODUL_POLIUMUM")) define("AV_MODUL_POLIUMUM","43");
if (!defined("AV_MODUL_POLI")) define("AV_MODUL_POLI","3");
// ------------------------------ SETUP BEDAH ------------------------------
if (!defined("AV_OPERATOR1")) define("AV_OPERATOR1","100");
if (!defined("AV_OPERATOR2")) define("AV_OPERATOR2","30");
if (!defined("AV_OPERATOR3")) define("AV_OPERATOR3","25");
if (!defined("AV_OPERATOR4")) define("AV_OPERATOR4","20");
if (!defined("AV_ANESTESI1")) define("AV_ANESTESI1","100");
if (!defined("AV_ANESTESI2")) define("AV_ANESTESI2","40");
// ---------------------------SETUP KENAIKAN BEDAH --------------------
if (!defined("AV_CITO")) define("AV_CITO","125");//Kenaikan 25 %(100+25)
if (!defined("AV_LAROSKOPI")) define("AV_LAROSKOPI","130");// Kenaikan 35 %(100+35)
// ---------------------------SETUP KEUANGAN --------------------
if (!defined("AV_PENDAPATAN_BILL_DR_FT")) define("AV_PENDAPATAN_BILL_DR_FT","80");
if (!defined("AV_PENDAPATAN_RS_FT")) define("AV_PENDAPATAN_RS_FT","20");
if (!defined("AV_PENDAPATAN_BILL_DR_PT")) define("AV_PENDAPATAN_BILL_DR_PT","85");
if (!defined("AV_PENDAPATAN_RS_PT")) define("AV_PENDAPATAN_RS_PT","15");
// ---------------------------SETUP HCU --------------------
if (!defined("AV_HCU")) define("AV_HCU","030901");
// ---------------------------SETUP PROMO --------------------
if (!defined("AV_PROMO_BCA")) define("AV_PROMO_BCA","200000");
// ---------------------------SETUP KODE BCA --------------------
if (!defined("AV_BANK_BCA")) define("AV_BANK_BCA","3");
if (!defined("AV_BANK_BCA_RJ")) define("AV_BANK_BCA_RJ","5");
if (!defined("AV_BANK_BCA_RI")) define("AV_BANK_BCA_RI","10");
if (!defined("AV_BAGPROMO_BCA_RI")) define("AV_BAGPROMO_BCA_RI","03");
if (!defined("AV_BANK_BCA_MCU")) define("AV_BANK_BCA_MCU","15");
if (!defined("AV_BANK_BCA_PAKET_MCU1")) define("AV_BANK_BCA_PAKET_MCU1","10914023");
if (!defined("AV_BANK_BCA_PAKET_MCU2")) define("AV_BANK_BCA_PAKET_MCU2","10929000");
if (!defined("AV_BANK_BCA_PAKET_MCU3")) define("AV_BANK_BCA_PAKET_MCU3","10930000");
// ---------------------------SETUP CATH LAB --------------------
if (!defined("AV_BAGCATHLAB")) define("AV_BAGCATHLAB","050601");
if (!defined("AV_HD")) define("AV_HD","014101");

// ---------------------------SETUP PAIN --------------------
if (!defined("AV_PAINKLINIK")) define("AV_PAINKLINIK","015001");
//----------------------------TARIF DOKTER--------------------
if (!defined("AV_BIAYA_ANASTESI")) define("AV_BIAYA_ANASTESI","700000");
if (!defined("PERSEN_OP2_CATCH_LAB")) define("PERSEN_OP2_CATCH_LAB","20");
//----------------------------KODE DOKTER--------------------
if (!defined("AV_DOKTER_NANANG")) define("AV_DOKTER_NANANG","215");
//----------------------------AV LAB BARU--------------------
if (!defined("AV_LAB")) define("AV_LAB","050001");
//----------------------------AV PERUSAHAAN BPJS--------------------
if (!defined("AV_PERUSAHAAN_BPJS")) define("AV_PERUSAHAAN_BPJS","371");
//----------------------------AV PERUSAHAAN BPJS--------------------
if (!defined("AV_A2_INPUT_KHUSUS")) define("AV_A2_INPUT_KHUSUS","1,3");

if (!defined("AV_DEFAULT_LAB_L")) define("AV_DEFAULT_LAB_L","501010102, 501010405, 501010801, 501010802, 501012101, 501011301, 501011302, 501011210,501012301,501012302,501012303,501012304,501012305,501012306,501012307,501011323");

if (!defined("AV_DEFAULT_LAB_P")) define("AV_DEFAULT_LAB_P","501010102, 501010405, 501010801, 501010802, 501012101, 501011301, 501011302, 501011210, 501011912,501012301,501012302,501012303,501012304,501012305,501012306,501012307,501011323");
//--------------------KA BALAI BESAR BNN------------------------------
if (!defined("AV_KA_BNN")) define("AV_KA_BNN","Mohammad Ali Azhar, S.H.,M.Si");
//--------------------AV_PROGRAM------------------------------
if (!defined("AV_PROGRAM")) define("AV_PROGRAM","030000");
//--------------------AV_KONSELOR------------------------------
if (!defined("AV_KONSELOR")) define("AV_KONSELOR","25");
//-------------------AV STABILISASI----------------------------
if (!defined("AV_STABILISASI_MALE")) define("AV_STABILISASI_MALE","030002");
if (!defined("AV_STABILISASI_FEMALE")) define("AV_STABILISASI_FEMALE","030012");
if (!defined("AV_STABILISASI_HOG")) define("AV_STABILISASI_HOG","030013");
//-------------------AV REENRTY----------------------------
if (!defined("AV_REENTRY_MALE")) define("AV_REENTRY_MALE","030007");
if (!defined("AV_REENTRY_FEMALE")) define("AV_REENTRY_FEMALE","030010");
if (!defined("AV_REENTRY_HOG")) define("AV_REENTRY_HOG","030015");
//-------------------AV DETOK----------------------------
if (!defined("AV_DETOKSIFIKASI")) define("AV_DETOKSIFIKASI","030001");
if (!defined("AV_DETOKSIFIKASI_FEMALE")) define("AV_DETOKSIFIKASI_FEMALE","030008");
if (!defined("AV_DETOKSIFIKASI_HOG")) define("AV_DETOKSIFIKASI_HOG","030011");
//-------------------AV JABATAN----------------------------
if (!defined("AV_PIMPINAN_BNN")) define("AV_PIMPINAN_BNN","1");
//----------------------------------------------------------------
if (!defined("AV_REHABILITASI_HOC1")) define("AV_REHABILITASI_HOC1","030003");
if (!defined("AV_REHABILITASI_HOC2")) define("AV_REHABILITASI_HOC2","030004");
if (!defined("AV_REHABILITASI_HOC3")) define("AV_REHABILITASI_HOC3","030005");
if (!defined("AV_REHABILITASI_HOC4")) define("AV_REHABILITASI_HOC4","030006");
if (!defined("AV_REHABILITASI_HOC5")) define("AV_REHABILITASI_HOC5","030009");
if (!defined("AV_REHABILITASI_HOC6")) define("AV_REHABILITASI_HOC6","030014");
if (!defined("AV_REHABILITASI_HOC7")) define("AV_REHABILITASI_HOC7","030015");
//----------------------------------------------------------------
if (!defined("AV_URL_BNN")) define("AV_URL_BNN","bnn.loc");
//----------------------------------------------------------------
if (!defined("AV_MODUL_POLIKLINIK")) define("AV_MODUL_POLIKLINIK","13");
if (!defined("AV_MODUL_LABORATORIUM")) define("AV_MODUL_LABORATORIUM","5");
if (!defined("AV_MODUL_RADIOLOGI")) define("AV_MODUL_RADIOLOGI","7");
if (!defined("AV_MODUL_DOKTER")) define("AV_MODUL_DOKTER","3");
if (!defined("AV_MODUL_PERAWAT")) define("AV_MODUL_PERAWAT","4");
if (!defined("AV_MODUL_FARMASI")) define("AV_MODUL_FARMASI","23");
if (!defined("AV_MODUL_GUDANG")) define("AV_MODUL_GUDANG","14");
//----------------------------------------------------------------