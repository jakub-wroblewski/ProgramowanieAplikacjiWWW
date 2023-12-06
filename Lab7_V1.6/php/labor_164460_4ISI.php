<?php
$nr_indeksu = '164460';
$nr_grupy = '4ISI';


echo 'Jakub Wróblewski ' .$nr_indeksu. ' grupa '.$nr_grupy.'<br/><br/>';

echo 'Zastosowanie metody include()<br/>';

echo 'Owoc ' .$fruit. ' kolor' .$color.'<br/>';

include 'zmienne.php';

echo '<br/> <br/>';
echo 'Owoc ' .$fruit. ' kolor ' .$color.'<br/>';


$var1 = require_once('zmienne2.php');
echo 'tekst ' .$var1. '<br/>';
$var2 = require_once('zmienne2.php');
echo 'tekst ' .$var2. '<br/>';


echo 'Warunki if, else, elseif, switch<br/>';

$a = 5;
$b = 5;
if ($a > $b){
    echo 'Zmienna a jest większa od b';
}
elseif ($a == $b){
    echo 'Zmienne są równie';
}
else{
    echo 'Zmienna b jest większa od a';
}
echo '<br/>';
$i = 1;

switch ($i){
    case 0:
        echo 'Liczba 0';
        break;
    case 1:
        echo 'Liczba 1';
        break;
    case 2:
        echo 'Liczba 2';
        break;
}

echo '<br/>';
echo 'Pętla while() i for()';
echo '<br/>';

$x = 0;
while ($x<10):
    echo $x;
    $x++;
endwhile;

echo '<br/>';

for ($x = 0; $x<10; $x++){
    echo $x;
}
echo '<br/>';
echo 'Typy zmiennych $_GET $_POST $_SESSION';
echo '<br/>';

// $name;
$var = $_GET['name'];
echo 'Cześć ' .$var.'';
echo '<br/>';


// echo 'Cześć ' .$_GET["name"]. '';

// session_start();
// $_SESSION['newsession'] = $value;

// echo $_SESSION['newsession'];


?>