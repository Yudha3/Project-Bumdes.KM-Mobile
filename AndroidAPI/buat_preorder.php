<?php 

// if ($_SERVER['REQUEST_METHOD'] == 'POST' ) {
//     require 'config.php';

//     $id_user = $_POST['id_user'];
//     $alamat = $_POST['alamat'];
//     $penerima = $_POST['penerima'];
//     $no_telp = $_POST['no_telp'];
//     $id_ongkir = $_POST['id_ongkir'];
//     // $tgl = date("Y-m-d H:i:s");
//     $timezone = time() + (60 * 60 * 7);
//     $date = gmdate('Y-m-d H:i:s', $timezone);
//     // $date = date("Y-m-d H:i:s");
//     // $total_belanja = $_POST['total_belanja'];
    
//     $no = mysqli_query($conn, "select id_preorder from preorder order by id_preorder desc limit 1");
//     $idtran = mysqli_fetch_array($no);
//     $kode = isset($idtran['id_preorder']) ? $idtran['id_preorder'] : '';
// // $kode = $idtran['id_transaksi'];

//     $urut = substr($kode, 8, 3);
//     $tambah = intval($urut) + 1;
//     $bulan = date("m");
//     $tahun = date("y");
//     $day = date("d");

//     if (strlen($tambah) == 1) {
//         $format = "PRE-" . $bulan . $tahun . "00" . $tambah;
//     } else if (strlen($tambah) == 2) {
//         $format = "PRE-" . $bulan . $tahun . "0" . $tambah;
//     } else {
//         $format = "PRE-" . $bulan . $tahun . $tambah;
//     }
    
//     $ambilKeranjang = mysqli_query($conn, "SELECT * FROM keranjang WHERE id_user = '$id_user' AND jenis = 'PREORDER'");
//     // $getKeranjang = mysqli_fecth_assoc($ambilKeranjang);

//     $totalBelanja =0;
//     while ($getKeranjang = mysqli_fetch_assoc($ambilKeranjang)) {
//         $subtotal = $getKeranjang["subtotal"];
//         $totalBelanja += $subtotal;
//     } 

//     if ($id_ongkir == 1) {
//          $ongkir = 30000;
//     } elseif ($id_ongkir == 2) {
//         $ongkir = 48000;
//     }

//     $total_bayar = $totalBelanja + $ongkir;

//     $queryTransaksi = mysqli_query($conn, "INSERT INTO preorder (id_preorder, tgl_preorder, id_user, nama_penerima, alamat, no_telp, id_ongkir, total_preorder, status) VALUES ('$format', '$date', '$id_user', '$penerima', '$alamat', '$no_telp', '$id_ongkir', '$total_bayar', 'Menunggu Konfirmasi')");
//     $cek = mysqli_affected_rows($conn);
//     // // $current_id = $conn->insert_id;
//     // $getX = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM transaksi WHERE id_user = '$id_user' ORDER BY id_transaksi DESC LIMIT 1"));
//     // $transaksi_terakhir = $getX['id_transaksi'];

//     if ($queryTransaksi) {
//         $cariKeranjang = mysqli_query($conn, "SELECT * FROM keranjang WHERE id_user = '$id_user' AND jenis = 'PREORDER'");
//         while ($item = mysqli_fetch_assoc($cariKeranjang)) {
//             $id_barang = $item['id_barang'];
//             $qty = $item['qty'];
//             $subtotal = $item['subtotal'];

//             $insert = mysqli_query($conn, "INSERT INTO item_preorder (id_preorder, id_brg, qty, subtotal) VALUES ('$format', '$id_barang', '$qty', '$subtotal' )");
            
//              $update = mysqli_query($conn, "UPDATE data_brg SET jml_stok = jml_stok - '$qty' WHERE id_brg = '$id_barang'");
//         }

//         $delete = mysqli_query($conn, "DELETE FROM keranjang WHERE id_user = '$id_user' AND jenis ='PREORDER'");
//         $response = array('pesan'=>'BERHASIL', 'total'=>$total_bayar);
        
//     } elseif (!$queryTransaksi) {
//         $response = array('pesan'=>'GAGAL', 'total'=>$total_bayar);
//     }

// echo json_encode($response);
// mysqli_close($conn);
// }

if ($_SERVER['REQUEST_METHOD'] == 'POST' ) {
    require 'config.php';

    $id_user = $_POST['id_user'];
    $alamat = $_POST['alamat'];
    $penerima = $_POST['penerima'];
    $no_telp = $_POST['no_telp'];
    $id_ongkir = $_POST['id_ongkir'];
    $timezone = time() + (60 * 60 * 7);
    $date = gmdate('Y-m-d H:i:s', $timezone);

    $no = mysqli_query($conn, "SELECT id_preorder FROM preorder order by id_preorder desc ");
    $idtran = mysqli_fetch_array($no);
    $kode = isset($idtran['id_preorder']) ? $idtran['id_preorder'] : '';
// $kode = $idtran['id_transaksi'];

    $urut = substr($kode, 8, 3);
    $tambah = (int)$urut + 1;
    $bulan = date("m");
    $tahun = date("y");
    $day = date("d");

    if (strlen($tambah) == 1) {
        $format = "PRE-" . $bulan . $tahun . "00" . $tambah;
    } else if (strlen($tambah) == 2) {
        $format = "PRE-" . $bulan . $tahun . "0" . $tambah;
    } else {
        $format = "PRE-" . $bulan . $tahun . $tambah;
    }
    
    $ambilKeranjang = mysqli_query($conn, "SELECT * FROM keranjang WHERE id_user = '$id_user' AND jenis = 'PREORDER'");
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

    $queryTransaksi = mysqli_query($conn, "INSERT INTO preorder (id_preorder, tgl_preorder, id_user, penerima, alamat, no_telp, id_ongkir, total_preorder, status) 
        VALUES ('$format',$date', '$id_user', '$penerima', '$alamat', '$no_telp', '$id_ongkir', '$total_bayar', 'MENUNGGU PEMBAYARAN')");
    $cek = mysqli_affected_rows($conn);
    // $current_id = $conn->insert_id;
    // $getX = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM preorder WHERE id_user = '$id_user' ORDER BY id_preorder DESC LIMIT 1"));
    // $transaksi_terakhir = $getX['id_preorder'];

    if ($cek > 0) {
        $cariKeranjang = mysqli_query($conn, "SELECT * FROM keranjang WHERE id_user = '$id_user' AND jenis = 'PREORDER'");
        while ($item = mysqli_fetch_assoc($cariKeranjang)) {
            $id_barang = $item['id_barang'];
            $qty = $item['qty'];
            $subtotal = $item['subtotal'];

            $insert = mysqli_query($conn, "INSERT INTO item_preorder (id_preorder, id_brg, qty, subtotal) VALUES ('$format', '$id_barang', '$qty', '$subtotal' )");
        }

        $delete = mysqli_query($conn, "DELETE FROM keranjang WHERE id_user = '$id_user' AND jenis = 'PREORDER'");
        $response = array('pesan'=>'BERHASIL', 'total'=>$total_bayar);
        
    } else {
        $response = array('pesan'=>'GAGAL', 'total'=>$total_bayar);
    }

echo json_encode($response);
mysqli_close($conn);
}

?>