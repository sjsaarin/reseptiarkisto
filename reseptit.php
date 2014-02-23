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
        
    } elseif (isset($_GET['muokkaa']) && (onkoAdmin() || onkoMuokkaaja())){

        $ohjain->muokkaa($_GET['muokkaa']);
        
    } elseif (isset($_GET['paivita']) && (onkoAdmin() || onkoMuokkaaja())){

        $ohjain->tallenna('muokkaus', $_POST['nimi'], $_POST['kategoria'], 
                $_POST['raakaaine'], $_POST['maara'], $_POST['yksikko'], $_POST['annoksia'], $_POST['ohje'], $_POST['juomasuositus'], $_POST['lahde']);
        
    } elseif (isset($_GET['lisaa']) && (onkoAdmin() || onkoMuokkaaja())){
        
        $ohjain->lisaa();
        
    } elseif (isset($_GET['tallenna']) && (onkoAdmin() || onkoMuokkaaja())) {
        
        $ohjain->tallenna('lisays', $_POST['nimi'], $_POST['kategoria'], 
                $_POST['raakaaine'], $_POST['maara'], $_POST['yksikko'], $_POST['annoksia'], $_POST['ohje'], $_POST['juomasuositus'], $_POST['lahde']);
        
    } elseif (isset($_GET['poista']) && isset($_POST['id']) && (onkoMuokkaaja()) ){
        
        $ohjain->poista($_POST['id']);
        
    } elseif (isset($_GET['sivu']) && isset($_GET['nimi'])) {
    
        $ohjain->hae($_GET['sivu'], $_GET['nimi'], $_GET['kategoria'], $_GET['paaraakaaine']);
        
    } elseif (isset($_GET['sivu'])) {
    
        $ohjain->hae($_GET['sivu'], '', -1, -1);
        
    } elseif (isset($_GET['nimi'])) {
    
        $ohjain->hae(0, $_GET['nimi'], $_GET['kategoria'], $_GET['paaraakaaine']);
    }
        else {
        
        $ohjain->hae(0, '', -1, -1);
        
    }
}
