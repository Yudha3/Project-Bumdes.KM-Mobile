<?php 

if($_SERVER['REQUEST_METHOD'] == 'POST') {
  require 'config.php';
  $id_user = $_POST['id_user'];
  $password = $_POST['password'];

  if ($conn) {
    $queryGET = mysqli_query($conn, "SELECT * FROM users WHERE id_user = '$id_user'");
    $row = mysqli_fetch_assoc($queryGET);
    if (password_verify($password, $row['password'])){
      $response = array('pesan'=>'BENAR');
    } else{
      $response = array("pesan"=>'WRONG');
    }
  } else {
    $response = array('pesan' => 'NOT CONNECTED');
  }
  mysqli_close($conn);
  echo json_encode($response);
} 

?>