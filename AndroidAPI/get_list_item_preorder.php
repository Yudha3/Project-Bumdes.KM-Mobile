<?php 
if ($_SERVER["REQUEST_METHOD"] == 'POST') {
  require 'config.php';

  if ($conn) {
    $id_po = $_POST['id_preorder'];
    // $id_transaksi = 13;
    $queryGET = mysqli_query($conn, "SELECT * FROM item_preorder WHERE id_preorder = '$id_po'");
    if (mysqli_num_rows($queryGET) > 0) {
      $response['pesan'] = "Data tersedia";
      $response['item_preorder'] = array();

      while ($ambil = mysqli_fetch_object($queryGET)) {
        $F['id_item_preorder'] = $ambil->id_item_preorder;
        $F['id_brg'] = $ambil->id_brg;
        $F['qty'] = $ambil->qty;
        $F['subtotal'] = $ambil->subtotal;
        $idb = $F['id_brg'];
        $queryA = mysqli_query($conn, "SELECT id_brg FROM data_brg WHERE id_brg = '$idb' ");
        while ($getID = mysqli_fetch_assoc($queryA)) {
          $id_brg = $getID['id_brg'];
          $queryB = mysqli_query($conn, "SELECT barang, hg_jual, gambar FROM data_brg WHERE id_brg = '$id_brg'");
          while($getData = mysqli_fetch_assoc($queryB)) {
            $F['barang'] = $getData['barang'];
            $F['harga'] = $getData['hg_jual'];
            $F['gambar'] = $getData['gambar'];
          } 
        }
        array_push($response["item_preorder"], $F);
      }

    } else {
      $response['pesan'] = "Data tidak tersedia";
    } 
  } else {
    $response['pesan'] = "Not Connected";
  }
  echo json_encode($response);
  mysqli_close($conn);
}
?>