<?php 
require'fungsi.php';
//mengambil url dari get index
$id =$_GET["id"];

if (hapusfoto($id) > 0){
	echo"
	<script>
	alert('Data berhasil dihapus!')
	document.location.href='../tampilan/upload-foto.php'
	</script>
	";	
	}else{
	echo"
	<script>
	alert('Data Gagal dihapus!')
	document.location.href='../tampilan/uploud-foto.php'
	</script>
	";
	}
 ?>