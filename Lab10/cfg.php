<?php
$servername = "localhost";
$username = "root";
$password = "";
$db = "moja_strona";


$login = "admin";
$pass = "admin123";

// Tworzy połączenie
$conn = mysqli_connect($servername, $username, $password,$db);
// Sprawdza połączenie
if (!$conn) {
die("Connection failed: " . mysqli_connect_error());
}
// echo "Connected successfully";
$_GLOBALS['link'] = $conn;


?>