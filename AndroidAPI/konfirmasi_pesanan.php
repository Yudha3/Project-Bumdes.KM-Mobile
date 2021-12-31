<?php 

if ($_SERVER['REQUEST_METHOD'] == 'POST' ) {
    require 'config.php';
    $id_trx = $_POST['id_transaksi'];
    if ($conn) {
        mysqli_query($conn, "UPDATE transaksi SET status = 'Selesai' WHERE id_transaksi = '$id_trx' ");
        if (mysqli_affected_rows($conn) > 0){
            $response = array('pesan'=>'BERHASIL');
        } else{
            $response = array('pesan'=>'GAGAL');
        }
    } else {
        $response = array('pesan'=>'NOT CONNECTED');
    }
echo json_encode($response);
mysqli_close($conn);
}

?>