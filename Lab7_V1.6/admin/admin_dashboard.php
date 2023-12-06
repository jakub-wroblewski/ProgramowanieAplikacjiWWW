<?php

session_start();
include('../cfg.php');

if (isset($_POST['logout'])) {
   
    session_destroy();

  
    header("Location: admin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formularz Wylogowywania</title>
</head>
<body>

<?php

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
    echo "<p>Zalogowano jako: " . $_SESSION['login'] . "</p>";

  
    echo "<form method='post' action='admin.php'>";
    echo "<input type='submit' name='logout' value='Wyloguj'>";
    echo "</form>";
} else {
    
    header("Location: admin.php");
    exit();
}
?>

</body>
</html>




