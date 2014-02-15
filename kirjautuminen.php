<?php

    include "libs/naytavirheet.php";
    
    require_once 'libs/common.php';
    require_once 'libs/tietokantayhteys.php';
    require_once 'libs/models/kayttaja.php';
    
    session_start();
    if (isset($_GET['login'])){
    
        if (empty($_POST["username"])){
            naytaNakyma("views/kirjautuminen.php", array(
                'title' => "Kirjautuminen",
                'virhe' => "Kirjautuminen epäonnistui! Et antanut käyttäjätunnusta." 
                ));
            exit();
        }
        $kayttajatunnus = $_POST["username"];
    
        if (empty($_POST["password"])){
            naytaNakyma("views/kirjautuminen.php", array(
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
            $_SESSION['kayttajan_rooli']=$kayttaja->getRooli();
            $_SESSION['kayttajan_id']=$kayttaja->getId();
            header('Location: kayttaja.php');
        } else {
            naytaNakyma("views/kirjautuminen.php", array(
                'title' => "Kirjautuminen",
                'kayttaja' => $kayttajatunnus,
                'virhe' => "Kirjautuminen epäonnistui! Antamasi tunnus tai salasana on väärä."
        ));
        } 
    } elseif (isset($_GET['logout'])) {
        unset($_SESSION['kayttaja']);
        unset($_SESSION['kayttajan_rooli']);

        header('Location: kirjautuminen.php');
    } else {
        naytaNakyma("views/kirjautuminen.php");
    }
    
    