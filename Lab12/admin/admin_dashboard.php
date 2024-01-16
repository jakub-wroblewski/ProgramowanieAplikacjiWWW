<?php

include('../cfg.php');

// funkcja odpowiadająca za wylogowanie z sesii
function Wyloguj()
{
    session_start();
    session_destroy();
    header("Location: admin.php");
    exit();
}

// funkcja do wyswietlania przycisku do wylogowania
function WylogujButton()
{
    echo '<form method="get">
            <input name= "wylogowywanie" type="submit" value="Wyloguj"></button>
          </form>';
}

if(isset($_GET['wylogowywanie']) && $_GET['wylogowywanie']=='Wyloguj')
{
    Wyloguj();
}

// funkcja do wyświetlania listy podstron
function ListaPodstron() {
    global $conn;
    
    $query = "SELECT id, page_title FROM page_list";
    // $result = $conn->query($query);
    $result = mysqli_query($conn, $query);
    echo "<h2>Lista Podstron</h2>";
    while($row = mysqli_fetch_array($result)){
        echo '<p>' .$row['id'] . ' ' .$row['page_title']. '</p>';
    }
}

// funkcja do wyświetlania formularza w którym podajemy którą podstronę chcemy edytować
function EdytujPodstroneForm() {
    
    $edycja = '
        <h1>Edytuj Podstronę</h1>
        <form method="post" name="add" enctype="multipart/form-data" action="' . $_SERVER['REQUEST_URI'] . '">
        <p>Id podstrony</p> <input type="text" name="id_strony"/>
        <p>Tytuł podstrony</p> <input type="text" name="page_title"/>
        <p>Treść podstrony</p> <input type="text" name="page_content"/>
        <p>Status podstrony</p> <input type="checkbox" name="status"/>
        <br>
        <input type="submit" name="edycja_button" value="Edytuj"/>
        </form>
        
    ';
  
    return $edycja;
   
}

// funkcja do edycji podstrony z informacji podanych w formularzu

function EdytujPodstrone() {

    global $conn;

    if(isset($_POST['edycja_button'])) {
        $id = $_POST['id_strony'];
        $tytul = $_POST['page_title'];
        $tresc = $_POST['page_content'];
        $status = isset($_POST['status']) ? 1 : 0;

        if(!empty($id)) {
            $query = "UPDATE page_list SET page_title = '$tytul', page_content = '$tresc', status = '$status' WHERE id = '$id' LIMIT 1";
            $result = mysqli_query($conn, $query);
            header("Location: ".$_SERVER['PHP_SELF']);
        exit();
        }
    }

}

// fynkcja wyświetlania formularza aporopo dodawania nowej podstrony
function DodajPodstroneForm() {
  $dodawanie = '

  <h1>Dodaj nową podstronę</h1>
  <form method="post" name="edit" enctype="multipart/form-data" action="' . $_SERVER['REQUEST_URI'] . '">
  <p>Tytuł podstrony</p> <input type="text" name="page_title_add"/>
  <p>Treść podstrony</p> <input type="text" name="page_content_add"/>
  <p>Status podstrony</p> <input type="checkbox" name="status_add"/>
  <br>
  <input type="submit" name="add_button" value="Dodaj"/>
  </form>
  
';
return $dodawanie;
}

// funkcja do dodawania nowej podstrony z informacjami podanymi z formularza
function DodajPodstrone() {
    global $conn;

    if(isset($_POST['add_button'])) {
        $tytul = $_POST['page_title_add'];
        $tresc = $_POST['page_content_add'];
        $status = isset($_POST['status_add']) ? 1 : 0;

        
        $query = "INSERT INTO `page_list` (`page_title`, `page_content`, `status`) VALUES ('$tytul','$tresc','$status')";
        $result = mysqli_query($conn, $query);
        header("Location: ".$_SERVER['PHP_SELF']);
        exit();
        

        
    }

}

// funkcja do wyświetlania formularza do usuwania podstrony
function UsunPodstroneForm() {
    $usuwanie = '

    <h1>Usun Podstronę</h1>
    <form method="post" name="del" enctype="multipart/form-data" action="' . $_SERVER['REQUEST_URI'] . '">
    <p>Id podstrony</p> <input type="text" name="id_del"/>
    <input type="submit" name="del_button" value="Usun"/>
    </form>
    
  ';
    return $usuwanie;
}

// funkcja do usuwania podanej przez urzytkownika podstrony
function UsunPodstrone() {

    global $conn;
    if (isset($_POST['del_button'])) {
        $id = $_POST['id_del'];

        $query = "DELETE FROM page_list WHERE id = $id LIMIT 1";
        $result = mysqli_query($conn, $query);
        header("Location: ".$_SERVER['PHP_SELF']);
        exit();

    }
    

}



echo ListaPodstron();
echo EdytujPodstroneForm();
EdytujPodstrone();
echo DodajPodstroneForm();
DodajPodstrone();
echo UsunPodstroneForm();
UsunPodstrone();
echo WylogujButton();
?>
