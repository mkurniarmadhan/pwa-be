<?php
session_start();
include('config.php');
header('Access-Control-Allow-Origin: *');

$username = $_POST['username'];
$password = MD5($_POST['password']);

//query
$query = "SELECT * FROM tb_users WHERE email='$username' AND password='$password'";
$result = mysqli_query($conn, $query);
$num_row = mysqli_num_rows($result);
$row = mysqli_fetch_array($result);

if ($num_row >= 1) {

    echo "success";

    // $_SESSION['id_user'] = $row['id'];
    // $_SESSION['username'] = $row['username'];
} else {

    echo "error";
}
