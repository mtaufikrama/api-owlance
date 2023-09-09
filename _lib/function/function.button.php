<?
// fungsi button hapus ================================================================================================================;
function button_hapus($url="",$ukuran_window="'800','600'",$mode="2",$nama_form="averin_form",$level="3",$comment="Anda benar-benar ingin menghapus data ini")
{

	// yang bisa menghapus hanya untuk  level : 4 dan 5

		global $loginInfo;

		if(($loginInfo["hak_akses"]=="") or ($loginInfo["hak_akses"]=="1") or ($loginInfo["hak_akses"]=="2") or ($loginInfo["hak_akses"]=="3") or ($loginInfo["hak_akses"]=="4") or ($loginInfo["hak_akses"]=="5") ):		
		$alt="Hapus";
		$href="javascript:if (confirm('".$comment."')) { document.getElementById('".$nama_form."').action='".$url."';document.getElementById('".$nama_form."').submit();}";
		else:
		$url="#";
		$href="javascript:alert('Maaf Anda tidak berhak untuk menghapus ! ')";
		$comment="Maaf Anda tidak berhak untuk menghapus !";
		$alt="Maaf Anda tidak berhak untuk menghapus !";		
		endif;
?>

<? if($mode=="1"):?>
<a class="actLink" href="<?=$url?>"  onclick="javascript:return window.confirm('<?=$comment?>')" ><img src="../_images/icons/ico_acthapus.png"  border="0" alt="Hapus" align="absmiddle"></a>
<?elseif($mode=="2"):?>
<a class="actLink" href="<?=$href?>"><img src="../_images/icons/ico_acthapus.png"  border="0" alt="Hapus" align="absmiddle"></a>
<?endif;?>
<?
}

//end of fungsi button hapus =========================================================================================================;
// fungsi button hapus Detail ================================================================================================================;
function button_hapus_detail($url="",$ukuran_window="'800','600'",$mode="2",$nama_form="averin_form",$level="3",$comment="Anda benar-benar ingin menghapus data ini")
{

	// yang bisa menghapus hanya untuk  level : 4 dan 5

		global $loginInfo;

		if(($loginInfo["hak_akses"]=="") or ($loginInfo["hak_akses"]=="1") or ($loginInfo["hak_akses"]=="2") or ($loginInfo["hak_akses"]=="4") or ($loginInfo["hak_akses"]=="5") ):		
		$alt="Hapus";
		$href="javascript:if (confirm('".$comment."')) { openPop('".$url."',".$ukuran_window.");}";
		else:
		$url="#";
		$href="javascript:alert('Maaf Anda tidak berhak untuk menghapus ! ')";
		$comment="Maaf Anda tidak berhak untuk menghapus !";
		$alt="Maaf Anda tidak berhak untuk menghapus !";		
		endif;
?>

<a href="<?=$href?>"><img src="../_images/icons/icokecil_hapus.gif"  border="0" alt="Hapus" align="absmiddle"></a>

<?
}

//end of fungsi button hapus =========================================================================================================;

// fungsi button edit ================================================================================================================;

function button_edit($url="",$ukuran_window="'800','600'",$mode="1",$nama_form="averin_form",$level="3",$comment="Anda benar-benar ingin mengedit data ini?")
{
global $loginInfo;
		
		// yang bisa mengedit hanya untuk  level : 3,4 dan 5

		if(($loginInfo["hak_akses"]=="") or ($loginInfo["hak_akses"]=="1") or ($loginInfo["hak_akses"]=="2") or ($loginInfo["hak_akses"]=="3") or ($loginInfo["hak_akses"]=="4") or ($loginInfo["hak_akses"]=="5") ):		

			if($mode=="1"): // jika mode=1 maka
				$alt="Edit";
				$href="javascript:openPop('".$url."',".$ukuran_window.");";
			elseif($mode=="2") :
				$alt="Edit";
				$href="javascript:if (confirm('".$comment."')) { document.getElementById('".$nama_form."').action='".$url."';document.getElementById('".$nama_form."').submit();}";
			endif;

		else:
			
			$url="#";
			$href="javascript:alert('Maaf Anda tidak berhak untuk mengedit data ! ')";
			$alt="Edit";		

		endif;
?>
<a class="actLink" href="<?=$href?>"><img src="../_images/icons/ico_acteditpad.png" border="0" alt="Edit" align="absmiddle"></a>
<?
}

// end of fungsi button edit ========================================================================================================;

// fungsi button edit detail ========================================================================================================;

function button_edit_detail($url="",$ukuran_window="'800','600'",$mode="1",$nama_form="averin_form",$level="3",$comment="Anda benar-benar ingin mengedit data ini?")
{
global $loginInfo;
		
		// yang bisa mengedit hanya untuk  level : 3,4 dan 5

		if(($loginInfo["hak_akses"]=="") or ($loginInfo["hak_akses"]=="1") or ($loginInfo["hak_akses"]=="2") or ($loginInfo["hak_akses"]=="3") or ($loginInfo["hak_akses"]=="4") or ($loginInfo["hak_akses"]=="5") ):		

			if($mode=="1"): // jika mode=1 maka
				$alt="Edit";
				$href="javascript:openPop('".$url."',".$ukuran_window.");";
			elseif($mode=="2") :
				$alt="Edit";
				$href="javascript:if (confirm('".$comment."')) { document.getElementById('".$nama_form."').action='".$url."';document.getElementById('".$nama_form."').submit();}";
			endif;

		else:
			
			$url="#";
			$href="javascript:alert('Maaf Anda tidak berhak untuk mengedit data ! ')";
			$alt="Edit";		

		endif;
?>
<a href="<?=$href?>" ><img src="../_images/icons/ico_actedit.png" border="0" alt="<?=$alt?>"></a>
<?
}

// end of fungsi button edit detail =================================================================================================;
// fungsi button persetujuan =============================================================================================================;

function button_persetujuan($url="",$ukuran_window="'800','600'",$mode="1",$nama_form="averin_form",$level="3",$comment="Anda benar-benar ingin mengedit data ini?")
{
global $loginInfo;
		
		// yang bisa disetujui hanya untuk  level : 3,4 dan 5

		if(($loginInfo["hak_akses"]=="") or ($loginInfo["hak_akses"]=="1") or ($loginInfo["hak_akses"]=="2") or ($loginInfo["hak_akses"]=="3") or ($loginInfo["hak_akses"]=="4") or ($loginInfo["hak_akses"]=="5") ):		

			if($mode=="1"): // jika mode=1 maka
				$alt="Persetujuan";
				$href="javascript:openPop('".$url."',".$ukuran_window.");";
			elseif($mode=="2") :
				$alt="Persetujuan";
				$href="javascript:if (confirm('".$comment."')) { document.getElementById('".$nama_form."').action='".$url."';document.getElementById('".$nama_form."').submit();}";
			endif;

		else:
			
			$url="#";
			$href="javascript:alert('Maaf Anda tidak berhak untuk mempersetujui data ! ')";
			$alt="persetujuan";		

		endif;
?>
<a href="<?=$href?>" ><img src="../_images/icons/icon_edit.gif" border="0" alt="<?=$alt?>"></a>
<?
}
// end of fungsi button persetujuan =================================================================================================;

// fungsi button simpan =============================================================================================================;

function button_simpan($url="",$ukuran_window="'800','600'",$mode="2",$nama_form="averin_form",$level="3",$comment="Anda benar-benar ingin menyimpan data ini ?",$tulisan="&nbsp;Simpan")
{

global $loginInfo;

		// yang bisa meng-input hanya untuk  level : 2,3,4 dan 5

		

		if(($loginInfo["hak_akses"]=="") or ($loginInfo["hak_akses"]=="1") or  ($loginInfo["hak_akses"]=="2") or ($loginInfo["hak_akses"]=="3") or ($loginInfo["hak_akses"]=="4") or ($loginInfo["hak_akses"]=="5") ):		

			if($mode=="1"): // jika mode=1 maka
				$alt="Simpan";
				$href="javascript:openPop('".$url."',".$ukuran_window.");";
			elseif($mode=="2") :
				$alt="Simpan";
				$href="javascript:if (confirm('".$comment."')) { document.getElementById('".$nama_form."').action='".$url."';document.getElementById('".$nama_form."').submit();}";
			endif;

		else:
			
			$url="#";
			$href="javascript:alert('Maaf Anda tidak berhak untuk menyimpan data ! ')";
			$alt="Simpan";		

		endif;

?>

<a class="actLink" href="<?=$href?>"><img src="../_images/icons/ico_actsimpan.png" border="0" alt="<?= $simpan?>" align="absmiddle"><?=$tulisan?></a>

<?
}

// end of fungsi button simpan =====================================================================================================;

// fungsi button ok ================================================================================================================;

function button_ok($url="",$ukuran_window="'800','600'",$mode="2",$nama_form="averin_form",$level="3",$comment="Anda benar-benar ingin menyimpan data ini ?")
{
		global $loginInfo;

		// yang bisa meng-input hanya untuk  level : 2,3,4 dan 5

		if(($loginInfo["hak_akses"]=="") or ($loginInfo["hak_akses"]=="1") or ($loginInfo["hak_akses"]=="2") or ($loginInfo["hak_akses"]=="3") or ($loginInfo["hak_akses"]=="4") or ($loginInfo["hak_akses"]=="5") ):		

			if($mode=="1"): // jika mode=1 maka
				$alt="Simpan";
				$href="javascript:openPop('".$url."',".$ukuran_window.");";
			elseif($mode=="2") :
				$alt="Simpan";
				$href="javascript:if (confirm('".$comment."')) { document.getElementById('".$nama_form."').action='".$url."';document.getElementById('".$nama_form."').submit();}";
			endif;

		else:
			
			$url="#";
			$href="javascript:alert('Maaf Anda tidak berhak untuk menyimpan data ! ')";
			$alt="Simpan";		

		endif;

?>
<a class="actLink" href="<?=$href?>"><img src="../_images/icons/ico_actok.png" border="0" alt="<?=$alt?>" align="absmiddle"></a>
<?
}

// end of fungsi button ok =========================================================================================================;

// fungsi button tambah ============================================================================================================;


function button_tambah($url="",$nama="",$mode="1",$nama_form="averin_form",$level="3",$comment="Anda benar-benar ingin menambah data ?",$ukuran_window="'800','600'")
{
global $loginInfo;


		// yang bisa meng-input hanya untuk  level : 2,3,4 dan 5

		if(($loginInfo["hak_akses"]=="") or ($loginInfo["hak_akses"]=="1") or ($loginInfo["hak_akses"]=="2") or ($loginInfo["hak_akses"]=="3") or ($loginInfo["hak_akses"]=="4") or ($loginInfo["hak_akses"]=="5") ):		

			if($mode=="1"): // jika mode=1 maka
				$alt="Tambah";
				$href="javascript:openPop('".$url."',".$ukuran_window.");";
			elseif($mode=="2") :
				$alt="Tambah";
				$href="javascript:if (confirm('".$comment."')) { document.getElementById('".$nama_form."').action='".$url."';document.getElementById('".$nama_form."').submit();}";
			endif;

		else:
			
			$url="#";
			$href="javascript:alert('Maaf Anda tidak berhak untuk menambah data ! ')";
			$alt="Tambah";		

		endif;


?>

<a class="actLink" href="<?=$href?>"><img src="../_images/icons/ico_acttambah.png" border="0" alt="<?=$alt?>" align="absmiddle"><?=$nama?></a>

<?
}

// end of fungsi button tambah =====================================================================================================;

function button_tambah_detail($url="",$nama="",$mode="1",$nama_form="averin_form",$level="3",$comment="Anda benar-benar ingin menambah data ?",$ukuran_window="'800','600'")
{
global $loginInfo;


		// yang bisa meng-input hanya untuk  level : 2,3,4 dan 5

		if(($loginInfo["hak_akses"]=="2") or ($loginInfo["hak_akses"]=="3") or ($loginInfo["hak_akses"]=="4") or ($loginInfo["hak_akses"]=="5") ):		

			if($mode=="1"): // jika mode=1 maka
				$alt="Tambah";
				$href="javascript:openPop('".$url."',".$ukuran_window.");";
			elseif($mode=="2") :
				$alt="Tambah";
				$href="javascript:if (confirm('".$comment."')) { document.getElementById('".$nama_form."').action='".$url."';document.getElementById('".$nama_form."').submit();}";
			endif;

		else:
			
			$url="#";
			$href="javascript:alert('Maaf Anda tidak berhak untuk menambah data ! ')";
			$alt="Tambah";		

		endif;


?>

<a href="<?=$href?>"><img src="../_images/icons/ico_acttambah.png" border="0" alt="<?=$alt?>"><?=$nama?></a>

<?
}

// end of fungsi button_tambah_detail =====================================================================================================;

// fungsi button cetak =============================================================================================================;


function button_cetak($url="",$nama="",$mode="1",$nama_form="averin_form",$level="3",$comment="Apakah Data Akan Dicetak ?",$ukuran_window="'800','600'")
{
	global $loginInfo;
?>


<? if($mode=="1"):?>
<a class="actLink" href="javascript:openPop2('<?=$url?>','<?=date("His")?>',<?=$ukuran_window?>)"><img src="../_images/icons/ico_actcetak.png" border="0" alt="Cetak <?=$nama; ?>" align="absmiddle"><?=$nama; ?></a>
<?elseif($mode=="2"):?>
<a class="actLink" href="javascript:if (confirm('<?=$comment?>')) { document.getElementById('<?=$nama_form?>').action='<?=$url?>';document.getElementById('<?=$nama_form?>').submit();}"><img src="../_images/icons/ico_actcetak.png" border="0" alt="Cetak <?=$nama; ?>" align="absmiddle"></a>
<?endif;?>

<?
}

// end of fungsi button cetak =====================================================================================================;

// fungsi button kembali =============================================================================================================;

?>

<?
function button_kembali($url="",$target="_self",$nama="")
{

global $loginInfo;
?>


<a class="actLink" href="<?=$url; ?>" target="<?=$target; ?>" id="actButtonKembali"><img src="../_images/icons/ico_actkembali.png" border="0" alt="<?=$nama; ?>" align="absmiddle"><?=$nama; ?></a>

<?
}
?>

<?
function button_berikut($url="",$target="_self",$nama="")
{
global $loginInfo;
?>
<a class="actLink" href="<?=$url; ?>" target="<?=$target; ?>" id="actButtonBerikut"><img src="../_images/icons/ico_actberikut.png" border="0" alt="<?=$nama; ?>" align="absmiddle"><?=$nama; ?></a>
<?
}
?>

<?
function button_refresh($url="",$target="_self",$nama="")
{
global $loginInfo;
?>


<a class="actLink" href="<?=$url; ?>" target="<?=$target; ?>"><img src="../_images/icons/ico_actrefresh.png" border="0" alt="<?=$nama; ?>" align="absmiddle"><?=$nama; ?></a>

<?
}
?>

<?
function button_proses($url="",$nama="",$comment="Apakah Benar data hendak diproses ??",$nama_form="averin_form")
{
	global $loginInfo;
?>
<a class="actLink" href="javascript:if (confirm('<?=$comment?>')) { document.getElementById('<?=$nama_form?>').action='<?=$url?>';document.getElementById('<?=$nama_form?>').submit();}"><img src="../_images/icons/ico_actrefresh.png" border="0" alt="<?=$nama?>" align="absmiddle">&nbsp;<?= $nama; ?></a>

<?
}
?>
<?
function button_back($url="",$nama=" Kembali")
{
	global $loginInfo;
?>
<a class="actLink" href="javascript:history.back()"><img src="../_images/icons/ico_actkembali.png" border="0" alt="<?=$nama?>" align="absmiddle"><?=$nama; ?></a>

<?
}
?>
<?
function button_cetak_now($url="",$nama=" Cetak")
{
	global $loginInfo;
?>
<a class="actLink" href="javascript:window.print()"><img src="../_images/icons/ico_actcetak.png" border="0" alt="<?=$nama; ?>" align="absmiddle"><?=$nama; ?></a>
<?
}
?>
<?
// fungsi button NEGO =============================================================================================================;
function button_nego($url="",$nama="",$mode="1",$nama_form="averin_form",$level="3",$comment="Anda benar-benar ingin menambah data ?",$ukuran_window="'800','600'")
{
global $loginInfo;


		// yang bisa meng-input hanya untuk  level : 2,3,4 dan 5

		if(($loginInfo["hak_akses"]=="2") or ($loginInfo["hak_akses"]=="3") or ($loginInfo["hak_akses"]=="4") or ($loginInfo["hak_akses"]=="5") ):		

			if($mode=="1"): // jika mode=1 maka
				$alt="Nego";
				$href="javascript:openPop('".$url."',".$ukuran_window.");";
			elseif($mode=="2") :
				$alt="Tambah";
				$href="javascript:if (confirm('".$comment."')) { document.getElementById('".$nama_form."').action='".$url."';document.getElementById('".$nama_form."').submit();}";
			endif;

		else:
			
			$url="#";
			$href="javascript:alert('Maaf Anda tidak berhak untuk menambah data ! ')";
			$alt="Nego";		

		endif;


?>

<a class="actLink" href="<?=$href?>"><img src="../_images/icons/ico_history.png" border="0" alt="<?=$alt?>" align="absmiddle"><?=$nama?></a>

<?
}

// end of fungsi button cetak =====================================================================================================;
?>
<?// fungsi button edit detail ========================================================================================================;

function button_lihat($url="",$ukuran_window="'800','600'",$mode="1",$nama_form="averin_form",$level="3",$comment="Anda benar-benar ingin mengedit data ini?")
{
global $loginInfo;
		
		// yang bisa mengedit hanya untuk  level : 3,4 dan 5

		if(($loginInfo["hak_akses"]=="3") or ($loginInfo["hak_akses"]=="4") or ($loginInfo["hak_akses"]=="5") ):		

			if($mode=="1"): // jika mode=1 maka
				$alt="lihat";
				$href="javascript:openPop('".$url."',".$ukuran_window.");";
			elseif($mode=="2") :
				$alt="lihat";
				$href="javascript:if (confirm('".$comment."')) { document.getElementById('".$nama_form."').action='".$url."';document.getElementById('".$nama_form."').submit();}";
			endif;

		else:
			
			$url="#";
			$href="javascript:alert('Maaf Anda tidak berhak untuk melihat data ! ')";
			$alt="Edit";		

		endif;
?>
<a href="<?=$href?>" ><img src="../_images/icons/icosmall_magnifier.gif" border="0" alt="<?=$alt?>"></a>
<?
}

// end of fungsi button edit detail =================================================================================================;
?>