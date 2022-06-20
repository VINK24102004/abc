<?php 
require'fungsi.php';
//mengambil url dari get index
$id =$_GET["id"];

if (hapus4($id) > 0){
	echo"
	<script>
	alert('Data berhasil dihapus!')
	document.location.href='../tampilan/news.php'
	</script>
	";	
	}else{
	echo"
	<script>
	alert('Data Gagal dihapus!')
	document.location.href='../tampilan/news.php'
	</script>
	";
	}
 ?>