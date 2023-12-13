<?php
include('../cfg.php');


session_start(); 

class AdminPanel {
 
    public function FormularzLogowania() {
     
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
            header("Location: admin.php");
            exit();
        }

      
        echo "<h2>Formularz Logowania</h2>";
        echo "<form method='post' action='admin.php'>";
        echo "Login: <input type='text' name='login'><br>";
        echo "Hasło: <input type='password' name='pass'><br>";
        echo "<input type='submit' value='Zaloguj'>";
        echo "</form>";
    }

    public function SprawdzLogowanie($login, $pass) {
        require_once '../cfg.php';


        if ($login === $GLOBALS['login'] && $pass === $GLOBALS['pass']) {
            $_SESSION['logged_in'] = true;
            header("Location: admin.php");
            exit();
        } else {
            echo "<p>Błąd logowania. Spróbuj ponownie.</p>";
            $this->FormularzLogowania();
        }
    }

    
    public function Wyloguj() {
        
        session_destroy();
        
        header("Location: admin.php");
        // exit();
    }

        public function WylogujForm() {
            echo '<form method="post" action="">
            <input type="submit" name="wyloguj" value="Wyloguj">
        </form>';
        }
    public function ListaPodstron() {
        if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
            echo "<p>Brak dostępu. Zaloguj się.</p>";
            $this->FormularzLogowania();
            return;
        }

      
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

    public function EdytujPodstroneForm() {
        
        if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
            echo "<p>Brak dostępu. Zaloguj się.</p>";
            $this->FormularzLogowania();
            return;
        }

       
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

    public function EdytujPodstrone($id) {
      
        if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
            echo "<p>Brak dostępu. Zaloguj się.</p>";
            $this->FormularzLogowania();
            return;
        }

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

    public function DodajNowaPodstrone() {
      
        if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
            echo "<p>Brak dostępu. Zaloguj się.</p>";
            $this->FormularzLogowania();
            return;
        }

       
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
    
    public function UsunPodstrone() {
        
        if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
            echo "<p>Brak dostępu. Zaloguj się.</p>";
            $this->FormularzLogowania();
            return;
        }

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
}





$adminPanel = new AdminPanel();



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = isset($_POST['login']) ? $_POST['login'] : '';
    $pass = isset($_POST['pass']) ? $_POST['pass'] : '';

    $adminPanel->SprawdzLogowanie($login, $pass);
} else {
    if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
        $adminPanel->FormularzLogowania();
    } else {   
        echo "<form method='post' action='admin.php'>";
        echo "<input type='submit' name='logout' value='Wyloguj'>";
        echo "</form>";
    }
}

    
    $adminPanel->ListaPodstron();


    $adminPanel->EdytujPodstroneForm();
   if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'edit') {
    $adminPanel->EdytujPodstrone();
}

if (isset($_GET['action']) && $_GET['action'] === 'add') {
    $adminPanel->DodajNowaPodstrone();
}

if (isset($_GET['action']) && $_GET['action'] === 'delete') {
    $adminPanel->UsunPodstrone();
}

// $adminPanel->EdytujPodstrone(1);
// $adminPanel->Wyloguj();
if (isset($_GET['action']) && $_GET['action'] === 'wyloguj') {
    $admin -> Wyloguj();
}
$adminPanel ->WylogujForm();
$adminPanel ->DodajNowaPodstrone();
$adminPanel ->UsunPodstrone();
?>
