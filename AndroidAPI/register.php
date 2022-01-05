<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        include 'config.php';
        
        //read JSON from client
        // $json = file_get_contents('php://input', true);
        // $obj = json_decode($json);

        //get JSON object
        $fullname = $_POST['fullname'];
        $username = $_POST['username'];
        $no_telp = $_POST['no_telp'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        // cek email
        $query_check = "SELECT * FROM users WHERE email = '$email'";
        $check_email = mysqli_fetch_array(mysqli_query($conn, $query_check));  

        $query_check = "SELECT * FROM users WHERE username = '$username'";
        $check_username = mysqli_fetch_array(mysqli_query($conn, $query_check));    
        
        // cek no_telp
        $query_check = "SELECT * FROM users WHERE no_telp = '$no_telp'";
        $check_no_telp = mysqli_fetch_array(mysqli_query($conn, $query_check));

        $json_array = array();
        $response = "";

        if (isset($check_username)) {
            $response = array(
                'kode' => 404,
                'pesan' => 'Username terdaftar'
            );
        } else if (isset($check_email)) {
            $response = array(
                'kode' => 404,
                'pesan' => 'Email terdaftar'
            );
        } else if (isset($check_no_telp)) {
            $response = array(
                'kode' => 404,
                'pesan' => 'Nomor telepon terdaftar'
            );
        } else {
            $encryptedPassword = password_hash($password, PASSWORD_DEFAULT);
            $query_insert = "INSERT INTO users (fullname, username, email, no_telp, password, foto_profil) VALUES('$fullname', '$username', '$email', '$no_telp', '$encryptedPassword', 'default_user.png')";
            if (mysqli_query($conn, $query_insert)) {
                $response = array(
                    'kode' => 201,
                    'pesan' => 'Daftar berhasil!'
                );
            } else {
                $response = array(
                    'kode' => 405,
                    'pesan' => 'Daftar gagal!'
                );
            }
        }

        print(json_encode($response));
        mysqli_close($conn);
    }
?>