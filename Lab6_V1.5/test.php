<?php
 error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);

//  include('showpage.php');
 
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
    // include('cfg.php');
    include('showpage.php');

    if ($_GET['idp'] == '') {
        {echo PokazPodstrone(4);}
    }
    elseif ($_GET['idp'] == 'glowna'){
        {echo PokazPodstrone(4);}
    }
    elseif ($_GET['idp']== 'polska'){
        {echo PokazPodstrone(1);}
    }
    elseif ($_GET['idp']== 'niemcy'){
        {echo PokazPodstrone(6);}
    }
    elseif ($_GET['idp']== 'stany_zjednoczone'){
        {echo PokazPodstrone(7);}
    }
    elseif ($_GET['idp']== 'arabia_saudyjska'){
        {echo PokazPodstrone(8);}
    }
    elseif ($_GET['idp']== 'anglia'){
        {echo PokazPodstrone(2);}
    }
    elseif ($_GET['idp']== 'kontakt'){
        {echo PokazPodstrone(5);}
    }
    else{
        echo 'Strony nie ma';
    }

    ?>

    </div>

</body>

</html>

