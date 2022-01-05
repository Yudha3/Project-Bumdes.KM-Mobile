<?php 
require 'config.php';
$no = mysqli_query($conn, "select id_transaksi from transaksi order by id_transaksi desc limit 1");
    $idtran = mysqli_fetch_array($no);
    $kode = isset($idtran['id_transaksi']) ? $idtran['id_transaksi'] : '';
// // $kode = $idtran['id_transaksi'];

//     $urut = substr($kode, 8, 3);
//     $tambah = (int) $urut + 1;
//     $bulan = date("m");
//     $tahun = date("y");
//     $day = date("d");

//     if (strlen($tambah) == 1) {
//         $format = "TRK-" . $bulan . $tahun . "00" . $tambah;
//     } else if (strlen($tambah) == 2) {
//         $format = "TRK-" . $bulan . $tahun . "0" . $tambah;
//     } else {
//         $format = "TRK-" . $bulan . $tahun . $tambah;
//     }
    $urut = substr($kode, -1);
    $tambah = intval($urut) + 1;
    $bulan = date("m");
    $tahun = date("Y");
    $day = date("d");

    $xx = $tahun . "0" . $tambah;
    $format = (int) $xx;

    var_dump($format); die;
?>