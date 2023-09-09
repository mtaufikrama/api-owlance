<?

include "../function/db.php";
include WWWROOT."/_lib/_av/password_protect.php";
include WWWROOT."/_lib/_av/function.enkrip.php";

if(!$klik){
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE> New Document </TITLE>
<META NAME="Generator" CONTENT="EditPlus">
<META NAME="Author" CONTENT="">
<META NAME="Keywords" CONTENT="">
<META NAME="Description" CONTENT="">
</HEAD>

<BODY>

<TABLE border="1" width="100%" height="100%">
<TR valign="top" height="100">
	<TD>
	
	 <FORM METHOD=POST ACTION="" target="lihat_log_frame">
    <table width="840" border="0">
		<tr>
        <td width="130">TABEL </td>
        <td width="10">:</td>
        <td width="700">
								<SELECT NAME="nama_tabel">
					<option value=""> --- Pilih Tabel --- </option>
					<?
					$a = $db->MetaTables('TABLES');
						asort($a);
							if ($a==false) print "<b>MetaTables not supported</b></p>";
							else {
								foreach($a as $v) 
								{				
									echo "<option> $v </option>";				
								}
								echo "</select> ";
							};
					?>

					</SELECT> jumlah record <INPUT TYPE="text" NAME="jumlah_record_tabel" SIZE="10" value="ALL"> Order by <INPUT TYPE="text" NAME="order_by_tabel" value="">
		</td>
      </tr>
      <tr>
        <td width="">VIEW </td>
        <td width="">:</td>
        <td width="">
									<SELECT NAME="nama_view">
						<option value=""> --- Pilih VIEW --- </option>
						<?
						$b = $db->MetaTables('VIEWS');
							asort($b);
								if ($b==false) print "<b>MetaTables not supported</b></p>";
								else {
									foreach($b as $x) 
									{				
										echo "<option> $x </option>";				
									}
									echo "</select> ";
								};
						?>

						</SELECT> jumlah record <INPUT TYPE="text" SIZE="10" NAME="jumlah_record_view" value="ALL"> Order by <INPUT TYPE="text" NAME="order_by_view" value="">
		</td>
      </tr>
      <tr>
        <td>SQL</td>
        <td>:</td>
        <td><TEXTAREA NAME="sqlnya" ROWS="5" COLS="45"><?=$sqlnya?></TEXTAREA></td>
      </tr>
      <tr>
		<td> Pilihan </td>
        <td>:</td>
		<td><INPUT TYPE="radio" NAME="pilihan_eksekusi" value="see" checked> Select <INPUT TYPE="radio" NAME="pilihan_eksekusi" value="do"> Update/delete/insert 
		<INPUT TYPE="submit" name="klik" value="Execute">
		</td>
      </tr>
    </table>
    </FORM>
	</TD>
</TR>
<TR valign="top">
	<TD>
	<iframe name="lihat_log_frame" id="id_lihat_log_frame" frameborder="0" src="see_logs_file_result.php" height="100%" width="100%"></iframe>
	</TD>
</TR>
</TABLE>

</BODY>
</HTML>
<?
}
else
{
if($sqlnya!=""){
$res = $db->Execute(stripslashes($sqlnya));

if($pilihan_eksekusi=="see"){
$arr = $res->GetArray();
echo "<pre>";
print_r($arr);
echo "</pre>";
}


if($res){echo "sukses";}else{echo "gagal".$sql;};

}
elseif($nama_tabel!="")
{	
	if(is_numeric($jumlah_record_tabel)){$sql_tambah_top_tabel=" TOP $jumlah_record_tabel ";}
	if($order_by_tabel!=""){$sql_tambah_order_tabel =" ORDER BY  $order_by_tabel";}
	$res = $db->Execute(stripslashes("select $sql_tambah_top_tabel * from $nama_tabel $sql_tambah_order_tabel"));
	$arr = $res->GetArray();
		echo "<pre>";
		print_r($arr);
		echo "</pre>";
}
elseif($nama_view!="")
{
	if(is_numeric($jumlah_record_view)){$sql_tambah_top_view=" TOP $jumlah_record_view ";}
	if($order_by_view!=""){$sql_tambah_order_view =" ORDER BY  $order_by_view";}
	$res = $db->Execute(stripslashes("select $sql_tambah_top_view * from $nama_view $sql_tambah_order_view"));
	$arr = $res->GetArray();
		echo "<pre>";
		print_r($arr);
		echo "</pre>";
}

}	
?>