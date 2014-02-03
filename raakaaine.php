<?php

    include "libs/naytavirheet.php";
    
    require_once 'libs/common.php';
    require_once 'libs/tietokantayhteys.php';
    require_once 'libs/models/raakaaine.php';
    
    session_start();
    if (onkoKirjautunut()){
        
        $raakaaineet = Raakaaine::getRaakaaineet();
        $lukumaara = Raakaaine::raakaaineidenLkm();
        naytaNakyma("views/raakaaineet_listaa.php", array(
        'title' => "listaus",
        'raakaaineet' => $raakaaineet,
        'lkm' => $lukumaara
        ));
    }