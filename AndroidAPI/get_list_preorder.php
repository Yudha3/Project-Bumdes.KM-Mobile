<?php 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  require 'config.php';

  if ($conn) {
    $id_user = $_POST['id_user'];

    $queryGET = mysqli_query($conn, "SELECT * FROM preorder WHERE id_user = '$id_user' ORDER BY id_preorder DESC");
    
    if (mysqli_num_rows($queryGET) > 0) {
      $response["kode"] = 1;
      $response["pesan"] = "Data tersedia";
      $response["data"] = array();

      while($ambil = mysqli_fetch_object($queryGET)){
        $F["id_preorder"] = $ambil->id_preorder;
        $F["tgl_preorder"] = $ambil->tgl_preorder;
        $F["id_user"] = $ambil->id_user;
        $F["penerima"] = $ambil->penerima;
        $F["alamat"] = $ambil->alamat;
        $F["no_telp"] = $ambil->no_telp;
        $F["total_preorder"] = $ambil->total_preorder;
        $F["status"] = $ambil->status;
        $idt = $F['id_preorder'];
        $qy = $conn->query("SELECT id_brg FROM item_preorder WHERE id_preorder = '$idt' ORDER BY id_item_preorder DESC LIMIT 1");
        $getidb = mysqli_fetch_assoc($qy);
        $idb = $getidb['id_brg'];
        $queryX = $conn->query("SELECT gambar FROM data_brg WHERE id_brg = '$idb'");
        $getGambar = mysqli_fetch_assoc($queryX); 
        // while($getX = mysqli_fetch_assoc($qy)) {
        //     $F['harga'] = $getX['hg_jual'];
        //     $F['gambar'] = $getX['gambar'];
        // }
        $F['gambar'] = $getGambar['gambar'];
        
        array_push($response["data"], $F);
      }
    } else {
      $response["kode"] = 0;
      $response["pesan"] = "Data tidak tersedia";
    }

  } else {
    $response["kode"] = 404;
    $response["pesan"] = "Not Connected";
  }
  echo json_encode($response);
  mysqli_close($conn);
}
?>