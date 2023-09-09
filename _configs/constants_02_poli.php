<?
// Konstanta kode aksi di poli
if (!defined("AV_POLI_KODE_AKSI_ADD")) define("AV_POLI_KODE_AKSI_ADD","0");
if (!defined("AV_POLI_KODE_AKSI_EDIT")) define("AV_POLI_KODE_AKSI_EDIT","1");
if (!defined("AV_POLI_KODE_AKSI_DELETE")) define("AV_POLI_KODE_AKSI_DELETE","2");
if (!defined("AV_POLI_KODE_AKSI_RUJUK_MASUK")) define("AV_POLI_KODE_AKSI_RUJUK_MASUK","3");
if (!defined("AV_POLI_KODE_AKSI_RUJUK_SELESAI")) define("AV_POLI_KODE_AKSI_RUJUK_SELESAI","4");
if (!defined("AV_POLI_KODE_AKSI_SELESAI")) define("AV_POLI_KODE_AKSI_SELESAI","9");

// Konstanta utk ngambil tarif..
if (!defined("AV_POLI_KODE_KLAS_RAWAT_JALAN")) define("AV_POLI_KODE_KLAS_RAWAT_JALAN","16");
if (!defined("AV_POLI_KODE_TINDAKAN")) define("AV_POLI_KODE_TINDAKAN","3");

if (!defined("AV_POLI_KODE_TARIF_BERLAKU")) define("AV_POLI_KODE_TARIF_BERLAKU","1");

// Yang dimasukin ke database di tabel tc_trans_pelayanan
if (!defined("AV_POLI_KODE_PASIEN_DITINDAK")) define("AV_POLI_KODE_PASIEN_DITINDAK","0");
if (!defined("AV_POLI_KODE_PASIEN_RUJUK")) define("AV_POLI_KODE_PASIEN_RUJUK","1");
if (!defined("AV_POLI_KODE_PASIEN_PULANG")) define("AV_POLI_KODE_PASIEN_PULANG","2");
if (!defined("AV_POLI_KODE_PASIEN_BILLING")) define("AV_POLI_KODE_PASIEN_BILLING","9");

// Isi field 'status_periksa' di tabel 'pl_tc_poli'
if (!defined("AV_POLI_KODE_PERIKSA_DITINDAK")) define("AV_POLI_KODE_PERIKSA_DITINDAK","0");
if (!defined("AV_POLI_KODE_PERIKSA_SELESAI")) define("AV_POLI_KODE_PERIKSA_SELESAI","1");
if (!defined("AV_POLI_KODE_PERIKSA_RUJUK_KE_RI")) define("AV_POLI_KODE_PERIKSA_RUJUK_KE_RI","2");

if (!defined("AV_POLI_KODE_PREFIX_POLI")) define("AV_POLI_KODE_PREFIX_POLI","01");
if (!defined("AV_POLI_KODE_SUFFIX_RS")) define("AV_POLI_KODE_SUFFIX_RS","01");
if (!defined("AV_POLI_KODE_MODUL_POLI")) define("AV_POLI_KODE_MODUL_POLI","3");

if (!defined("AV_POLI_MESSAGE_HAPUS_DATA")) define("AV_POLI_MESSAGE_HAPUS_DATA","Apakah tindakan akan dihapus?");
if (!defined("AV_POLI_MESSAGE_PASIEN_SELESAI")) define("AV_POLI_MESSAGE_PASIEN_SELESAI","Apakah pasien sudah selesai ditindak?");
if (!defined("AV_POLI_MESSAGE_PASIEN_RUJUK_KE_RI")) define("AV_POLI_MESSAGE_PASIEN_RUJUK_KE_RI","Apakah pasien akan dirujuk ke Rawat Inap?");

?>