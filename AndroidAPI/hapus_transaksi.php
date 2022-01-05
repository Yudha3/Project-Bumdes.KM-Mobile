<?php 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  require 'config.php';
  $id_trx = $_POST['id_transaksi'];

  if ($conn) {
    $findBrg = mysqli_query($conn, "SELECT * FROM transaksi_produk WHERE id_transaksi = '$id_trx'");
    while ($brg = mysqli_fetch_assoc($findBrg)) {
      $id_brg = $brg['id_brg'];
      $qty = $brg['qty'];

      mysqli_query($conn, "UPDATE data_brg SET jml_stok = jml_stok + '$qty' WHERE id_brg = '$id_brg'");
    }
    mysqli_query($conn, "DELETE FROM transaksi_produk WHERE id_transaksi = '$id_trx'");
    mysqli_query($conn, "DELETE FROM transaksi WHERE id_transaksi = '$id_trx' ");
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