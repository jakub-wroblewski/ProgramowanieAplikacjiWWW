<?php
 error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
 
 ?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-type" content="text/html" charset="UTF-8" />
    <meta http-equiv="Content-Language" content="pl" />
    <meta name="Author" content="Jakub Wróblewski" />
    <title>Największe mosty świata</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css" />
    <script src="../js/kolorujtlo.js" type="text/javascript"></script>
    <script src="../js/timedate.js" type="text/javascript"></script>
    <script src="../js/jquery-3.7.1.min.js"></script>
    

</head>
<body onload="startclock()">
    <ul>
        
        <a href="test.php?idp=glowna">
        <li id="aa"><img src="img/home_picture.png" alt="Picture to home page" id="glowna"></li>
        </a>
        <b>
        <li><a href="test.php?idp=polska">Polska</a></li>
        <li><a href="test.php?idp=niemcy">Niemcy</a></li>
        <li><a href="test.php?idp=stany_zjednoczone">Stany Zjednoczone</a></li>
        <li><a href="test.php?idp=arabia_saudyjska">Arabia Saudyjska</a></li>
        <li><a href="test.php?idp=anglia">Anglia</a></li>
        <li><a href="test.php?idp=kontakt">Kontakt</a></li>
        </b>
    </ul>
    <nav class="site-bar">
    <form method="Post" name="background">
        <!-- <div class="site-bar" -->
        <input type="button" class="site-bar-trigger" value="Biały" onclick="changeBackground('#FFFFFF')">
        <input type="button" class="site-bar-trigger" value="Czarny" onclick="changeBackground('#000000')">
        <input type="button" class="site-bar-trigger" value="Czerwony" onclick="changeBackground('#FF0000')">
        <input type="button" class="site-bar-trigger" value="Niebieski" onclick="changeBackground('#0000FF')">
        <input type="button" class="site-bar-trigger" value="Jasno Brązowy" onclick="changeBackground('#FFE4C4')">
    </nav>        
    </form>
    <div>
    <?php
    $strona = isset($_GET['idp']) ? $_GET['idp']: '';
    if ($strona == '') {
        $strona = 'html/glowna.html';
    }
    elseif ($strona == 'glowna'){
        $strona = 'html/glowna.html';
    }
    elseif ($strona == 'polska'){
        $strona = 'html/polska.html';
    }
    elseif ($strona == 'niemcy'){
        $strona = 'html/niemcy.html';
    }
    elseif ($strona == 'stany_zjednoczone'){
        $strona = 'html/stany_zjednoczone.html';
    }
    elseif ($strona == 'arabia_saudyjska'){
        $strona = 'html/arabia_saudyjska.html';
    }
    elseif ($strona == 'anglia'){
        $strona = 'html/anglia.html';
    }
    elseif ($strona == 'kontakt'){
        $strona = 'html/kontakt.html';
    }

    if(file_exists($strona)){
        include($strona);
    }
    else{
        echo 'Strony nie ma';
    }

    ?>

    </div>

</body>

</html>

