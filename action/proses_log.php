<?php 
session_start();
include"../config/fungsi.php";

$usr = $_POST['usr'];
$password = $_POST['password'];

$query = "SELECT * FROM admin WHERE adminname = '$usr' AND adminpass = '$password' ";

$query_login = mysqli_query($conn, $query);

if (mysqli_num_rows($query_login) > 0 ) {
	$data_login = mysqli_fetch_assoc($query_login);
	$_SESSION['id_admin'] = $data_login['id_admin']; //$data_login['id'];
	header("location: ../tampilan/index.php");

}
else{
	echo "<script>
      alert('Anda Gagal login!');
      document.location.href = ' ../tampilan/login.php';
      </script>";
}

 ?>