<?php
    
    include "naytavirheet.php";
    
    function naytaNakyma($sivu, $data = array()) {
        $data = (object)$data;
        require_once "views/pohja.php";
        exit();
    }
    
    function onkoKirjautunut(){
        if (isset($_SESSION['kayttaja'])){
            return true;
        } else {
            naytaNakyma('views/login.php');
        }
    }
    
    function onkoAdmin(){
        if ($_SESSION['kayttajan_rooli'] === 1){
            return true;
        } else {
            return false;
        }
    }
    
    function onkoOkLuku($syote) {
        $ok = is_numeric($syote) && $syote >= 0 && $syote < 10000; 
        return $ok;
        //return preg_match("/^[0-9]+$/", $syote);
    }
    