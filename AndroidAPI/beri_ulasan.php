<?php 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  require 'config.php';
  $id_transaksi = $_POST['id_transaksi'];
  $id_user = $_POST['id_user'];
  $ulasan = $_POST['ulasan'];

  if ($conn) {
    mysqli_query($conn, "INSERT INTO ulasan VALUES ('', '$id_transaksi', '$id_user', '$ulasan')");
    if (mysqli_affected_rows($conn) > 0) {
      $response = array('pesan' => 'BERHASIL');
    } else {
    $response = array('pesan' => 'BERHASIL');
    }
  } else {
    $response = array('pesan' => 'NOT CONNECTED');
  }
  mysqli_close($conn);
  echo json_encode($response);
}
?>