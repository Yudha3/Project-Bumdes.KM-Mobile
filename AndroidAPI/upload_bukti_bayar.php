<?php 
// if ($_SERVER["REQUEST_METHOD"] == 'POST') {
//   require 'config.php';
//   $id_transaksi = $_POST['id_transaksi'];

//   if ($_FILES['gambar']) {
//     $namaFile = $_FILES['gambar']['name'];
//     $error = $_FILES['gambar']['error'];
//     $ukuranFile = $_FILES['gambar']['size'];
//     $tmpFile = $_FILES['gambar']['tmp_name'];

//     $ekstensiFileValid = ['jpg', 'jpeg', 'png'];
//     $ekstensiFile = explode('.', $namaFile);
//     $ekstensiFile = strtolower(end($ekstensiFile));
//     if ( $error === 4) {
//       $response = array('pesan' => 'EKSTENSI SALAH');
//       echo json_encode($response);
//       exit;
//     } 
//     if (!in_array($ekstensiFile, $ekstensiFileValid)) {
//       $response = array('pesan' => 'EKSTENSI SALAH');
//       echo json_encode($response);
//       exit;
//     } 
//       $namaFileBaru = uniqid();
//       $namaFileBaru .= '.';
//       $namaFileBaru .= $ekstensiFile;

//       move_uploaded_file($tmpFile, "../img/pembayaran/" . $namaFileBaru);

//       mysqli_query($conn, "UPDATE transaksi SET bukti_tf = '$namaFileBaru' WHERE id_transaksi = '$id_transaksi' ");
//       if (mysqli_affected_rows($conn)) {
//         $response = array('pesan' => 'BERHASIL');
//       } else {
//         $response = array('pesan' => 'GAGAL');
//       }

//       echo json_encode($response);
//   }
// }
// mysqli_close($conn);

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
  require "config.php";
  if ($conn) {

    $encoded_file = $_POST["EN_IMAGE"];
    $id_transaksi = $_POST["id_transaksi"];

    $filename = uniqid().".jpeg";

    $queryUPDATE = mysqli_query($conn, "UPDATE transaksi SET bukti_tf = '$filename', status = 'Dibayar' WHERE id_transaksi = '$id_transaksi' ");

    if ($queryUPDATE) {
      file_put_contents("../images/pembayaran/".$filename, base64_decode($encoded_file));

      $response = array('pesan' => 'BERHASIL');
    } else {
      $response = array('pesan' => 'GAGAL');
    } 

  } else {
    $response = array('pesan' => 'NOT CONNECTED');
  }
  mysqli_close($conn);
  echo json_encode($response);
}
?>