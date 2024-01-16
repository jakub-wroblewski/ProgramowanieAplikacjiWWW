<?php
include('cfg.php');
function PokazPodstrone($id)
{
   
   global $conn;
    //zapytanie MYSQL do wyświetlania zawartości strony z bazy danych 
    $id_clear = htmlspecialchars($id);
    $zapytanie = "SELECT * FROM page_list WHERE id = '$id_clear' LIMIT 1";
    $wyniki = mysqli_query($conn, $zapytanie);
    $row = mysqli_fetch_array($wyniki);
    if(empty($row['id']))
    {
        $web = ['nie_znaleziono_strony'];
    }
    else
    {
        $web = $row['page_content'];
    }
    return $web;
}

// echo PokazPodstrone(1);

?>
