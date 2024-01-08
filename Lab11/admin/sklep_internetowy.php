<?php

include("../cfg.php");


// funkcja do wyświetlania formularza dodawania nowego produktu
// po wypełnieniu formularza można dodać nowy produkt
function DodajProdukt() {
    global $conn;
    $dodaj='
    <div class="add">
        <h1><b>Dodaj Produkt</b></h1>
        <form method="post" enctype="multipart/form-data" action="'.$_SERVER['REQUEST_URI'].'">

            <label>Podaj nazwę produktu</label>
            <input type="text" name="tytul" required />

            <label>Podaj opis produktu</label>
            <input type="text" name="opis" required />

            <label>Podaj datę wygaśniecia produktu</label>
            <input type="date" name="data_wygasniecia" required />

            <label>Podaj cenę netto produktu</label>
            <input type="number" name="cena_netto" required />

            <label>Podaj wysokość podatku VAT</label>
            <input type="number" name="podatek_vat" required />

            <label>Podaj ilość dostępnych sztuk</label>
            <input type="number" name="dostepne_sztuki" />

            <label>Podaj kategorię</label>
            <input type="text" name="kategoria" />

            <label>Podaj gabaryt w kilogramach</label>
            <input type="number" name="gabaryt_produktu" />

            <input type="submit" name="dodaj" value="Dodaj" />
            
        </form>
    </div>';


    echo $dodaj;

    if(isset($_POST['dodaj'])) {
        global $conn;


		$tytul = $_POST['tytul'];
        $opis = $_POST['opis'];
        $data_utworzenia = date('Y-m-d');
		$data_modyfikacji = date('Y-m-d');
        $data_wygasniecia = $_POST['data_wygasniecia'];
        $cena_netto = $_POST['cena_netto'];
        $podatek_vat = $_POST['podatek_vat'];
        $dostepne_sztuki = $_POST['dostepne_sztuki'];
        if($dostepne_sztuki>0 && $data_wygasniecia >= date('Y-m-d')){
            $status_dostepnosci = 1;
        }
        else {
            $status_dostepnosci = 0;
        }
        $kategoria = $_POST['kategoria'];
        $gabaryt_produktu = $_POST['gabaryt_produktu'];
        // $zdjecie = $_POST['zdjecie'];
        
        $query = "INSERT INTO `sklep_internetowy`(`tytul`, `opis`, `data_utworzenia`, `data_modyfikacji`, `data_wygasniecia`, `cena_netto`, `podatek_vat`, `dostepne_sztuki`, `status_dostepnosci`, `kategoria`, `gabaryt_produktu`)  VALUES ('$tytul','$opis','$data_utworzenia','$data_modyfikacji','$data_wygasniecia','$cena_netto','$podatek_vat', '$dostepne_sztuki','$status_dostepnosci','$kategoria','$gabaryt_produktu')";
        $result = mysqli_query($conn, $query);

        if($result) 
		{           
            echo "<script>window.location.href='sklep_internetowy.php';</script>";
            exit();
        } 
		else 
		{
            echo "<center>Błąd podczas dodawania kategorii: " . mysqli_error($conn)."</center>";
        }
}
}

// funkcja do wświetlania formularza do usuwania produktu
function UsunProduktForm() {
    $del = '
        <form method="post" enctype="multipart/form-data" action="'.$_SERVER['REQUEST_URI'].'">
        <h1>Podaj id produktu do usuniecia</h1>
        <br>
        <input type="number" name="id_del" />
        <input type="submit" name="del_produkt" value="Usun" />
        </form>
    ';
    return $del;
}

// funkcja do usuwania produktu z bazy danych 
function UsunProdukt()
{
    global $conn;
	
    if(isset($_POST['del_produkt'])) 
	{
        $id = $_POST['id_del'];
        $query = "DELETE FROM sklep_internetowy WHERE id = '$id' LIMIT 1";
        $result = mysqli_query($conn, $query);

        if($result) 
		{         
            echo "<script>window.location.href='sklep_internetowy.php';</script>";
            exit();
        }
		else 
		{
            echo "<center>Błąd podczas usuwania produktu: " . mysqli_error($conn)."</center>";
        }
    }
}

// funkcja do wyswietlania formularza do edycji produktu
function EdytujProduktForm(){

    $edytuj='
    <div class="edit">
        <h1><b>Edytuj produkt</b></h1>
        <form method="post" enctype="multipart/form-data" action="'.$_SERVER['REQUEST_URI'].'">

            <label>Podaj id produktu do edytowania</label>
            <input type="number" name="id" required />

            <label>Podaj nową nazwę produktu</label>
            <input type="text" name="tytul" required />

            <label>Podaj opis produktu</label>
            <input type="text" name="opis" required />

            <label>Podaj datę wygaśniecia produktu</label>
            <input type="date" name="data_wygasniecia" required />

            <label>Podaj cenę netto produktu</label>
            <input type="number" name="cena_netto" required />

            <label>Podaj wysokość podatku VAT</label>
            <input type="number" name="podatek_vat" required />

            <label>Podaj ilość dostępnych sztuk</label>
            <input type="number" name="dostepne_sztuki" />

            <label>Podaj kategorię</label>
            <input type="text" name="kategoria" />

            <label>Podaj gabaryt w kilogramach</label>
            <input type="number" name="gabaryt_produktu" />

            <input type="submit" name="edytuj_botton" value="Edytuj" />
            
        </form>
    </div>';

    echo $edytuj;
}

// funkcja do edytowania wybranego przez użytkownika produktu w bazie danych
function EdytujProdukt() {
    global $conn;
    if(isset($_POST['edytuj_botton'])) {
        global $conn;

        $id = $_POST['id'];
		$tytul = $_POST['tytul'];
        $opis = $_POST['opis'];
		$data_modyfikacji = date('Y-m-d');
        $data_wygasniecia = $_POST['data_wygasniecia'];
        $cena_netto = $_POST['cena_netto'];
        $podatek_vat = $_POST['podatek_vat'];
        $dostepne_sztuki = $_POST['dostepne_sztuki'];
        if($dostepne_sztuki>0 && $data_wygasniecia >= date('Y-m-d')){
            $status_dostepnosci = 1;
        }
        else {
            $status_dostepnosci = 0;
        }
        $kategoria = $_POST['kategoria'];
        $gabaryt_produktu = $_POST['gabaryt_produktu'];
        // $zdjecie = $_POST['zdjecie'];

        if(!empty($id)){
            $query = "UPDATE `sklep_internetowy` SET `tytul`='$tytul',`opis`='$opis',
            `data_modyfikacji`='$data_modyfikacji',`data_wygasniecia`='$data_wygasniecia',`cena_netto`='$cena_netto',`podatek_vat`='$podatek_vat',
            `dostepne_sztuki`='$dostepne_sztuki',`status_dostepnosci`='$status_dostepnosci',`kategoria`='$kategoria',
            `gabaryt_produktu`='$gabaryt_produktu' WHERE id = '$id' LIMIT 1";
            $result = mysqli_query($conn, $query);

            if($result) 
		    {           
                echo "<script>window.location.href='sklep_internetowy.php';</script>";
                exit();
            } 
		    else 
		    {
                echo "<center>Błąd podczas dodawania kategorii: " . mysqli_error($conn)."</center>";
            }

        }
        
        
    }
    
}

// funkcja do wyswietlania wszystkich produktów z bazy danych 
function PokazProdukty()
{
	global $conn;

    $query = "SELECT * FROM sklep_internetowy ORDER BY id ASC";
    $result = mysqli_query($conn, $query);
    
	if($result) {
        echo '<h1>Lista produktów</h1>';


        while($row = mysqli_fetch_array($result)) {
            echo '
                <p>'.$row['id'].'
                '.$row['tytul'].'
                '.$row['opis'].'
                '.$row['data_utworzenia'].'
                '.$row['data_modyfikacji'].'
                '.$row['data_wygasniecia'].'
                '.$row['cena_netto'].'
                '.$row['podatek_vat'].'
                '.$row['dostepne_sztuki'].'
                '.$row['status_dostepnosci'].'
                '.$row['kategoria'].'
                '.$row['gabaryt_produktu'].'</p>
            
            ';
        }

    }
}

DodajProdukt();
echo UsunProduktForm();
UsunProdukt();
echo EdytujProduktForm();
EdytujProdukt();
PokazProdukty();

?>