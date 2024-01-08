<?php
// Połączenie z bazą danych (przykładowe dane)
include("../cfg.php");

global $conn;
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Dodaj produkt
function DodajProdukt($tytul, $opis, $cenaNetto, $podatekVAT, $iloscSztuk, $kategoria, $gabaryt, $zdjecieLink) {
    global $conn;

    $dataUtworzenia = date("Y-m-d");
    $statusDostepnosci = true;

    $sql = "INSERT INTO produkty (tytul, opis, data_utworzenia, cena_netto, podatek_vat, ilosc_dostepnych_sztuk, status_dostepnosci, kategoria, gabaryt_produktu, zdjecie_link)
            VALUES ('$tytul', '$opis', '$dataUtworzenia', $cenaNetto, $podatekVAT, $iloscSztuk, $statusDostepnosci, '$kategoria', '$gabaryt', '$zdjecieLink')";

    if ($conn->query($sql) === TRUE) {
        echo "Produkt dodany pomyślnie.";
    } else {
        echo "Błąd: " . $conn->error;
    }
}

// Usuń produkt
function UsunProdukt($id) {
    global $conn;

    $sql = "DELETE FROM produkty WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Produkt usunięty pomyślnie.";
    } else {
        echo "Błąd: " . $conn->error;
    }
}

// Edytuj produkt
function EdytujProdukt($id, $tytul, $opis, $cenaNetto, $podatekVAT, $iloscSztuk, $kategoria, $gabaryt, $zdjecieLink) {
    global $conn;

    $dataModyfikacji = date("Y-m-d");

    $sql = "UPDATE produkty
            SET tytul='$tytul', opis='$opis', data_modyfikacji='$dataModyfikacji', cena_netto=$cenaNetto, podatek_vat=$podatekVAT, ilosc_dostepnych_sztuk=$iloscSztuk, kategoria='$kategoria', gabaryt_produktu='$gabaryt', zdjecie_link='$zdjecieLink'
            WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Produkt zaktualizowany pomyślnie.";
    } else {
        echo "Błąd: " . $conn->error;
    }
}

// Pokaż produkty
function PokazProdukty() {
    global $conn;

    $sql = "SELECT * FROM produkty";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "ID: " . $row["id"]. " - Tytuł: " . $row["tytul"]. " - Cena: " . $row["cena_netto"]. "<br>";
        }
    } else {
        echo "Brak produktów.";
    }
}
echo DodajProdukt();
echo PokazProdukty();

// Zakończ połączenie z bazą danych
$conn->close();

?>
