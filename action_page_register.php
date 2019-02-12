<?php
/**
  * File contains script to register user from register_page.html
  * creates new user with 100 credits and sends to the main page
  * @author Albert Yu
  *
  * Allows user to register to Pixel Share
  */
require_once 'login.php';

$first = $_POST["first"];
$last = $_POST["last"];
$username = $_POST["username"];
$password = $_POST["psw"];
$type = "user";


$conn = new mysqli($hn, $un, $pw, $db);
if ($conn->connect_error) die($conn->connect_error);

$query = "SELECT * FROM users WHERE username = '$username'";
$sth = $conn->query($query);
$rows = $sth->num_rows;
echo $first;
if ($_POST["psw"] == $_POST["psw-repeat"] && $rows == 0) {
    $hash = password_hash($password, PASSWORD_BCRYPT);
    $query = "INSERT INTO users (last_name, first_name, username, password, credit, type)
                VALUES ('$last', '$first', '$username', '$hash', 100, '$type')";
    $result = $conn->query($query);
    header("Location:main_page.php?user=$username");
}
else{ 
    header("Location: register_page.html");
}

?>