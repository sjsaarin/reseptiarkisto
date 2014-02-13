<?php

//debuggaukseen
include "libs/naytavirheet.php";

require_once 'libs/common.php';
require_once 'libs/tietokantayhteys.php';
require_once 'libs/models/resepti.php';
require_once 'controllers/ReseptitOhjain.php';

$ohjain = new ReseptitOhjain();
session_start();
if (onkoKirjautunut()) {
    if (isset($_GET['nayta'])) {
        
        $ohjain->nayta();
        
    } elseif (isset($_GET['muokkaa'])){
        naytaNakyma("views/resepti_muokkaa.php", array(
            'sivu' => $sivun_nimi
        ));
    } elseif (isset($_GET['lisaa'])){
        naytaNakyma("views/resepti_lisaa.php", array());
    } else {
        
        $ohjain->lista();
        
    }
}
