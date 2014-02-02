<?php 
    
    //näytetään virheet debuggausta varten
    include "libs/naytavirheet.php";
    
    require_once "libs/common.php";
  
    naytaNakyma("views/login.php", array('title' => "Kirjautuminen"));