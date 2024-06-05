<?php
class Auth
{
    private $conn;
    public function __construct($conn)
    {
        $this->conn = $conn;
    }



    public function login($data)
    {
        $email     = $data['email'];
        $password      = MD5($data['password']);

        $query  = "SELECT * FROM tb_users WHERE email='$email' AND password='$password'";


        $result = mysqli_query($this->conn, $query);
        $num_row     = mysqli_num_rows($result);
        $row         = mysqli_fetch_array($result);

        if ($num_row >= 1) {

            return $row['id'];
            return true;
        } else {
            return false;
        }
    }
    public function daftar($data)
    {

        $nama = $data['nama'];
        $email     = $data['email'];
        $alamat     = $data['alamat'];
        $password     = MD5($data['password']);

        //query insert data ke dalam database
        $query = "INSERT INTO tb_users (nama, email,alamat, password) VALUES ('$nama', '$email','$alamat', '$password')";
        $result = mysqli_query($this->conn, $query);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function setToken($data)
    {
        $token = $data['token'];

        $query = "INSERT INTO tb_notifikasi (token) VALUES ('$token')";
        $result = mysqli_query($this->conn, $query);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
}
