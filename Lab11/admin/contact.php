<?php

class Kontakt {

    // funkcja do wyświetlenia formularza kontaktowego
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

//  funkcja do przesyłania wiadomości na wybrany mail
    function WyslijMailKontakt() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'wyslij_mail') {

            $email = $_POST['email'];
            $temat = $_POST['temat'];
            $wiadomosc = $_POST['wiadomosc'];

            
            @mail($email, $temat, $wiadomosc);

            echo '<p>Wiadomość została wysłana. Dziękujemy!</p>';
        }
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

    

    
    
}
?>
