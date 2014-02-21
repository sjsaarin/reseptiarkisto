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
            header('Location: kirjautuminen.php');
        }
    }
    
    function onkoAdmin(){
        return $_SESSION['kayttajan_rooli'] === 0;
    }
    
     function onkoMuokkaaja(){
        return $_SESSION['kayttajan_rooli'] <= 1;
    }
    
    function onkoKirjautunutKayttaja($id){
        return $_SESSION['kayttajan_id'] === $id;
    }
    

    