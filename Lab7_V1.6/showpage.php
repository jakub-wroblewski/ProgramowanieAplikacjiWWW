<?php
// include('cfg.php');
// include('test.php');
function PokazPodstrone($id)
{
    $bdhost = "localhost";
    $dbuser = "root";
    $dbpass = "";
    $baza = "moja_strona";
    // Create connection
    $link = mysqli_connect($dbhost, $dbuser, $dbpass,$baza);
   

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

//     if ($wyniki->num_rows > 0) {
//         while ($row = $wyniki->fetch_assoc()) {
//             echo $row["page_content"];
//         }
// }   else {
//         echo "Brak wyników.";
//     }

// }

?>