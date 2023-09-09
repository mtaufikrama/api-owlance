<?
function konfirmasi($teksnya="",$mode="1",$link="")
{
// inisialisasi comment :::
if($teksnya==""):
switch ($mode) 
	{
    case 1:
        $teksnya="Anda benar-benar ingin menghapus data ini ?";
        break;
    case 2:
        $teksnya="Anda benar-benar ingin mengubah data ini ?";
        break;
    case 3:
        $teksnya="Anda ingin mencetak data ini ?";
        break;
	case 4:
        $teksnya="Anda ingin mengisi data ?";
        break;
	case 4:
        $teksnya="Apakah data sudah benar ?";
        break;
    default:
        $teksnya="Anda benar-benar ingin menghapus data ini ? ?";
	}
endif;


//============

if($link!="")
	{
?>
onclick="javascript: if(window.confirm('<?echo $teksnya ?>')==true){location.href='<?=$link?>'}else{return false;}"	
<?	
	}
	else
	{
?>
onclick="javascript:return window.confirm('<?echo $teksnya ?>')"
<?
	}
}
?>