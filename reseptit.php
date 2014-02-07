<?php

    include "libs/naytavirheet.php";
    
    require_once 'libs/common.php';
    require_once 'libs/tietokantayhteys.php';
    require_once 'libs/models/resepti.php';
    
    session_start();
    if (onkoKirjautunut()){
        
        $reseptit = Resepti::getReseptit();
        $lukumaara = Resepti::reseptienLkm();
        naytaNakyma("views/resepti_listaa.php", array(
        'title' => "Resepti",
        'reseptit' => $reseptit,
        'lkm' => $lukumaara
        ));
    }
