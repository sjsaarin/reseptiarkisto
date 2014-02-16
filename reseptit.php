<?php

//debuggaukseen
include "libs/naytavirheet.php";

require_once 'libs/common.php';
require_once 'libs/tietokantayhteys.php';
require_once 'libs/models/Resepti.php';
require_once 'controllers/ReseptitOhjain.php';

$ohjain = new ReseptitOhjain();
session_start();
if (onkoKirjautunut()) {
    if (isset($_GET['nayta'])) {
        
        $ohjain->nayta($_GET['nayta']);
        
    } elseif (isset($_GET['muokkaa'])){

        $ohjain->muokkaa($_GET['muokkaa']);
        
    } elseif (isset($_GET['paivita'])){

        $ohjain->paivita($_POST['nimi'], $_POST['kategoria'], 
                $_POST['raakaaine'], $_POST['maara'], $_POST['yksikko'], $_POST['annoksia'], $_POST['ohje'], $_POST['juomasuositus'], $_POST['lahde']);
        
    } elseif (isset($_GET['lisaa'])){
        
        $ohjain->lisaa();
        
    } elseif (isset($_GET['tallenna'])) {
        
        $ohjain->tallenna($_POST['nimi'], $_POST['kategoria'], 
                $_POST['raakaaine'], $_POST['maara'], $_POST['yksikko'], $_POST['annoksia'], $_POST['ohje'], $_POST['juomasuositus'], $_POST['lahde']);
        
    } elseif (isset($_POST['id']) && onkoAdmin() ){
        
        $ohjain->poista($_POST['id']);
        
    } else {
        
        $ohjain->lista();
        
    }
}
