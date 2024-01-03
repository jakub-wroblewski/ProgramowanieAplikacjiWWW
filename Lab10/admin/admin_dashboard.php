<!-- Strona w przebudowie będą zmiany -->

<?php
include('../cfg.php');
// funkcja do wyswietlania formularza wylogowania
function WylogujButton()
{
    echo '<form method="get">
            <input type="hidden" name="akcja" value="wyloguj">
            <button type="submit">Wyloguj</button>
          </form>';
}

if(isset($_GET['akcja']) && $_GET['akcja']=='wyloguj')
{
    Wyloguj();
}

// funkcja do wyświetlania listy podstron
function ListaPodstron() {
    

  
    $servername = "localhost";
    $username = "root";
    $password = "";
    $db = "moja_strona";

    $conn = mysqli_connect($servername, $username, $password,$db);

    
    if ($conn->connect_error) {
        die("Błąd połączenia z bazą danych: " . $conn->connect_error);
    }

   
    $query = "SELECT id, page_title FROM page_list";
    $result = $conn->query($query);

    
    if ($result->num_rows > 0) {
        echo "<h2>Lista Podstron</h2>";
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Tytuł Podstrony</th><th>Akcje</th></tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['page_title'] . "</td>";
            echo "<td><button onclick='edytujPodstrone(" . $row['id'] . ")'>Edytuj</button> ";
            echo "<button onclick='usunPodstrone(" . $row['id'] . ")'>Usuń</button></td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "<p>Brak podstron do wyświetlenia.</p>";
    }

  
    $conn->close();
}
// funkcja do wyświetlania formularza do wyboru którą podstronę chcemy
//  edytować
function EdytujPodstroneForm() {
    
   
   
    $id = isset($_POST['id']) ? $_POST['id'] : null;

    echo "<h2>Edytuj Podstronę</h2>";
    echo "<form method='post' action='admin.php?action=edit'>";
    echo "ID Podstrony: <input type='text' name='id'><br>";
    echo "<input type='submit' value='Edytuj'>";
    echo "</form>";

   
    if ($id !== null) {
        $this->EdytujPodstrone($id);
    }
}
// funkcja do edycji podstronę której id podał użytkownik w formularzu
function EdytujPodstrone($id) {
  
    

    $servername = "localhost";
    $username = "root";
    $password = "";
    $db = "moja_strona";
    
    $conn = mysqli_connect($servername, $username, $password,$db);

    
    if ($conn->connect_error) {
        die("Błąd połączenia z bazą danych: " . $conn->connect_error);
    }

    
    $query = "SELECT id, page_title, page_content, status FROM page_list WHERE id = $id";
    $result = $conn->query($query);

   
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $tytul = $row['page_title'];
        $tresc = $row['page_content'];
        $status = $row['status'];

        echo "<h2>Edytuj Podstronę</h2>";
        echo "<form method='post' action='zapisz_edycje.php'>";
        echo "<input type='hidden' name='id' value='$id'>";
        echo "Tytuł: <input type='text' name='tytul' value='$tytul'><br>";
        echo "Treść: <textarea name='tresc'>$tresc</textarea><br>";
        echo "Aktywna: <input type='checkbox' name='status' " . ($status ? 'checked' : '') . "><br>";
        echo "<input type='submit' value='Zapisz'>";
        echo "</form>";
    } else {
        echo "<p>Nie znaleziono podstrony o podanym ID.</p>";
    }

    
    $conn->close();
}
// fynkcja do dodawania nowej podstrony do bazy danych 
function DodajNowaPodstrone() {
  
  
   
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
      
        $servername = "localhost";
    $username = "root";
    $password = "";
    $db = "moja_strona";

    $conn = mysqli_connect($servername, $username, $password,$db);

        if ($conn->connect_error) {
            die("Błąd połączenia z bazą danych: " . $conn->connect_error);
        }

    
        $tytul = $conn->real_escape_string($_POST['tytul']);
        $tresc = $conn->real_escape_string($_POST['tresc']);
        $aktywna = isset($_POST['aktywna']) ? 1 : 0;

        $query = "INSERT INTO page_list ('page_title', 'page_content', 'status') VALUES ($tytul, $tresc, $aktywna)";

        
        if ($conn->query($query)) {
            echo "<p>Podstrona została dodana pomyślnie.</p>";
        } else {
            echo "<p>Błąd przy dodawaniu podstrony: " . $conn->error . "</p>";
        }

        
        $conn->close();
    }
    

    echo "<h2>Dodaj Nową Podstronę</h2>";
    echo "<form method='post' action='admin.php?action=add'>";
    echo "Tytuł: <input type='text' name='tytul'><br>";
    echo "Treść: <textarea name='tresc'></textarea><br>";
    echo "Aktywna: <input type='checkbox' name='aktywna' checked><br>";
    echo "<input type='submit' name='submit' value='Dodaj'>";
    echo "</form>";
}
// funkcja do usuwania podstrony w bazy danych
function UsunPodstrone() {
    
 

    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        
        $servername = "localhost";
        $username = "root";
        $password = "";
        $db = "moja_strona";

        $conn = mysqli_connect($servername, $username, $password,$db);
       
        if ($conn->connect_error) {
            die("Błąd połączenia z bazą danych: " . $conn->connect_error);
        }

        
        $query = "DELETE FROM page_list WHERE id = $id";

        
        if ($conn->query($query)) {
            echo "<p>Podstrona została usunięta pomyślnie.</p>";
        } else {
            echo "<p>Błąd przy usuwaniu podstrony: " . $conn->error . "</p>";
        }

        $conn->close();
    } else {
        echo "<p>Nieprawidłowe wywołanie. Brak ID podstrony.</p>";
    }
}
echo WylogujButton();
echo ListaPodstron();
echo UsunPodstrone();
echo DodajNowaPodstrone();
// echo EdytujPodstrone();
echo EdytujPodstroneForm();

?>
