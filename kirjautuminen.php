<?php

    include "libs/naytavirheet.php";
    
    require_once 'libs/common.php';
    require_once 'libs/tietokantayhteys.php';
    require_once 'controllers/KirjautuminenOhjain.php';
    require_once 'libs/models/Kayttaja.php';
    
    $ohjain = new KirjautuminenOhjain();
    
    session_start();
    if (isset($_GET['login'])){
        
        $ohjain->kirjauduSisaan($_POST['kayttajatunnus'], $_POST['salasana']);
    

    } elseif (isset($_GET['logout'])) {
        
        $ohjain->kirjauduUlos();
        
    } else {
        
        $ohjain->naytaKirjautuminen();

    }
    
    