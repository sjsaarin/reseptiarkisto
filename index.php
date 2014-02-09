<?php 
    
    //näytetään virheet debuggausta varten
    include "libs/naytavirheet.php";
    
    require_once "libs/common.php";
    
    session_start();
    if (onkoKirjautunut()){
        header('Location: raakaaineet.php');
    }