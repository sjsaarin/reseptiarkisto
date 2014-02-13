<?php

//debuggaukseen
include "libs/naytavirheet.php";

require_once 'libs/common.php';
require_once 'libs/tietokantayhteys.php';
require_once 'libs/models/kategoria.php';
require_once 'controllers/KategoriatOhjain.php';

$ohjain = new KategoriatOhjain();
session_start();
if (onkoKirjautunut()) {
    
     if (!onkoAdmin()){
         
         //tämän sivun ei tulis näkyä kuin admineille, joten jos ei ole admin ohjataan index.php:n
         header('Location: index.php');
         
     } 
     
     if (isset($_GET['lisaa'])){
        
        $ohjain->lisaa($_POST['nimi']);
        
    } elseif (isset($_POST['id'])) {
        
        $ohjain->poista($_POST['id']);
        
    } else {
  
        $ohjain->lista();
        
    }
    
}