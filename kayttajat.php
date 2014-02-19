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
   
} elseif (isset($_GET['id']) && (onkoAdmin() || onkoKirjautunutKayttaja($_GET['id']))){

    $ohjain->nayta($_GET['id']);
    
} elseif(isset($_GET['salasana'])) {
    
elseif(onkoAdmin()) {
    
    $ohjain->lista('',1);
    
} else {
    
    header('Location: reseptit.php');
    
}
}