<?php 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  require 'config.php';
  $id_trx = $_POST['id_preorder'];

  if ($conn) {
    mysqli_query($conn, "DELETE FROM item_preorder WHERE id_preorder = '$id_trx'");
    mysqli_query($conn, "DELETE FROM preorder WHERE id_preorder = '$id_trx' ");
    if (mysqli_affected_rows($conn) > 0){
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