<?php 
include "koneksi.php";
$callback = $_REQUEST['callback'];
$output = array();
$success = 'false';
$rank = "SET @rank=0";
$query = 'SELECT @rank:=@rank+1 as nomor, id_user, uname , pwd , nama_user , akses , kontak , DATE_FORMAT(tgl_buat,"%D %M% %Y") as tgl_buat from tb_user' or die("Cannot Access item");
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
?>