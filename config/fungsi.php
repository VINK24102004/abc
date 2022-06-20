<?php 

//KONEKSI

$conn = mysqli_connect("Localhost","root","","ecommerce"); 

//PEMBUAT
// Gilang
// Rahma
// Rivandy


//============================================================================//
//**Gilang**//
//1.produk
//2.informasi
//3.sosmed
//4.news
//============================================================================//

//output
function query($output){
// variabel koneksi
  global $conn;
//variabel query/menampilkan data	
	$result = mysqli_query($conn,$output);
//array kosong untuk wadah data 	
 	$rows = [];
//perulangan untuk data bertipe array
 while($row = mysqli_fetch_assoc($result)) {
 	$rows[] = $row;
	 }
//mengembalikan nilai variabel rows	 
return $rows;
}

//fungsi uang
function uang($nominal){
	$rp = number_format($nominal,0,',','.');
	return $rp;
}

//1.produk
	//a.tambah
	function tambah($tmbh){
    
    global $conn;
    $nmprd = htmlspecialchars($tmbh["prd"]);
    $harga =str_replace(".","",htmlspecialchars($tmbh["hrg"]));
    $foto = uploud();
    if (!$foto ) {
         return false;
     }  
    $kategori = $tmbh["ktg"];
	$warna =htmlspecialchars($tmbh["wrn"]);
	$ukuran =htmlspecialchars($tmbh["sz"]);
	$berat =htmlspecialchars($tmbh["brt"]);
    $stok =htmlspecialchars($tmbh["stk"]);
    $dsk =htmlspecialchars($tmbh["dsk"]);  

	$query = "INSERT INTO produk
            VALUES
            ('',
            '$nmprd',
            '$foto',
            '$harga',
            '$dsk',
            '$stok',
            '$warna',
            '$ukuran',
            '$berat',
            '$kategori')
            ";
    
    mysqli_query($conn,$query);
    return mysqli_affected_rows($conn); 
   }

   //b.uploud
   function uploud(){
  $nm = $_FILES['ft']['name'];
  $ukrn=$_FILES['ft']['size'];
  $error=$_FILES['ft']['error'];
  $tmp=$_FILES['ft']['tmp_name'];
 
  //cek gmbr
  if ($error === 4) {
      echo("<script>
            alert('pilih Gambar terlebih dahulu');
            </script>");
      return false;
  }
  
  // cek file diuploud
  
  $ektensiv=['jpg','jpeg','png'];
  $ektensi= explode('.', $nm);
  $ektensi=strtolower(end($ektensi));
  if ( !in_array($ektensi,$ektensiv ) ){
        echo("<script>
            alert('Yang anda uploud bukan gambar!');
            </script>");
      return false; 
  }
  //ukuran terlalu besar
  
  if ($ukrn > 100000000) {
     echo("<script>
            alert('ukuran gambar terlalu besar!');
            </script>");
      return false; 
    
  }
  //lolos pengecekan
  //generate nama baru
  $nmfile =  uniqid();
  $nmfile .='.';
  $nmfile .=$ektensi;


  move_uploaded_file($tmp, '../img/produk/' . $nmfile);
  return $nmfile;

}	

	//c.hapus
	function hps($id){
	global $conn;

	$query = mysqli_query($conn,"DELETE FROM produk WHERE id_produk =$id");

	//mengembalikan tmbh koneksi
	return mysqli_affected_rows($conn);
	}

	//d.cari
	function cari($keywoard){

	//memilih data dari db yg sama dengan $KEYWOARD
		$query ="SELECT * FROM produk WHERE
	             nama_produk LIKE'%$keywoard%' OR
	             kategori LIKE'%$keywoard%'
	             ";
	//mengemebalikan nilai fungsi query yag ada $query pencariaan
	 return query($query);
	}

	//e.edit
	function edit($data){
	   global $conn;
	//pengamanan input htmlspecialchars()

	    $id = $data["id"];
	    $nmprd = htmlspecialchars($data["prd"]);
	    $harga =str_replace(".","",htmlspecialchars($data["hrg"]));
	    $kategori = $data["ktg"]; 
	    $gmbrlm = $data["gmbrlm"];
	  	$warna =htmlspecialchars($data["wrn"]);
	  	$ukuran =htmlspecialchars($data["sz"]);
	  	$berat =htmlspecialchars($data["brt"]);
	    $stok =htmlspecialchars($data["stk"]);
	    $dsk =htmlspecialchars($data["dsk"]); 
	   
	    //cek user add new pic

	    if ($_FILES['ft']['error'] === 4) {
	        $foto = $gmbrlm;
	    }else{
	        $foto= uploud();
	    }
	   
	    $query = "UPDATE produk SET
	            nama_produk = '$nmprd',
	            foto_produk = '$foto',
	            harga ='$harga',
	            deskripsi_produk = '$dsk',
	            stok = '$stok',
	            warna = '$warna',
	            ukuran = '$ukuran',
	            berat = '$berat',
	            kategori = '$kategori'
	            WHERE id_produk = $id
	            ";
	    mysqli_query($conn,$query);
	    
	    return mysqli_affected_rows($conn);
	 }   

//2.informasi
 	//a.tambah
 	function tambah2($tmbh){
    global $conn;
    $nama_menu = htmlspecialchars($tmbh["nama_menu"]);
    $body = htmlspecialchars($tmbh["body"]);
    $posisi =htmlspecialchars($tmbh["posisi"]);
    $status =htmlspecialchars($tmbh["status"]);
    

  $query = "INSERT INTO informasi
            VALUES
            ('',
            '$nama_menu',
            '$body',
            '$posisi',
            '$status')
            ";
    
    mysqli_query($conn,$query);
    return mysqli_affected_rows($conn); 
   }

   //b.cari
   function cari2($keywoard){

//memilih data dari db yg sama dengan $KEYWOARD
  $query ="SELECT * FROM informasi WHERE
             nama_menu LIKE'%$keywoard%' OR
             posisi_informasi LIKE'%$keywoard%' OR
             status_informasi LIKE'%$keywoard%'
             ";
//mengemebalikan nilai fungsi query yag ada $query pencariaan
 return query($query);
}
	
	//c.hapus
	function hps2($id){
	global $conn;

	$query = mysqli_query($conn,"DELETE FROM informasi WHERE id_informasi =$id");
	//mengembalikan tmbh koneksi
 return mysqli_affected_rows($conn);
}
 

	//d.edit
	function edit2($data){
    global $conn;
    $id =$data["id"];
    $nama_menu = htmlspecialchars($data["nama_menu"]);
    $body = htmlspecialchars($data["body"]);
    $posisi =htmlspecialchars($data["posisi"]);
    $status =htmlspecialchars($data["status"]);
    

  $query = "UPDATE informasi
            SET
            nama_menu = '$nama_menu',
            body_informasi= '$body',
            posisi_informasi = '$posisi',
            status_informasi = '$status'
            WHERE id_informasi = $id
            ";
    
    mysqli_query($conn,$query);
    return mysqli_affected_rows($conn); 
   }

//3.sosmed

    //a.tambah
   function tambah3($tmbh){
    global $conn;
    $nama_sosmed = htmlspecialchars($tmbh["sosmed"]);
    $logo = uploud2();
    if (!$logo ) {
         return false;
     }  
    $link =htmlspecialchars($tmbh["link"]);
    
    

  $query = "INSERT INTO sosmed
            VALUES
            ('',
            '$nama_sosmed',
            '$logo',
            '$link')
            ";
    
    mysqli_query($conn,$query);
    return mysqli_affected_rows($conn); 
   }

   //b.uploud
   function uploud2(){
  $nm = $_FILES['logo']['name'];
  $ukrn=$_FILES['logo']['size'];
  $error=$_FILES['logo']['error'];
  $tmp=$_FILES['logo']['tmp_name'];
 
  //cek gmbr
  if ($error === 4) {
      echo("<script>
            alert('pilih Gambar terlebih dahulu');
            </script>");
      return false;
  }
  
  // cek file diuploud
  
  $ektensiv=['jpg','jpeg','png'];
  $ektensi= explode('.', $nm);
  $ektensi=strtolower(end($ektensi));
  if ( !in_array($ektensi,$ektensiv ) ){
        echo("<script>
            alert('Yang anda uploud bukan gambar!');
            </script>");
      return false; 
  }
  //ukuran terlalu besar
  
  if ($ukrn > 100000000) {
     echo("<script>
            alert('ukuran gambar terlalu besar!');
            </script>");
      return false; 
    
  }
  //lolos pengecekan
  //generate nama baru
  $nmfile =  uniqid();
  $nmfile .='.';
  $nmfile .=$ektensi;


  move_uploaded_file($tmp, '../img/logo/' . $nmfile);
  return $nmfile;

} 

	//c.hapus
	function hapus3($id){
	global $conn;

	$query = mysqli_query($conn,"DELETE FROM sosmed WHERE id_sosmed =$id");
	  
	 
	//mengembalikan tmbh koneksi
	return mysqli_affected_rows($conn);
	
	}

	//d.cari
	function cari3($keywoard){

	//memilih data dari db yg sama dengan $KEYWOARD
	  $query ="SELECT * FROM sosmed WHERE
	             nama_sosmed LIKE'%$keywoard%'
	             ";
	//mengemebalikan nilai fungsi query yag ada $query pencariaan
	 return query($query);
	}

	//e.edit
   function edit3($data){
   global $conn;
//pengamanan input htmlspecialchars()

    $id = $data["id"];
    $nama_sosmed = htmlspecialchars($data["sosmed"]);
    $lglm = htmlspecialchars($data["lglm"]);
    $link =htmlspecialchars($data["link"]);
    
    if ($_FILES['logo']['error'] === 4) {
        $logo = $lglm;
    }else{
        $logo = uploud2();
    }

  $query = "UPDATE sosmed
            SET
            
            nama_sosmed = '$nama_sosmed',
            logo_sosmed = '$logo',
            link_sosmed = '$link'
            WHERE id_sosmed = $id
            ";
    
    mysqli_query($conn,$query);
    return mysqli_affected_rows($conn); 
 }   
 
//4.news

 	//a.tambah
 	function tambah4($tmbh){
    
    global $conn;
    $judul_news = htmlspecialchars($tmbh["judul_news"]);
    $foto_news = uploud3();
    if (!$foto_news ) {
         return false;
     }  
    $deskripsi_news = $tmbh["deskripsi_news"];
	$isi_news =htmlspecialchars($tmbh["isi_news"]);
	
	$query = "INSERT INTO news
            VALUES
            ('',
            '$judul_news',
            '$foto_news',
            '$deskripsi_news',
            '$isi_news')
            ";
    
    mysqli_query($conn,$query);
    return mysqli_affected_rows($conn); 
   }

 	//b.uploud
   function uploud3(){
  $nm = $_FILES['ft']['name'];
  $ukrn=$_FILES['ft']['size'];
  $error=$_FILES['ft']['error'];
  $tmp=$_FILES['ft']['tmp_name'];
 
  //cek gmbr
  if ($error === 4) {
      echo("<script>
            alert('pilih Gambar terlebih dahulu');
            </script>");
      return false;
  }
  
  // cek file diuploud
  
  $ektensiv=['jpg','jpeg','png'];
  $ektensi= explode('.', $nm);
  $ektensi=strtolower(end($ektensi));
  if ( !in_array($ektensi,$ektensiv ) ){
        echo("<script>
            alert('Yang anda uploud bukan gambar!');
            </script>");
      return false; 
  }
  //ukuran terlalu besar
  
  if ($ukrn > 100000000) {
     echo("<script>
            alert('ukuran gambar terlalu besar!');
            </script>");
      return false; 
    
  }
  //lolos pengecekan
  //generate nama baru
  $nmfile =  uniqid();
  $nmfile .='.';
  $nmfile .=$ektensi;


  move_uploaded_file($tmp, '../img/news/' . $nmfile);
  return $nmfile;

} 

	//c.hapus
	function hapus4($id){
	global $conn;

	$query = mysqli_query($conn,"DELETE FROM news WHERE id_news =$id");
	  
	 
	//mengembalikan tmbh koneksi
	return mysqli_affected_rows($conn);
	
	}
 	//d.cari
	function cari4($keywoard){

	//memilih data dari db yg sama dengan $KEYWOARD
	  $query ="SELECT * FROM news WHERE
	             judul_news LIKE'%$keywoard%'
	             ";
	//mengemebalikan nilai fungsi query yag ada $query pencariaan
	 return query($query);
	}

 	//e.edit
 	function edit4($data){
	   global $conn;
	//pengamanan input htmlspecialchars()

	    $id = $data["id"];
	    $judul_news = htmlspecialchars($data["judul_news"]);
	    $gmbrlm = $data["gmbrlm"];
	    $deskripsi_news = $data["deskripsi_news"];
		  $isi_news =htmlspecialchars($data["isi_news"]); 
		   
	    //cek user add new pic

	    if ($_FILES['ft']['error'] === 4) {
	        $foto_news = $gmbrlm;
	    }else{
	        $foto_news = uploud3();
	    }
	   
	    $query = "UPDATE news SET
	            judul_news = '$judul_news',
	            foto_news = '$foto_news',
	            deskripsi_news = '$deskripsi_news',
	            isi_news = '$isi_news'
	            WHERE id_news = $id
	            ";
	    mysqli_query($conn,$query);
	    
	    return mysqli_affected_rows($conn);
	 }   





//============================================================================//
//**Rahma**//
//1.dashboard
//2.pesanan
//3.ganti-password
//4.upload-video
//5.pembayaran
//============================================================================//

//1.Langsung Dihalaman index.php
//2.pesanan

 	//output
function pesanan($result){
        global $conn;
        $result = mysqli_query($conn, $result);
        $rows = [];
        while ($row = mysqli_fetch_array($result) ) {
            $rows[] = $row;
        }   
            return $rows;
    }

 function detail($data){
        global $conn;
        $data = mysqli_query($conn, $data);
        $rows = [];
        while ($row = mysqli_fetch_array($data)) {
            $rows[] = $row;
        }
        return $rows;
    }

    function tampil($data){
        global $conn;
        $data = mysqli_query($conn, $data);
        $pesan = [];
        while ($pesanan = mysqli_fetch_array($data)) {
            $pesan[] = $pesanan;
        }
        return $pesan;
    }

    //hapus pembayaran
    function hpsbukti($id){
    global $conn;

    $query = mysqli_query($conn,"DELETE FROM pembayaran WHERE id_pembayaran = $id");
    //mengembalikan tmbh koneksi
 return mysqli_affected_rows($conn);    
}

    //search pembayaran
  function bayar($keywoard){

  //memilih data dari db yg sama dengan $KEYWOARD
    $query ="SELECT * FROM pembayaran WHERE
               nama_pentransfer LIKE'%$keywoard%' OR
               no_rekening LIKE'%$keywoard%' OR
               nama_bank LIKE'%$keywoard%' OR
               status_pembayaran LIKE'%$keywoard%' OR
               bukti_pembayaran LIKE'%$keywoard%'
               ";
  //mengemebalikan nilai fungsi query yag ada $query pencariaan
   return query($query);
  }

//============================================================================//
//**Rivandy**//
//1.kontak
//2.slideshow
//3.pelanggan
//============================================================================//

    //1.kontak
    function editkontak($data) {
    global $conn;
     // ambil data dari tiap elemen dalam form
  $alamat_kontak = $data['alamat_kontak'];
  $no_hp_admin = $data['no_hp_admin'];

   // query insert data
  $query = "UPDATE kontak SET
                alamat_kontak ='$alamat_kontak', 
                no_hp_admin ='$no_hp_admin'
                WHERE id_kontak = 1; 
                ";
  mysqli_query($conn, $query);
  return mysqli_affected_rows($conn);
   }

//2.slideshow

   //a.tambah slideshow
function uploudslide(){
  $nm = $_FILES['ft']['name'];
  $ukrn=$_FILES['ft']['size'];
  $error=$_FILES['ft']['error'];
  $tmp=$_FILES['ft']['tmp_name'];
 
  //cek gmbr
  if ($error === 4) {
      echo("<script>
            alert('pilih Gambar terlebih dahulu');
            </script>");
      return false;
  }
  
  // cek file diuploud
  
  $ektensiv=['jpg','jpeg','png'];
  $ektensi= explode('.', $nm);
  $ektensi=strtolower(end($ektensi));
  if ( !in_array($ektensi,$ektensiv ) ){
        echo("<script>
            alert('Yang anda uploud bukan gambar!');
            </script>");
      return false; 
  }
  //ukuran terlalu besar
  
  if ($ukrn > 100000000) {
     echo("<script>
            alert('ukuran gambar terlalu besar!');
            </script>");
      return false; 
    
  }
  //lolos pengecekan
  //generate nama baru
  $nmfile =  uniqid();
  $nmfile .='.';
  $nmfile .=$ektensi;


  move_uploaded_file($tmp, '../img/slideshow/' . $nmfile);
  return $nmfile;

}   

function slideshow($tmbh){
    
    global $conn;
    $nama_slideshow = htmlspecialchars($tmbh["nama_slideshow"]);
    $foto_slideshow = uploudslide();
    if (!$foto_slideshow ) {
         return false;
     }  

    $query = "INSERT INTO slideshow
            VALUES
            ('', '$nama_slideshow', '$foto_slideshow')
            ";
    
    mysqli_query($conn,$query);
    return mysqli_affected_rows($conn); 
   }
 
 function hpsslide($id){
    global $conn;

$query = mysqli_query($conn,"DELETE FROM slideshow WHERE id_slideshow =$id");

//mengembalikan tmbh koneksi
return mysqli_affected_rows($conn);
}

//3.pelanggan

// pelanggan
   function output($users){
        global $conn;
        $result = mysqli_query($conn, $users);
        $rows = [];
        while ($row = mysqli_fetch_array($result)) {
            $rows[] = $row;
        }
        return $rows;
    }

 // tambah data pelanggan
   function tambahpelanggan($data) {
    global $conn;
     // ambil data dari tiap elemen dalam form
  $f_name = $data['f_name'];
  $l_name = $data['l_name'];
  $email = $data['email'];
  $username = $data['username'];
  $password = $data['password'];
  $kota = $data['kota'];
  $negara = $data['negara']; 
  $alamat2 = $data['alamat'];
  $alamat1 = $alamat2." ".$kota." ".$negara;
  $kode_pos = $data['kode_pos'];
 
  $nohp = $data['nohp'];

   // query insert data
  $query = "INSERT INTO pelanggan
                VALUES
                ('', '$f_name', '$l_name', '$username', '$email', '$nohp', '$password', '$alamat1', '$kode_pos')
                ";
  mysqli_query($conn, $query);
  return mysqli_affected_rows($conn);
   }
   //cari pelanggan
  function cariuser($keywoard){

  //memilih data dari db yg sama dengan $KEYWOARD
    $query ="SELECT * FROM pelanggan WHERE
               username LIKE'%$keywoard%' OR
               email LIKE'%$keywoard%' OR
               nohp LIKE'%$keywoard%'
               ";
  //mengemebalikan nilai fungsi query yag ada $query pencariaan
   return query($query);
  }

  //FOTO
  
  function uploudfoto(){
  $nm = $_FILES['ft']['name'];
  $ukrn=$_FILES['ft']['size'];
  $error=$_FILES['ft']['error'];
  $tmp=$_FILES['ft']['tmp_name'];
 
  //cek gmbr
  if ($error === 4) {
      echo("<script>
            alert('pilih Gambar terlebih dahulu');
            </script>");
      return false;
  }
  
  // cek file diuploud
  
  $ektensiv=['jpg','jpeg','png'];
  $ektensi= explode('.', $nm);
  $ektensi=strtolower(end($ektensi));
  if ( !in_array($ektensi,$ektensiv ) ){
        echo("<script>
            alert('Yang anda uploud bukan gambar!');
            </script>");
      return false; 
  }
  //ukuran terlalu besar
  
  if ($ukrn > 100000000) {
     echo("<script>
            alert('ukuran gambar terlalu besar!');
            </script>");
      return false; 
    
  }
  //lolos pengecekan
  //generate nama baru
  $nmfile =  uniqid();
  $nmfile .='.';
  $nmfile .=$ektensi;


  move_uploaded_file($tmp, '../img/fotogalery/' . $nmfile);
  return $nmfile;

} 

  //1.Tambah Foto
  function tambahfoto($tmbh){
     global $conn;
    $desk = htmlspecialchars($tmbh["desk"]);
    $foto = uploudfoto();
    if (!$foto ) {
         return false;
     }

  $query = "INSERT INTO foto
            VALUES
            ('',
            '$foto',
            '$desk'
            )
            ";
    
    mysqli_query($conn,$query);
    return mysqli_affected_rows($conn); 

  }
  //2.hapus foto
  function hapusfoto($id){
    global $conn;

$query = mysqli_query($conn,"DELETE FROM foto WHERE id_foto =$id");

//mengembalikan tmbh koneksi
return mysqli_affected_rows($conn);
}

//VIDIO
  //1.Tambah Vidio
 function uploadvidio($data){
  global $conn;

  $link = $data["link_vidio"];

  $insert ="INSERT INTO vidio VALUES ('', '$link') ";
  mysqli_query($conn, $insert);
  return mysqli_affected_rows($conn);
 }
  //2.Hapus Vidio
   function hpsvidio($id){
    global $conn;

$query = mysqli_query($conn,"DELETE FROM vidio WHERE id_vidio =$id");

//mengembalikan tmbh koneksi
return mysqli_affected_rows($conn);
}

  //bankwire
   //1.tambah
    function bank($data){
        global $conn;
        $nama_bank = htmlspecialchars($data["nama_bank"]);
        $nama_akun = htmlspecialchars($data["nama_akun"]);
        $no_rekening = htmlspecialchars($data["no_rekening"]);

        //query data 
        $insert = "INSERT INTO bankwire VALUES('', '$nama_bank', '$nama_akun', '$no_rekening') ";

        mysqli_query($conn, $insert);
        return mysqli_affected_rows($conn);
    }
  //2.edit
    function ebank($data, $id){
    global $conn;
    // var_dump($data); die();
    $id = $id;
    $nama_bank = htmlspecialchars($data["nama_bank"]);
    $nama_akun = htmlspecialchars($data["nama_akun"]);
    $no_rekening =htmlspecialchars($data["no_rekening"]);
    

  $query = "UPDATE bankwire SET
            nama_bank = '$nama_bank',
            nama_akun= '$nama_akun',
            no_rekening = '$no_rekening'
            WHERE id_bank = $id";

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn); 
   }
  //3.cari
   function search($search){
        $query = "SELECT * FROM bankwire
                    WHERE 
                    nama_bank LIKE '%$search%' OR
                    nama_akun LIKE '%$search%' OR
                    no_rekening LIKE '%$search%'
                ";
                return query($query);
    }


  //4.hapus
    function hbank($id){
    global $conn;
    $query = mysqli_query($conn,"DELETE FROM bankwire WHERE id_bank =$id");
    //mengembalikan tmbh koneksi
    return mysqli_affected_rows($conn);
    }
 ?>	