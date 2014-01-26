<?php
    require 'libs/tietokantayhteys.php';
    require 'libs/kayttaja.php';
    $sql = "SELECT * from kayttajat";
    $kysely = getTietokantayhteys()->prepare($sql); 
    $kysely->execute();

        
    $rivit = $kysely->fetchAll();

        
  
?><!DOCTYPE HTML>
<html>
  <head><title>Otsikko</title></head>
  <body>
    <h1>Käyttäjän tiedot</h1>
        <ul>
            <li><?php echo $rivit[0]['id'] ?></li>
            <li><?php echo $rivit[0]['etunimi'] ?></li>
            <li><?php echo $rivit[0]['sukunimi'] ?></li>
            <li><?php echo $rivit[0]['kayttajatunnus'] ?></li>
            <li><?php echo $rivit[0]['salasana'] ?></li>
            <li><?php echo $rivit[0]['rooli'] ?></li>
        </ul>
  </body>
</html>
