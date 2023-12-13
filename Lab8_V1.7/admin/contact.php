<?php

class Kontakt {
    function PokazKontakt() {
        echo '
        <h2>Kontakt</h2>
        <form method="post" action="contact.php?action=wyslij_mail">
            <label for="email">Twój e-mail:</label>
            <input type="email" name="email" required><br>

            <label for="temat">Temat:</label>
            <input type="text" name="temat" required><br>

            <label for="wiadomosc">Wiadomość:</label>
            <textarea name="wiadomosc" required></textarea><br>

            <input type="submit" value="Wyślij">
        </form>
        ';
    }


    function WyslijMailKontakt() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'wyslij_mail') {

            $email = $_POST['email'];
            $temat = $_POST['temat'];
            $wiadomosc = $_POST['wiadomosc'];

            
            @mail($email, $temat, $wiadomosc);

            echo '<p>Wiadomość została wysłana. Dziękujemy!</p>';
        }
    }
    function PrzypomnijHaslo() {
        echo '<h2>Przypomnij hasło</h2>';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'przypomnij_haslo') {
            
            $email = $_POST['email'];
    
            
            if ($this->SprawdzCzyIstniejeUzytkownik($email)) {
                
                $noweHaslo = $this->GenerujNoweHaslo();
    
                
                $this->ZapiszNoweHaslo($email, $noweHaslo);
    
                
                $this->WyslijMailPrzypomnienieHasla($email, $noweHaslo);
    
                echo '<p>Nowe hasło zostało wysłane na podany adres e-mail.</p>';
            } else {
                echo '<p>Użytkownik o podanym adresie e-mail nie istnieje.</p>';
            }
        } else {
            
            echo '
            <form method="post" action="contact.php?action=przypomnij_haslo">
                <label for="email">Twój e-mail:</label>
                <input type="email" name="email" required><br>
    
                <input type="submit" value="Przypomnij hasło">
            </form>
            ';
        }
    }
    
    function WyslijMailPrzypomnienieHasla($email, $noweHaslo) {
        $temat = "Przypomnienie hasła";
        $wiadomosc = "Twoje nowe hasło: $noweHaslo";
     
        mail($email, $temat, $wiadomosc);
    }
    

}


$kontakt = new Kontakt();

if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'wyslij_mail':
            $kontakt->WyslijMailKontakt();
            break;
        default:
            
            break;
    }
} else {
    
    $kontakt->PokazKontakt();

    $kontakt->PrzypomnijHaslo();

    
    
}
?>
