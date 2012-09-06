<?php
include "../../config/config.php";
//tambah data
if(isset($_GET['mode']) && $_GET['mode'] == 'add'){
	//periksa apakah nim sudah di gunakan
	$query=mysql_query("SELECT * FROM `tmp_detail_ttb` WHERE `kode_barang` = '{$_POST['nim']}'");
	if($jum=mysql_num_rows($query) > 0){
		$error=true;
		echo "nim sudah di gunakan";
		exit();
	}
	
	if(!$error){
		$tgl = date("d-m-Y");
		$query=mysql_query("INSERT INTO `tmp_detail_ttb` (
						   `kode_barang`,
						   `id_po`,
						   `diterima`,
						   `tanggal`,
						   `status_item`,
						   `kategori`
						   )VALUES(
						   '{$_POST['nim']}',
						   '{$_POST['nopo']}',
						   '{$_POST['nama']}',
						   '$tgl',
						   '{$_POST['status']}',
						   '{$_POST['tmplahir']}')
						   ");
		if($query){
			echo "data sudah di masukan";
		}
	}
exit();	
}
//edit data
if(isset($_GET['mode']) && $_GET['mode'] == 'edit'){
		$query=mysql_query("UPDATE `tmp_detail_ttb` SET
						   `id_po` = '{$_POST['nopo']}',
						   `diterima` =  '{$_POST['nama']}',
						   `kategori` =  '{$_POST['tmplahir']}',
						   `status_item`	=  '{$_POST['status']}'
						  WHERE `kode_barang` = '{$_POST['nim']}'");
		if($query){
			echo "data sudah di edit";
		}
exit();	
}
//delete data
if(isset($_GET['mode']) && $_GET['mode'] == 'delete'){
	$nim=$_POST['nim'];
	$query=mysql_query("DELETE FROM `tmp_detail_ttb` WHERE `kode_barang` = '{$nim}' ");
}
?>