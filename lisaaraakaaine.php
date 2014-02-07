<?php

    include "libs/naytavirheet.php";
    
    require_once 'libs/common.php';
    require_once 'libs/tietokantayhteys.php';
    require_once 'libs/models/raakaaine.php';
    
    session_start();
    if (onkoKirjautunut()){
        
        naytaNakyma("views/raakaaine_lisaa.php", array(
        'title' => "raaka-aineen lisäys",
        ));
    }