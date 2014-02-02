<?php
    require 'libs/tietokantayhteys.php';
    require 'libs/common.php';
    require 'libs/models/kayttaja.php';
    
    session_start();
    if (onkoKirjautunut()){
        $lista = Kayttaja::getKayttajat();
    } else {
        exit();
    }
    
    
    
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
                        <td><?php echo $asia->getNimi(); ?></td>
                        <td><?php echo $asia->getKayttajatunnus(); ?></td>
                        <td><?php echo $asia->getRooli(); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>                
        </div>
    </body>
</html>