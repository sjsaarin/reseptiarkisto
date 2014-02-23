<?php

include "libs/naytavirheet.php";

require_once 'libs/common.php';
require_once 'libs/tietokantayhteys.php';
require_once 'libs/models/Raakaaine.php';
require_once 'controllers/RaakaaineetOhjain.php';

session_start();
if (onkoKirjautunut()) {
    
    $ohjain = new RaakaaineetOhjain();

    
    // raakaaineet.php?id
    if (isset($_GET['nayta'])) {
        
        $ohjain->nayta($_GET['nayta']);

    // raakaaineet.php?lisaa, jos kirjautunut käyttäjä ei ole admin ei näytetä
    } elseif (isset($_GET['uusi']) && onkoMuokkaaja()) {
        
        $ohjain->lisaa();
        
    // raakaaineet.php?tallenna, jos kirjautunut käyttäjä ei ole admin ei näytetä
    } elseif (isset($_GET['tallenna']) && onkoMuokkaaja()) {
        
        $ohjain->tallenna('lisaa', $_POST['nimi'], $_POST['kalorit'], $_POST['hiilarit'], $_POST['proteiinit'], $_POST['rasvat'], $_POST['hinta'], $_POST['tiheys'], $_POST['kpl_paino']);

    // raakaaineet.php?muokkaa
    } elseif (isset($_GET['muokkaa']) && onkoMuokkaaja()){
        
        $ohjain->muokkaa($_GET['muokkaa']);

    } elseif (isset($_GET['paivita']) && (int)$_GET['paivita']==$_SESSION['raakaaine']->getId() && onkoMuokkaaja()){
        
        $ohjain->tallenna('muokkaa', $_POST['nimi'], $_POST['kalorit'], $_POST['hiilarit'], $_POST['proteiinit'], $_POST['rasvat'], $_POST['hinta'], $_POST['tiheys'], $_POST['kpl_paino']);
        
    } elseif (isset($_GET['poista']) && isset($_POST['id']) && onkoMuokkaaja()){
        
        $ohjain->poista($_POST['id']);
    
    } elseif (isset($_GET['sivu']) && isset($_GET['hae'])) {

        $ohjain->hae($_GET['sivu'], $_GET['hae']);
        
    }  else if(isset($_GET['sivu'])){
    
        $ohjain->hae($_GET['sivu'], "");
        
    } else if(isset($_GET['hae'])){
    
        $ohjain->hae(0, $_GET['hae']);
        
    }else {
    
        $ohjain->hae(0, '');
    }  
    
}