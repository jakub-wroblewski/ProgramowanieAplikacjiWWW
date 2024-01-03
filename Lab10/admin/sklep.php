<?php

include("../cfg.php");

function DodajKategorie() {
    global $conn;
    $dodaj='
    <div class="add">
        <h1><b>Dodaj Kategorię</b></h1>
        <form method="post">

            <label for="nazwa">Podaj nazwę kateogrii</label>
            <input type="text" name="nazwa" required />
            <label for="matka">Podaj id kategorii matki</label>
            <input type="number" name="matka" />
            <input type="submit" name="dodaj" value="Dodaj" />

            
        </form>
    </div>';

    echo $dodaj;

    if(isset($_POST['dodaj'])) 
	{
		$nazwa = $_POST['nazwa'];
        $matka = $_POST['matka'];
		
        $query = "INSERT INTO sklep (matka, nazwa) VALUES ('$matka', '$nazwa')";
        $result = mysqli_query($conn, $query);

        if($result) 
		{           
            echo "<script>window.location.href='sklep.php';</script>";
            exit();
        } 
		else 
		{
            echo "<center>Błąd podczas dodawania kategorii: " . mysqli_error($conn)."</center>";
        }
}
}

function EdytujKategorie(){
    global $conn;
    $edytuj='
    <div class="edit">
        <h1><b>Edytuj Kategorię</b></h1>
        <form method="post">

            <label for="id">Podaj id</label>
            <input type="number" name="idd" required />
            <label for="nazwa">Podaj nazwę kateogrii</label>
            <input type="text" name="nazwa" required />
            <label for="matka">Podaj id kategorii matki</label>
            <input type="number" name="matka" />
            <input type="submit" name="edytuj" value="Edytuj" />


        </form>
    </div>';

    echo $edytuj;

    if(isset($_POST['edytuj'])) 
	{	
		$id = $_POST['idd'];
		$nazwa = $_POST['nazwa'];
		$matka = $_POST['matka'];
		
		$query = "SELECT * FROM sklep WHERE id = '$id' LIMIT 1";
		$result = mysqli_query($conn, $query);
		$row = mysqli_fetch_array($result);
		if(is_null($row))
		{
			echo '<center>Nie istnieje kategoria o id '.$id.'!</center>';
			exit();
		}
		
		$query = "UPDATE sklep SET nazwa = '$nazwa', matka = '$matka' WHERE id = '$id' LIMIT 1";
		$result = mysqli_query($conn, $query);
		if($result) 
		{  
			echo "<script>window.location.href='sklep.php';</script>";
			exit();
		} 
		else 
		{
			echo "<center>Błąd podczas edycji: ".mysqli_error($conn)."</center>";
		}
	}   
    
}

function UsunKategorieForm() {
    $usun='
    <div class="delete">
        <h1><b>Usuń Kategorię</b></h1>
        <form method="post">
            <label for="id1">Podaj id</label>
            <input type="number" name="id1" required />
            <input type="submit" name="usun" value="Usuń" />
        </form>
    </div>';

    echo $usun;
}
function UsunKategorie($id)
{	
	global $conn;

	$query = "SELECT id FROM sklep WHERE matka = '$id'";
    $result = mysqli_query($conn, $query);
	if($result)
	{
		while($row = mysqli_fetch_array($result))
		{
			UsunKategorie($row['id']);
		}
	}
	
	$query1 = "DELETE FROM sklep WHERE id = '$id' LIMIT 1";
	$result1 = mysqli_query($conn, $query1);
	if(!$result1)
	{
		echo '<center>Błąd<br><center>';
	}
}
function PokazKategorie($mother = 0, $ile = 0)
{
	global $conn;

    $query = "SELECT * FROM sklep WHERE matka = '$mother'";
    $result = mysqli_query($conn, $query);
	if($result){
		$brak = 0;
		while($row = mysqli_fetch_array($result)) 
		{	
			$brak = 1;
			for($i=0; $i<$ile; $i++)
			{
					echo '&nbsp;&nbsp;&nbsp;<span style="color: #0000FF;">>>>>></span>';
			}
			echo ' <b><span style="color:#008000;">'.$row['id'].'</span> '.$row['nazwa'].'</b><br><br>';
			PokazKategorie($row['id'], $ile+1);
		}
		if($brak == 0 && $ile == 0)
		{
			echo "</center><b>Brak kategorii<b/></center>";
		}
	}
}

DodajKategorie();
EdytujKategorie();
UsunKategorieForm();
if(isset($_POST['usun']))
{
	$id = $_POST['id1'];
	UsunKategorie($id);
	echo "<script>window.location.href='sklep.php';</script>";
	exit();
}
PokazKategorie();
?>