<?php
/**
  * File contains script to authenitcate user from login_page.html
  *
  * @author Albert Yu
  *
  * Allows user to sign in to Pixel Share
  */
require_once 'login.php';

$conn = new mysqli($hn, $un, $pw, $db);
if ($conn->connect_error) die($conn->connect_error);
$username = $_POST["username"];
$password = $_POST["psw"];
$query = "SELECT * FROM users WHERE username = '$username'";
$result = $conn->query($query);

$row = $result->fetch_array(MYSQLI_NUM);


$decrypted_password = password_verify($password, $row[4]);
if ($decrypted_password) {
    
    header("Location: main_page.php?user=$username");
    exit;
}
else {
    header("Location: login_page.html");
}

?>