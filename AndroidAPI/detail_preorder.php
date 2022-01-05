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

$id_trx = $_POST["id_preorder"];

$query_insert = "SELECT * FROM preorder WHERE id_preorder = '$id_trx'";
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
           $id_preorder = $rows['id_preorder'];
           $tgl = $rows['tgl_preorder'];
           $id_user = $rows['id_user'];
           $penerima = $rows['penerima'];
           $alamat = $rows['alamat'];
           $no_telp = $rows['no_telp'];
           $id_ongkir = $rows['id_ongkir'];
           $total = $rows['total_preorder'];
           $status = $rows['status'];

           $response = array('pesan'=>$pesan, 'id_preorder' => $id_preorder, 'tgl_preorder' => $tgl, 'id_user' => $id_user, 'penerima' => $penerima, 'alamat' => $alamat, 
           'no_telp' => $no_telp, 'id_ongkir'=> $id_ongkir,'total_preorder'=>$total, 'status'=> $status );
    
} else {
    $response = array('pesan'=>'TIDAK ADA');
}
}
echo json_encode($response);
mysqli_close($conn);

?>