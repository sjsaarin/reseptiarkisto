<?php

include "libs/naytavirheet.php";

require_once 'libs/tietokantayhteys.php';
require_once 'libs/common.php';
require_once 'controllers/KayttajatOhjain.php';

$ohjain = new KayttajatOhjain();

session_start();
if (onkoKirjautunut()) {
if (isset($_GET['hae']) && onkoAdmin() ){
    
    $ohjain->lista($_GET['hae'],1);
   
} elseif (isset($_GET['salasana'])){ 
        //&& (isset($_POST['salasana']) || isset($_POST['salasana_uusi']) || isset($_POST['salasana_vahvistus']))) {
    
    $ohjain->vaihdaSalasana($_POST['salasana'], $_POST['salasana_uusi'], $_POST['salasana_vahvistus']);
    
} elseif (isset($_GET['omat_tiedot'])){

    $ohjain->nayta($_SESSION['kayttajan_id']);
    
} elseif (isset($_GET['uusi']) && onkoAdmin()) {
    
    $ohjain->lisaa();
    
} elseif (isset($_GET['lisaa']) && onkoAdmin()){
  
$ohjain->tallenna('lisaa', NULL, $_POST['etunimi'], $_POST['sukunimi'], $_POST['rooli'], $_POST['kayttajatunnus'], $_POST['salasana1'], $_POST['salasana2']);
    
} elseif (isset($_GET['poista']) && isset($_POST['id']) && onkoAdmin()) {
    
    $ohjain->poista($_POST['id']);
    
} elseif (isset($_GET['muokkaa']) && onkoAdmin()) {
    
    $ohjain->muokkaa($_GET['muokkaa']);
    
} elseif (isset($_GET['paivita']) && onkoAdmin()) {
    
    $ohjain->tallenna('muokkaa', $_GET['paivita'], $_POST['etunimi'], $_POST['sukunimi'], $_POST['rooli'], $_POST['kayttajatunnus'], $_POST['salasana1'], $_POST['salasana2']);
    
} elseif (onkoAdmin()) {
    
    $ohjain->lista('',1);
    
} else {
    
    header('Location: reseptit.php');
    
}
}