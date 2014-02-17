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
    if (isset($_GET['id'])) {
        
        $ohjain->nayta($_GET['id']);

    // raakaaineet.php?lisaa, jos kirjautunut käyttäjä ei ole admin ei näytetä
    } elseif (isset($_GET['lisaa']) && onkoAdmin()) {
        
        $ohjain->lisaa();
        
    // raakaaineet.php?tallenna, jos kirjautunut käyttäjä ei ole admin ei näytetä
    } elseif (isset($_GET['tallenna']) && onkoAdmin()) {
        
        $ohjain->tallenna($_POST['nimi'], $_POST['kalorit'], $_POST['hiilarit'], $_POST['proteiinit'], $_POST['rasvat'], $_POST['hinta']);

    // raakaaineet.php?muokkaa
    } elseif (isset($_GET['muokkaa']) && onkoAdmin()){
        
        $ohjain->muokkaa($_GET['muokkaa']);

    } elseif (isset($_GET['paivita']) && (int)$_GET['paivita']==$_SESSION['raakaaine']->getId() && onkoAdmin()){
        
        $ohjain->paivita($_POST['nimi'], $_POST['kalorit'], $_POST['hiilarit'], $_POST['proteiinit'], $_POST['rasvat'], $_POST['hinta']);
        
    } elseif (isset($_GET['poista']) && (int)$_GET['poista']==$_SESSION['raakaaine']->getId() && onkoAdmin()){
        
        $ohjain->poista();
    
    } elseif (isset($_GET['hae'])) {

        $ohjain->hae($_GET['hae']);
        
    }  else {
        if (isset($_GET['sivu'])){
            $sivu = (int)$_GET['sivu'];
        } else {
            $sivu = 0;
        }
        $ohjain->lista($sivu);
    }  
    
}