<?php

include "libs/naytavirheet.php";

require_once 'libs/common.php';
require_once 'libs/tietokantayhteys.php';
require_once 'controllers/MenutOhjain.php';


session_start();
if (onkoKirjautunut()) {

    $ohjain = new MenutOhjain();

    if (isset($_GET['uusi']) && onkoMuokkaaja()) {

        $ohjain->lisaa();
        
    } elseif (isset($_GET['lisaa']) && onkoMuokkaaja()) {

        $ohjain->tallenna('lisaa', $_POST['nimi'], $_POST['alkuruoka'], $_POST['valiruoka1'], $_POST['paaruoka'], $_POST['valiruoka2'], $_POST['jalkiruoka'], $_POST['kuvaus']);
    
    } elseif (isset($_GET['muokkaa']) && onkoMuokkaaja()){
        
        $ohjain->muokkaa($_GET['muokkaa']);
        
    } elseif (isset($_GET['paivita']) && onkoMuokkaaja()) {

        $ohjain->tallenna('muokkaa', $_POST['nimi'], $_POST['alkuruoka'], $_POST['valiruoka1'], $_POST['paaruoka'], $_POST['valiruoka2'], $_POST['jalkiruoka'], $_POST['kuvaus']);
    
    }elseif (isset($_GET['nayta'])) {

        $ohjain->nayta($_GET['nayta']);
        
    } else {
        
        $ohjain->lista();
    }
}