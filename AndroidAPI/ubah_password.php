<?php 

if($_SERVER['REQUEST_METHOD'] == 'POST') {
  require 'config.php';
  $id_user = $_POST['id_user'];
  $passwordLama = $_POST['old_password'];
  $passwordBaru = $_POST['new_password'];

  if ($conn) {
    $queryCek = mysqli_query($conn, "SELECT * FROM users WHERE id_user = '$id_user'");
    $rows = mysqli_fetch_assoc($queryCek);
    if (password_verify($passwordLama, $rows['password'])) {
      $encryptedPassword = password_hash($passwordBaru, PASSWORD_DEFAULT);
      mysqli_query($conn, "UPDATE users SET password = '$encryptedPassword' WHERE id_user = '$id_user'");
      if (mysqli_affected_rows($conn) > 0) {
        $response = array('pesan' => 'BERHASIL');
      } else {
        $response = array('pesan' => 'GAGAL');
      }
    } else {
      $response = array('pesan' => 'WRONG');
    }
    
  } else {
    $response = array('pesan' => 'NOT CONNECTED');
  }
  mysqli_close($conn);
  echo json_encode($response);
} 

?>