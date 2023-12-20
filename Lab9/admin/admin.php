<!-- Strona w przebudowie  -->

<?php
session_start();

include('../cfg.php');
// Funkcja do wyświetlania formularza logowania , gdy sie zalogujemy
// poprawnymi danymi zostajemy przeniesieni do podstrony admin_dashboard
function FormularzLogowania()
{
    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
        header('Location: admin_dashboard.php');
        exit();
    } else {
        echo '
            <form method="post">
            <label type="login">Login</labe>
            <input type="text" name="login"><br>
            <label type="passwd">Hasło</label>
            <input type="password" name="passwd"><br>
            <input type="submit" value="Zaloguj">
            </form>
        ';
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $login = $_POST['login'];
    $passwd = $_POST['passwd'];


    if($login === $login && $passwd === $pass) {
        header("Location: admin_dashboard.php");
        exit();
    } else {
        echo FormularzLogowania();
        echo "Niepoprawne dane, spróbuj ponownie";
    }
}





echo FormularzLogowania();

?>
