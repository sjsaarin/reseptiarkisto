<?php
    require 'libs/tietokantayhteys.php';
    require 'libs/models/kayttaja.php';
    
    $lista = Kayttaja::getKayttajat();
    
?><!DOCTYPE HTML>
<html>
    <head>
        <title>Listaustesti</title>
        <link href="css/bootstrap.css" rel="stylesheet">
        <link href="css/bootstrap-theme.css" rel="stylesheet">
        <link href="css/main.css" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <h1>Käyttäjien tiedot</h1>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Nimi</th>
                        <th>Käyttäjätunnus</th>
                        <th>Rooli</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($lista as $asia): ?>
                    <tr>
                        <td><?php echo $asia->getId(); ?></td>
                        <td><?php echo $asia->getName(); ?></td>
                        <td><?php echo $asia->getUsername(); ?></td>
                        <td><?php echo $asia->getRole(); ?>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>                
        </div>
    </body>
</html>
