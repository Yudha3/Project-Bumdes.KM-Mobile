<?php 
if ($_SERVER['REQUEST_METHOD'] == 'POST' ) {
    require 'config.php';

    $id_user = $_POST['id_user'];
    $alamat = $_POST['alamat'];
    $penerima = $_POST['penerima'];
    $no_telp = $_POST['no_telp'];
    $id_ongkir = $_POST['id_ongkir'];
    $timezone = time() + (60 * 60 * 7);
    $date = gmdate('Y-m-d H:i:s', $timezone);

    $ambilKeranjang = mysqli_query($conn, "SELECT * FROM keranjang WHERE id_user = '$id_user' AND jenis = 'ORDER'");
    // $getKeranjang = mysqli_fecth_assoc($ambilKeranjang);
    
    
    $totalBelanja =0;
    while ($getKeranjang = mysqli_fetch_assoc($ambilKeranjang)) {
        $subtotal = $getKeranjang["subtotal"];
        $totalBelanja += $subtotal;
    } 

    if ($id_ongkir == 1) {
         $ongkir = 30000;
    } elseif ($id_ongkir == 2) {
        $ongkir = 48000;
    }

    $total_bayar = $totalBelanja + $ongkir;

    $queryTransaksi = mysqli_query($conn, "INSERT INTO transaksi ( tgl_transaksi, id_user, nama_penerima, alamat, no_telp, id_ongkir, total_transaksi, status) 
    VALUES ('$date', '$id_user', '$penerima', '$alamat', '$no_telp', '$id_ongkir', '$total_bayar', 'Menunggu Pembayaran')");
    $cek = mysqli_affected_rows($conn);
    // $current_id = $conn->insert_id;
    $getX = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM transaksi WHERE id_user = '$id_user' ORDER BY id_transaksi DESC LIMIT 1"));
    $transaksi_terakhir = $getX['id_transaksi'];

    if ($queryTransaksi) {
        $cariKeranjang = mysqli_query($conn, "SELECT * FROM keranjang WHERE id_user = '$id_user' AND jenis = 'ORDER'");
        while ($item = mysqli_fetch_assoc($cariKeranjang)) {
            $id_barang = $item['id_barang'];
            $qty = $item['qty'];
            $subtotal = $item['subtotal'];

            $insert = mysqli_query($conn, "INSERT INTO transaksi_produk (id_transaksi, id_brg, qty, subtotal) VALUES ('$transaksi_terakhir', '$id_barang', '$qty', '$subtotal' )");
            
             $update = mysqli_query($conn, "UPDATE data_brg SET jml_stok = jml_stok - '$qty' WHERE id_brg = '$id_barang'");
        }

        $delete = mysqli_query($conn, "DELETE FROM keranjang WHERE id_user = '$id_user' AND jenis = 'ORDER'");
        $response = array('pesan'=>'BERHASIL', 'total'=>$total_bayar);
        
    } elseif (!$queryTransaksi) {
        $response = array('pesan'=>'GAGAL', 'total'=>$total_bayar);
    }

echo json_encode($response);
mysqli_close($conn);
}
?>