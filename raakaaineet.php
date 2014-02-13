<?php

include "libs/naytavirheet.php";

require_once 'libs/common.php';
require_once 'libs/tietokantayhteys.php';
require_once 'libs/models/Raakaaine.php';

session_start();
if (onkoKirjautunut()) {
    
    $sivun_nimi = "raakaaineet";
    
    // raakaaineet.php?id
    if (isset($_GET['id'])) {
        $id = (int) $_GET['id'];

        $raakaaine = Raakaaine::hae($id);
        if ($raakaaine != null) {
            $_SESSION['raakaaine'] = $raakaaine;
            naytaNakyma("views/raakaaine_nayta.php", array(
                'sivu' => $sivun_nimi,
                'title' => htmlspecialchars($raakaaine->getNimi()),
                'raakaaine' => $raakaaine
            ));
        } else {
            naytaNakyma("views/raakaaine_nayta.php", array(
                'sivu' => $sivun_nimi,
                'title' => "Virhe!",
                'raakaaine' => null,
                'virhe' => 'Raaka-ainetta ei löytynyt'
            ));
        }
    // raakaaineet.php?lisaa, jos kirjautunut käyttäjä ei ole admin ei näytetä
    } elseif (isset($_GET['lisaa']) && onkoAdmin()) {
        naytaNakyma("views/raakaaine_lisaa.php", array(
            'sivu' => $sivun_nimi,
            'title' => "Raaka-aineen lisäys",
        ));
    // raakaaineet.php?tallenna, jos kirjautunut käyttäjä ei ole admin ei näytetä
    } elseif (isset($_GET['tallenna']) && onkoAdmin()) {        
        $uusiraakaaine = new Raakaaine(null, null, null, null, null, null, null);
        $uusiraakaaine->setNimi($_POST['nimi']);
        $uusiraakaaine->setKalorit($_POST['kalorit']);
        $uusiraakaaine->setHiilarit($_POST['hiilarit']);
        $uusiraakaaine->setProteiinit($_POST['proteiinit']);
        $uusiraakaaine->setRasvat($_POST['rasvat']);
        $uusiraakaaine->setHinta($_POST['hinta']);

        if ($uusiraakaaine->onkoKelvollinen()) {
            $uusiraakaaine->lisaaKantaan();
            $_SESSION['ilmoitus'] = "Raaka-aine lisätty onnistuneesti.";
            header('Location: raakaaineet.php');
        } else {
            $virheet = $uusiraakaaine->getVirheet();
            naytaNakyma("views/raakaaine_lisaa.php", array(
                'sivu' => $sivun_nimi,
                'title' => "Raaka-aineen lisäys",
                'virhe' => "Raaka-aineen tallennus epäonnistui!",
                'raakaaine' => $uusiraakaaine,
                'virheet' => $virheet
            ));
        }
    // raakaaineet.php?muokkaa
    } elseif (isset($_GET['muokkaa']) && onkoAdmin()){
        
        $id = (int)$_GET['muokkaa'];

        $raakaaine = Raakaaine::hae($id);
        if ($raakaaine != null) {
            $_SESSION['raakaaine'] = $raakaaine;
            naytaNakyma("views/raakaaine_muokkaa.php", array(
                'sivu' => $sivun_nimi,
                'title' => htmlspecialchars($raakaaine->getNimi()),
                'raakaaine' => $raakaaine
            ));
        } else {
            naytaNakyma("views/raakaaine_nayta.php", array(
                'sivu' => $sivun_nimi,
                'title' => "Virhe!",
                'raakaaine' => null,
                'virhe' => 'Raaka-ainetta ei löytynyt'
            ));
        }
    } elseif (isset($_GET['paivita']) && (int)$_GET['paivita']==$_SESSION['raakaaine']->getId() && onkoAdmin()){
        $uusiraakaaine = $_SESSION['raakaaine'];
        $uusiraakaaine->setNimi($_POST['nimi']);
        $uusiraakaaine->setKalorit($_POST['kalorit']);
        $uusiraakaaine->setHiilarit($_POST['hiilarit']);
        $uusiraakaaine->setProteiinit($_POST['proteiinit']);
        $uusiraakaaine->setRasvat($_POST['rasvat']);
        $uusiraakaaine->setHinta($_POST['hinta']);

        if ($uusiraakaaine->onkoKelvollinen()) {
            unset($_SESSION['raakaaine']);
            $uusiraakaaine->paivitaKantaan();
            $_SESSION['ilmoitus'] = "Raaka-aineen tiedot päivitetty onnistuneesti.";
            header('Location: raakaaineet.php');
        } else {
            $virheet = $uusiraakaaine->getVirheet();
            naytaNakyma("views/raakaaine_muokkaa.php", array(
                'sivu' => $sivun_nimi,
                'title' => "Raaka-aineen lisäys",
                'virhe' => "Raaka-aineen tallennus epäonnistui!",
                'raakaaine' => $uusiraakaaine,
                'virheet' => $virheet
            ));
        }
        
    } elseif (isset($_GET['poista']) && (int)$_GET['poista']==$_SESSION['raakaaine']->getId() && onkoAdmin()){
        $raakaaine = $_SESSION['raakaaine'];
        unset($_SESSION['raakaaine']);
        $poistuiko = $raakaaine->poistaKannasta();
        if ($poistuiko){
            $_SESSION['ilmoitus'] = "Raaka-aine poistettu onnistuneesti.";
            header('Location: raakaaineet.php');
        } else {
            naytaNakyma("views/raakaaine_nayta.php", array(
                'sivu' => $sivun_nimi,
                'virhe' => "Raaka-ainetta ei voi poistaa, se kuuluu johonkin reseptiin!",
                'title' => htmlspecialchars($raakaaine->getNimi()),
                'raakaaine' => $raakaaine    ));
        }
    } if (isset($_GET['hae'])) {
        $nimi = $_GET['hae'];
        $raakaaineet = Raakaaine::haeNimella($nimi);
        //$lukumaara = Raakaaine::raakaaineidenLkm();
        naytaNakyma("views/raakaaine_listaa.php", array(
            'sivu' => $sivun_nimi,
            'title' => "Raaka-aineet",
            'raakaaineet' => $raakaaineet,
            'lkm' => count($raakaaineet)
        ));
        
    } else {
        if (isset($_GET['sivu'])){
            $sivu = (int)$_GET['sivu'];
        } else {
            $sivu = 0;
        }
        $raakaaineet = Raakaaine::haeSivu($sivu, 10);
        $lukumaara = Raakaaine::raakaaineidenLkm();
        naytaNakyma("views/raakaaine_listaa.php", array(
            'sivu' => $sivun_nimi,
            'title' => "Raaka-aineet",
            'raakaaineet' => $raakaaineet,
            'lkm' => $lukumaara
        ));
    } 
    
}