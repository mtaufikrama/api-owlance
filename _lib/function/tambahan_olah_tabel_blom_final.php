<?
if($hasil==true)
			{	
					$tgl=date("Y-m-d H:i:s");
					$id_dd_user=$loginInfo["id_dd_user"];
					$ip_address=USER_IP_ADDRESS;
					$kode_bagian=$loginInfo["kode_bagian"];
					$session_id=session_id();
					$sql_command=$sqlUpdate;
					$tabel=$tbl;
					$field=print_r($fld_n_values);
					$kondisi=$opt;
					$jenis_sql=2;
				$sqlLog="insert into log_history(tgl,id_dd_user,ip_address,kode_bagian,session_id,nama_file,sql_command,tabel,field,kondisi,jenis_sql) values('$tgl','$id_dd_user','$ip_address','$kode_bagian','$session_id','$nama_file','$sql_command','$tabel','$field','$kondisi',2)";

			}
?>