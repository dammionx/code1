<script type="text/javascript">
$(function() {
//request input data
$("form#frm_input").submit(function(){
	$("#result").show();
	var nim = $("#nim").attr('value');
	var nama = $("#nama").attr('value');
	var tmplahir = $("#tmplahir").attr('value');
	var alamat = $("#alamat").attr('value');
	var nopo = $("#nopo").attr('value');
	var status = $("#status").attr('value');
	//periksa data field infutnya di isi?
	//silahkan validasi sesuai keinginan anda
	if(nim==''){
		alert('Kode barang harus di isi');
		return false;
	}
	$.ajax({
			type: "POST",
			url: "./proses.php?mode=add",
			data:"nim="+nim+'&nama='+nama+'&tmplahir='+tmplahir+'&alamat='+alamat+'&nopo='+nopo+'&status='+status,
			success: function(data){
				$("#result").html(data);
			}
	});
	return false;
	});
//request edit
$("form#frm_edit").submit(function(){
	$("#result").show();
	var nim = $("#nim").attr('value');
	var nama = $("#nama").attr('value');
	var tmplahir = $("#tmplahir").attr('value');
	var alamat = $("#alamat").attr('value');
	var nopo = $("#nopo").attr('value');
	var status = $("#status").attr('value');
	//periksa data field infutnya di isi?
	//silahkan validasi sesuai keinginan anda
	$.ajax({
			type: "POST",
			url: "./proses.php?mode=edit",
			data:"nim="+nim+'&nama='+nama+'&tmplahir='+tmplahir+'&alamat='+alamat+'&nopo='+nopo+'&status='+status,
			success: function(data){
				$("#result").html(data);
			}
	});
	return false;
	});

});
</script>

<?php
include "../../config/config.php";

//jika halaman yang di request  list data mahasiswa
if(isset($_GET['aksi']) && $_GET['aksi'] == 'list'){
	$query=mysql_query("SELECT * FROM `tmp_detail_ttb`");
	echo "<table cellpading='1' cellspacing='1' width='100%' border='0' class='grid'>";
	echo "<tr><th>No</th><th>ID Barang</th><th>Jumlah</th><th>ID PO</th><th>Tanggal</th><th>Kategori Item</th><th>Status Item</th><th>Opsi</th></tr>";
	//jika tidak ada record 
	if($jum=mysql_num_rows($query) == 0){
		echo "<tr><td colspan='4'>";
		echo isset($_GET['idttb']);
		echo "tidak ada data</td></tr>";
	}
	$no=0;
	while($row=mysql_fetch_object($query)){
		$no++;
		//pemberian id='list_{$row->nim}' pada tag tr nanti akan di gunakan jika data di delete maka baris record tersebut akan di delete
		echo "<tr id='list_{$row->kode_barang}'>";
		echo "<td> {$no} </td>";
		echo "<td> {$row->kode_barang} </td>";
		echo "<td> {$row->diterima} </td>";
		echo "<td> {$row->id_po} </td>";
		echo "<td> {$row->tanggal} </td>";
		echo "<td> {$row->kategori} </td>";
		echo "<td> {$row->status_item} </td>";
		//pemberian atribut class dan nim sangat penting karena nanti untuk menghapus data parameter tersebut yang akan di jadikan acuan 
		echo "<td> <a href='#' class='delete' nim='{$row->kode_barang}'>delete</a> - ";
		
		echo "<a href='#' onclick='$(\"#resulmanager\").load(\"./mahasiswa.php?aksi=formedit&nim={$row->kode_barang}\");'> edit </td>";
		echo "</tr>";
	}
	echo "</table>";
	echo "<div><a href='#' onclick='$(\"#resulmanager\").load(\"./mahasiswa.php?aksi=forminput\");'> <img src='../images/tambah.png'> </a></div>";
exit();	
}

//jika halaman yang di request  input data mahasiswa
if(isset($_GET['aksi']) && $_GET['aksi'] == 'forminput'){
	$ambilKategoriBarang = mysql_query("select * from kategori_barang");
	echo "<div id='result'>&nbsp;</div>"; // untuk nanti data calllbach hasil request akan di tampilkan disini
	echo "<form id='frm_input'>";
	echo "<table cellpading='1' cellspacing='1' width='100%' border='0'>";
	//pemberian atribut id sangat penting.. karena nilai yang di ambil dari fild tersebut nanti berdasarkan id tersebut
	echo "<tr><td width='30%'>Kode Barang</td><td><input type='text' name='nim' id='nim'></td></tr>";
	echo "<tr><td width='30%'>No PO</td><td><input type='text' name='nopo' id='nopo' value='$_GET[idttb]'></td></tr>";
	echo "<tr><td>Jumlah Diterima</td><td><input type='text' name='nama' id='nama'></td></tr>";
	echo "<tr><td>Kategori Item</td><td><select name='tmplahir' id='tmplahir'>
                            <option value='0'>- Kategori Barang-</option>";
                            while($kategori = mysql_fetch_array($ambilKategoriBarang)){
                                echo "<option value='$kategori[namaKategoriBarang]'>$kategori[namaKategoriBarang]</option>";
                            }
            echo "</select></td></tr>";
	echo "<tr><td>Status</td><td><select name='status' id='status'>
	<option value='Incindentil'>Incindentil</option>
	<option value='Stock'>Stock</option>
	</select></td></tr>";
	echo "<tr><td>&nbsp;</td><td><input type='submit' value='kirim'></td></tr>";
	echo "</table>";
	echo "</form>";
	exit();
}

//jika halaman yang di request  edit data mahasiswa
if(isset($_GET['aksi']) && $_GET['aksi'] == 'formedit'){
	//ambil data mahasiswa

	$query=mysql_fetch_object(mysql_query("SELECT * FROM `tmp_detail_ttb` WHERE `kode_barang` = '{$_GET['nim']}'"));
	$ambilKategoriBarang = mysql_query("select * from kategori_barang");
	echo "<div id='result'>&nbsp;</div>"; // untuk nanti data calllbach hasil request akan di tampilkan disini
	echo "<form id='frm_edit'>";
	echo "<table cellpading='1' cellspacing='1' width='100%' border='0'>";
	//pemberian atribut id sangat penting.. karena nilai yang di ambil dari fild tersebut nanti berdasarkan id tersebut
	echo "<tr><td width='30%'>Kode Barang</td><td><input type='text' disabled='disabled' value='{$query->kode_barang}'></td></tr>";
	echo "<tr><td>Jumlah</td><td><input type='text' name='nama' id='nama' value='{$query->diterima}'></td></tr>";
	echo "<tr><td>ID PO</td><td><input type='text' name='nopo' id='nopo' value='{$query->id_po}'></td></tr>";
	$kategorinya = $query->kategori;
	$statusnya = $query->status_item;
	echo "<tr><td>Kategori Item</td><td>
	<select name='tmplahir' id='tmplahir'>";
                            while($kategori = mysql_fetch_array($ambilKategoriBarang)){
                                if($kategori[namaKategoriBarang] == $kategorinya){
                                    echo "<option value='$kategorinya' selected>$kategorinya</option>";
                                }
                                else{
                                    echo "<option value='$kategori[namaKategoriBarang]'>$kategori[namaKategoriBarang]</option>";
                                }
                            }
            echo "</select>
	</td></tr>";
	echo "<tr><td>Status Item</td><td>
	<select name='status' id='status'>";
                            
                                if($statusnya == 'Incindentil'){
                                    echo "<option value='Incindentil' selected>Incindentil</option>";
									 echo "<option value='Stock'>Stock</option>";
                                }
                                else{
                                   echo "<option value='Stock' selected>Stock</option>";
								    echo "<option value='Incindentil' >Incindentil</option>";
                                }
                            
            echo "</select>
	</td></tr>";
	//paramaeter kunci
	echo "<input type='hidden' name='nim' id='nim' value='{$query->kode_barang}'>";
	echo "<tr><td>&nbsp;</td><td><input type='submit' value='kirim'></td></tr>";
	echo "</table>";
	echo "</form>";
	exit();
}
?>