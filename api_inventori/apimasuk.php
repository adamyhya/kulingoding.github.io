<?php 
include "koneksi.php";
$callback = $_REQUEST['callback'];
$output = array();
$action = $_REQUEST['action'];
if($action == '1'){
$success = 'false';
$rank = "SET @rank=0";
$query = 'SELECT @rank:=@rank+1 as nomor,
tb_barang.nama_barang,
tb_kategori.nama_kategori,
tb_barang_masuk.jumlah_barang_masuk,
tb_satuan.nama_satuan,
DATE_FORMAT(tb_barang_masuk.tgl_masuk,"%D %M% %Y") as tgl_masuk,
tb_jurusan.nama_jurusan,
tb_user.nama_user,
tb_barang_masuk.keterangan,
tb_barang_masuk.id_brg_masuk 
FROM tb_barang_masuk 
LEFT JOIN tb_barang ON tb_barang.id_barang = tb_barang_masuk.id_barang 
LEFT JOIN tb_kategori ON tb_kategori.id_kategori = tb_barang.id_kategori 
LEFT JOIN tb_satuan ON tb_satuan.id_satuan = tb_barang.id_satuan 
LEFT JOIN tb_jurusan ON tb_jurusan.id_jurusan = tb_barang_masuk.id_jurusan 
LEFT JOIN tb_user ON tb_user.id_user = tb_barang_masuk.id_pengguna' or die("Cannot Access item");
$result = mysqli_query($conn, $rank);
$result = mysqli_query($conn, $query);
if(mysqli_num_rows($result) > 0){
	while($obj = mysqli_fetch_object($result)) {
		$output[] = $obj;
	}
	$success = 'true';
	
}

if($callback) {
	
	echo $callback . '({"success":'.$success.',"items":' . json_encode($output). '});';	
	}
	else
	{
	
		echo json_encode($output);
	}
$conn->close();
}
elseif($action == '2'){
$records = json_decode($_REQUEST['records']);
$idb = $records->{"id_barang"};
$jmlk = $records->{"jumlah_barang_masuk"};
$ket = $records->{"keterangan"};
$jur = $records->{"id_jurusan"};
$pgn = $records->{"id_pengguna"};
$query = "INSERT INTO tb_barang_masuk (id_barang, jumlah_barang_masuk, keterangan, id_jurusan, id_pengguna,tgl_masuk) values ('$idb','$jmlk','$keterangan','$jur','$pgn',NOW()";
if($conn->query($query) == TRUE){
$success = 'true';
}
else{
$success = 'false';
$error = $conn->error;
}
if($callback) {
	echo $callback . '({"success":'.$success.',"items":' . json_encode($output). '});';	
	}
	else
	{
	
		echo json_encode($output);
	}
$conn->close();
}
elseif($action == '3'){
$records = json_decode($_REQUEST['records']);
$idbm = $records->{"id_brg_masuk"};
$query = "DELETE FROM tb_barang_masuk where id_brg_masuk = '$idbm'";
if($conn->query($query) == TRUE){
$success = 'true';
}
else{
$success = 'false';
$error = $conn->error;
}
if($callback) {
	
	echo $callback . '({"success":'.$success.',"items":' . json_encode($output). '});';	
	}
	else
	{
	
		echo json_encode($output);
	}
$conn->close();	
}
else{

}
?>