<?php 
include("../cfg.php");
session_start();


// funkcja pozyskująca informacje o produktach
function ProduktInfo($id_prod)
{
    global $conn;
    $query = "SELECT * FROM sklep_internetowy WHERE id = $id_prod";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row;
    } else {
        return false;
    }
}

// funkcja dodajaca wybrane produkty do koszyka
function DodajDoKoszyka()
{
    global $conn;

    $id_prod = $_POST['id'];
	$cena = $_POST['cena'];
    $ile_sztuk = $_POST['ilosc_towaru'];
	$row = ProduktInfo($id_prod);
	$ilosc_dostepna = $row['dostepne_sztuki'];
    if($ile_sztuk=='')
    {
        $ile_sztuk=1;
    }

    if (!isset($_SESSION['count'])) {
        $_SESSION['count'] = 1;
    } else {
        $_SESSION['count']++;
    }

    $nr = $_SESSION['count'];
    $row = ProduktInfo($id_prod);

    if($ile_sztuk>$ilosc_dostepna){
        $ile_sztuk = $ilosc_dostepna;
    }
        

    $_SESSION[$nr.'_0'] = $nr;
    $_SESSION[$nr.'_1'] = $id_prod;
    $_SESSION[$nr.'_2'] = $ile_sztuk;
    $_SESSION[$nr.'_3'] = $row['tytul'];
    $_SESSION[$nr.'_4'] = $cena;
    $_SESSION[$nr.'_5'] = $cena * $ile_sztuk;
    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}

// funkcja do usuwania z koszyka
// niestety jezeli ten sam produkt jest kilka razy w koszyku usunie wszystkie na raz
function UsunZKoszyka()
{
    if (isset($_POST['id'])) {
        $productIdToRemove = $_POST['id'];

        for ($i = 1; $i <= $_SESSION['count']; $i++) {
            if (isset($_SESSION[$i.'_1']) && $_SESSION[$i.'_1'] == $productIdToRemove) {
                unset($_SESSION[$i.'_0']);
                unset($_SESSION[$i.'_1']);
                unset($_SESSION[$i.'_2']);
                unset($_SESSION[$i.'_3']);
                unset($_SESSION[$i.'_4']);
                unset($_SESSION[$i.'_5']);
            }
        }
    }

    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}

// funkcja wyswietlająca produkty które mozna dodac do koszyka
function PokazProduktyDoWyboru()
{
    global $conn;

    $query = "SELECT * FROM sklep_internetowy";
    $result = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_assoc($result)) {

        echo '<p> Tytuł: '. $row['tytul']. '  Opis:  ' .$row['opis'].'  Cena netto:  ' .$row['cena_netto'].'zl  ', '  Dostępne Sztuki:  ' .$row['dostepne_sztuki'].'  Kategoria:  ' .$row['kategoria'].'   Gabaryt:  ' .$row['gabaryt_produktu'].'</p>';

        $cenaBrutto = $row['cena_netto'] * (1 + ($row['podatek_vat'])/100);

        echo '<td>';
            echo '<form method="post" action="' . $_SERVER['PHP_SELF'] . '">';
            echo '<input type="hidden" name="id" value="' . $row['id'] . '">';
            echo '<input type="hidden" name="tytul" value="' . $row['tytul'] . '">';
            echo '<input type="hidden" name="cena" value="' . $cenaBrutto . '">';
            echo '<input type="number" name="ilosc_towaru" min="1" >';
            echo '<input type="submit" name="dodaj_do_koszyka" value="Dodaj">';
            echo '</form>';
        }
        echo '</td>';

      

    echo '</table>';
    echo '</div>';
}

// funkcja wyswietlająca zawartosc koszyka
function WyswietlKoszyk()
{
    echo '<div>';
    echo '<h2>Zawartość koszyka</h2>';
    $suma = 0;

    if (isset($_SESSION['count'])) {
        echo '<ul>';
        for ($i = 1; $i <= $_SESSION['count']; $i++) {
            if (isset($_SESSION[$i.'_1'], $_SESSION[$i.'_2'], $_SESSION[$i.'_5']))
            {
                $suma += $_SESSION[$i.'_5'] * $_SESSION[$i.'_2'];
                echo '<li>';
                echo '<span>' . $_SESSION[$i.'_3'] . ' - Ilość: ' . $_SESSION[$i.'_2'] . '</span>';
                echo' <form method="post" action="' . $_SERVER['PHP_SELF'] . '">
                        <input type="hidden" name="id" value="' . $_SESSION[$i.'_1'] . '">
                        <input type="submit" name="usun_z_koszyka" value="Usuń z koszyka">
                    </form>';
                echo '</li>';
            }
        }
        echo '</ul>';
    } 
    else
    {
        echo 'Koszyk jest pusty';
    }
    echo '<p>Do zapłaty: ' . number_format($suma, 2) . '</p>';
    echo '</div>';
    echo '</div>';
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["dodaj_do_koszyka"])) {
        DodajDoKoszyka();
    } elseif (isset($_POST["usun_z_koszyka"])) {
        UsunZKoszyka();
    }
}
PokazProduktyDoWyboru();
WyswietlKoszyk();
?>
