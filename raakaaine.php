<?php
    
    include "libs/naytavirheet.php";
    
    require_once 'libs/common.php';
    require_once 'libs/tietokantayhteys.php';
    require_once 'libs/models/raakaaine.php';
    
    session_start();
    if (onkoKirjautunut()){
        $id = (int)$_GET['id'];
        
        $raakaaine = Raakaaine::hae($id);
        if ($raakaaine != null) {
            naytaNakyma("views/raakaaine_nayta.php", array(
                'raakaaine' => $raakaaine
            ));
        } else {
            naytaNakyma("views/raakaaine_nayta.php", array(
                'raakaaine' => null,
                'virhe' => 'Raaka-ainetta ei löytynyt'
            ));
        }
    }