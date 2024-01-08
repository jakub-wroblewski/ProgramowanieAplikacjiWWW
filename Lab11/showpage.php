<?php

function PokazPodstrone($id)
{
    // zmienne jakimi będziemy lączyć się do bazy danych 
    $bdhost = "localhost";
    $dbuser = "root";
    $dbpass = "";
    $baza = "moja_strona";
    // Tworzy połączenie
    $link = mysqli_connect($dbhost, $dbuser, $dbpass,$baza);
   
    //zapytanie MYSQL do wyświetlania zawartości strony z bazy danych 
    $id_clear = htmlspecialchars($id);
    $zapytanie = "SELECT * FROM page_list WHERE id = '$id_clear' LIMIT 1";
    $wyniki = mysqli_query($link, $zapytanie);
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

?>