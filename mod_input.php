<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Input Item ke database</title>
<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript">
$(function() {
	//request menu
	$("[id^=mn]").click(function(){
		$('#resulmanager').html('loading...');
    	// get tab id and tab url
		tabId = $(this).attr("id");
		tabUrl = $("#"+tabId).attr("href");
		
		$('#resulmanager').load(tabUrl);
		return false;
	});
	
	//hapus data
	$('.delete').live("click",function() {	
	var nim = $(this).attr("nim");
	if(confirm("yakin data ini mau di delete??"))
	{
		$.ajax({
				type: "POST",
				url: "./proses.php?mode=delete",
				data:"nim="+nim,
			 	cache: false,
			 	success: function(html){
			 		$("#list_"+nim).slideUp('slow', function() {$(this).remove();});
			}
		});
		return false;
		}
	});

});
</script>
<style>
body{
	font-family:Tahoma, Geneva, sans-serif;
	font-size:11px;
}
.grid{
}
.grid th{
	padding:5px;
	border-bottom:1px solid #CCC;
}
.grid td{
	padding:5px;
	border-bottom:1px solid #CCC;
}
.kotak{
	border:1px solid #666;
	
	width:500px;
}
</style>
</head>

<!--
$("#resulmanager").load("./mahasiswa.php?aksi=list"); supaya pas panggil halaman index pertama akan di tampilkan list data
jika akan menampilkan form input
$("#resulmanager").load("./mahasiswa.php?aksi=forminput");  maka index pertama akan di tampilkan input data
-->

<body onload='$("#resulmanager").load("./mahasiswa.php?aksi=list");'>
<div class="kotak">
<!--menu-->
<div class="menu">
<!-- lihat atribut id disini wajib di berikan karena nanti link yang di request akan medeteksi id ini (lihat bagian jquery script di atas $("[id^=mn]").click(function(){ )-->
<a href="./mahasiswa.php?aksi=list" id="mn_list"><img src="../images/list.png"></a>
<a href="./mahasiswa.php?aksi=forminput" id="mn_add"><img src="../images/tambah.png"></a>
</div>
<!-- semua data yang di request aakn di tampilkan di sini -->
    <div id='resulmanager' class='dataresult'>Loading..</div>
</div>
</body>
</html>