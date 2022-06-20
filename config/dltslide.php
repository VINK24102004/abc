<?php 
require'fungsi.php';
//mengambil url dari get index
$id =$_GET["id"];

if (hpsslide($id) > 0){
	echo"
	<script>
	alert('Data berhasil dihapus!')
	document.location.href='../tampilan/slideshow.php'
	</script>
	";	
	}else{
	echo"
	<script>
	alert('Data Gagal dihapus!')
	document.location.href='../tampilan/slideshow.php'
	</script>
	";
	}
 ?>