<?php

    require 'libs/common.php';
    require 'controllers/OstoslistaOhjain.php';
    
    session_start();
    if (onkoKirjautunut()) {
    
        $ohjain = new OstoslistaOhjain();
    
        if (isset($_POST['resepti'])){
            
            $ohjain->lisaa($_POST['resepti']);
            
        } elseif (isset($_GET['tyhjenna'])){
            
            $ohjain->tyhjenna();  
            
        } else {
            
            $ohjain->nayta();
            
        }
    }