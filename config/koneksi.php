<?php 

$conn = mysqli_connect("localhost","root","","olshop");
 
 	if ($conn) {
 		echo "berhasil";
 	}else{
 		echo "gagal :" . mysql_error($conn);
 	}
?>