<?php

    include "libs/naytavirheet.php";
    
    require_once 'libs/common.php';
    require_once 'libs/tietokantayhteys.php';
    require_once 'libs/models/kayttaja.php';
    
    if (empty($_POST["username"])){
        naytaNakyma("views/login.php", array(
            'title' => "Kirjautuminen",
            'virhe' => "Kirjautuminen epäonnistui! Et antanut käyttäjätunnusta." 
            ));
        exit();
    }
    $kayttajatunnus = $_POST["username"];
    
    if (empty($_POST["password"])){
        naytaNakyma("views/login.php", array(
            'title' => "Kirjautuminen",
            'kayttaja' => $kayttajatunnus,
            'virhe' => "Kirjautuminen epäonnistui! Et antanut salasanaa."
            ));
        exit();
    }
    $salasana = $_POST["password"];
    
    $kayttaja = Kayttaja::getKayttajaTunnuksilla($kayttajatunnus, $salasana);
    
    if (!empty($kayttaja)){
        session_start();
        $_SESSION['kayttaja']=$kayttaja;
        header('Location: listaustesti.php');
    } else {
        naytaNakyma("views/login.php", array(
            'title' => "Kirjautuminen",
            'kayttaja' => $kayttajatunnus,
            'virhe' => "Kirjautuminen epäonnistui! Antamasi tunnus tai salasana on väärä."
        ));
    }