<?php 
require'fungsi.php';
//mengambil url dari get index
$id =$_GET["id"];

if (hps2($id) > 0){
	echo"
	<script>
	alert('Data berhasil dihapus!')
	document.location.href='../tampilan/informasi.php'
	</script>
	";	
	}else{
	echo"
	<script>
	alert('Data Gagal dihapus!')
	document.location.href='../tampilan/informasi.php'
	</script>
	";
	}
 ?>