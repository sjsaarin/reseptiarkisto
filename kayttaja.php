<?php

    include "libs/naytavirheet.php";
    
    require_once 'libs/common.php';
    require_once 'libs/tietokantayhteys.php';
    require_once 'libs/models/kayttaja.php';
    
    session_start();
    if (onkoKirjautunut()){
        naytaNakyma("views/kayttaja.php", array(
            'sivu' => 'kayttaja',
            'title' => "Käyttäjän tiedot"
        ));
    }
    
    