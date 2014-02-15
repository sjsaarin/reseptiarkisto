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
        
        $ohjain->nayta();
        
    } elseif (isset($_GET['muokkaa'])){
        naytaNakyma("views/resepti_muokkaa.php", array(
        ));
    } elseif (isset($_GET['lisaa'])){
        
        $ohjain->lisaa();
        
    } elseif (isset($_GET['tallenna'])) {
        
        $ohjain->tallenna($_POST['nimi'], (int)$_POST['kategoria'], 
                $_POST['raakaaine'], $_POST['maara'], $_POST['yksikko'], (int)$_POST['paaraakaaine'],
                (int)$_POST['annoksia'], $_POST['ohje'], $_POST['juomasuositus'], $_POST['lahde']);
        
    } else {
        
        $ohjain->lista();
        
    }
}
