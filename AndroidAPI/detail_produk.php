<?php

// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
// require "config.php";

// $id_brg = $_POST["id_brg"];

// $query_insert = "SELECT * FROM data_brg WHERE id_brg = $id_brg";
// $result = mysqli_query($conn, $query_insert);
// $cek = mysqli_affected_rows($conn);

// if ($cek > 0){
//     $response["kode"] = 1;
//     $response["pesan"] = "Data tersedia";
//     $response["data"] = array();

//     while($ambil = mysqli_fetch_object($result)){
//         $F["id_brg"] = $ambil->id_brg;
//         $F["barang"] = $ambil->barang;
//         $F["hg_jual"] = $ambil->hg_jual;
//         $F["jml_stok"] = $ambil->jml_stok;
//         $F["gambar"] = $ambil->gambar;
//         $F["deskripsi"] = $ambil->deskripsi;
        
//         array_push($response["data"], $F);
//     }
    
// } else {
//     $response["kode"] = 0;
//     $response["pesan"] = "Data tidak tersedia";
// }
// }
// echo json_encode($response);
// mysqli_close($conn);


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
require("config.php");

$id_brg = $_POST["id_brg"];

$query_insert = "SELECT * FROM data_brg WHERE id_brg = '$id_brg'";
$result = mysqli_query($conn, $query_insert);
$cek = mysqli_num_rows($result);

if ($cek > 0){
    // $response["kode"] = 1;
    // $response["pesan"] = "Data tersedia";
    // $response["data"] = array();

    // while($ambil = mysqli_fetch_object($result)){
    //     $F["id_brg"] = $ambil->id_brg;
    //     $F["barang"] = $ambil->barang;
    //     $F["hg_jual"] = $ambil->hg_jual;
    //     $F["jml_stok"] = $ambil->jml_stok;
    //     $F["gambar"] = $ambil->gambar;
    //     $F["deskripsi"] = $ambil->deskripsi;
        
    //     array_push($response["data"], $F);
    // }
    
    $rows = mysqli_fetch_assoc($result);
         $pesan = "BERHASIL";
           $id_brg = $rows['id_brg'];
           $barang = $rows['barang'];
           $harga = $rows['hg_jual'];
           $stok = $rows['jml_stok'];
           $deskripsi = $rows['deskripsi'];
           $gambar = $rows['gambar'];
           $jml_terjual = $rows['jml_terjual'];

           $response = array('pesan'=>$pesan, 'id_brg' => $id_brg, 'barang' => $barang, 'harga' => $harga, 'stok' => $stok, 'deskripsi' => $deskripsi, 'gambar' => $gambar, 'jml_terjual' => $jml_terjual);
    
} else {
    $response = array('pesan'=>'TIDAK ADA');
}
}
echo json_encode($response);
mysqli_close($conn);

?>