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