<?php
$servername = "localhost";
$username = "root";
$password = "";
$db = "moja_strona";
// Create connection
$conn = mysqli_connect($servername, $username, $password,$db);
// Check connection
if (!$conn) {
die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully";
$_GLOBALS['link'] = $conn;
// $zapytanie = 'SELECT page_content FROM `page_list` WHERE id= 2';
// $wyniki = $conn->query($zapytanie);

// if ($wyniki->num_rows > 0) {
//     while ($row = $wyniki->fetch_assoc()) {
//         echo $row["page_content"];
//     }
// } else {
//     echo "Brak wyników.";
// }

// mysqli_close($conn);


?>