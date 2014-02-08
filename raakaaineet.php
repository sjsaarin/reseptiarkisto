<?php

include "libs/naytavirheet.php";

require_once 'libs/common.php';
require_once 'libs/tietokantayhteys.php';
require_once 'libs/models/raakaaine.php';

session_start();
if (onkoKirjautunut()) {
    // raakaaineet.php?id
    if (isset($_GET['id'])) {
        $id = (int) $_GET['id'];

        $raakaaine = Raakaaine::hae($id);
        if ($raakaaine != null) {
            naytaNakyma("views/raakaaine_nayta.php", array(
                'title' => $raakaaine->getNimi(),
                'raakaaine' => $raakaaine
            ));
        } else {
            naytaNakyma("views/raakaaine_nayta.php", array(
                'title' => "Virhe!",
                'raakaaine' => null,
                'virhe' => 'Raaka-ainetta ei löytynyt'
            ));
        }
    // raakaaineet.php?lisaa, jos kirjautunut käyttäjä ei ole admin ei näytetä
    } elseif (isset($_GET['lisaa']) && onkoAdmin()) {
        naytaNakyma("views/raakaaine_lisaa.php", array(
            'title' => "Raaka-aineen lisäys",
        ));
    // raakaaineet.php?tallenna, jos kirjautunut käyttäjä ei ole admin ei näytetä
    } elseif (isset($_GET['tallenna']) && onkoAdmin()) {        
        $uusiraakaaine = new Raakaaine(null, null, null, null, null, null, null);
        $uusiraakaaine->setNimi($_POST['nimi']);
        //nämä tarkastukset vaativat parantelua
        $uusiraakaaine->setKalorit(is_numeric($_POST['kalorit']) ? (int) $_POST['kalorit'] : 'e');
        $uusiraakaaine->setHiilarit(is_numeric($_POST['hiilarit']) ? (int) $_POST['hiilarit'] : 'e');
        $uusiraakaaine->setProteiinit(is_numeric($_POST['proteiinit']) ? (int) $_POST['proteiinit'] : 'e');
        $uusiraakaaine->setRasvat(is_numeric($_POST['rasvat']) ? (int) $_POST['rasvat'] : 'e');
        $uusiraakaaine->setHinta(is_numeric($_POST['hinta']) ? (int) $_POST['hinta'] : 'e');

        if ($uusiraakaaine->onkoKelvollinen()) {
            $uusiraakaaine->lisaaKantaan();
            header('Location: raakaaineet.php');
            $_SESSION['ilmoitus'] = "Raaka-aine lisätty onnistuneesti.";
        } else {
            $virheet = $uusiraakaaine->getVirheet();
            naytaNakyma("views/raakaaine_lisaa.php", array(
                'title' => "Raaka-aineen lisäys",
                'virhe' => "Raaka-aineen tallennus epäonnistui!",
                'raakaaine' => $uusiraakaaine,
                'virheet' => $virheet
            ));
        }
    // raakaaineet.php?muokkaa
    } elseif (isset($_GET['muokkaa']) && onkoAdmin()){
        $id = (int) $_GET['muokkaa'];

        $raakaaine = Raakaaine::hae($id);
        if ($raakaaine != null) {
            $_SESSION['raakaaine'] = $raakaaine;
            naytaNakyma("views/raakaaine_muokkaa.php", array(
                'title' => $raakaaine->getNimi(),
                'raakaaine' => $raakaaine
            ));
        } else {
            naytaNakyma("views/raakaaine_nayta.php", array(
                'title' => "Virhe!",
                'raakaaine' => null,
                'virhe' => 'Raaka-ainetta ei löytynyt'
            ));
        }
    } elseif (isset($_GET['paivita']) && (int)$_GET['paivita']==$_SESSION['raakaaine']->getId() && onkoAdmin()){
        $uusiraakaaine = $_SESSION['raakaaine'];
        $uusiraakaaine->setNimi($_POST['nimi']);
        //nämä tarkastukset vaativat parantelua
        $uusiraakaaine->setKalorit(is_numeric($_POST['kalorit']) ? (int) $_POST['kalorit'] : 'e');
        $uusiraakaaine->setHiilarit(is_numeric($_POST['hiilarit']) ? (int) $_POST['hiilarit'] : 'e');
        $uusiraakaaine->setProteiinit(is_numeric($_POST['proteiinit']) ? (int) $_POST['proteiinit'] : 'e');
        $uusiraakaaine->setRasvat(is_numeric($_POST['rasvat']) ? (int) $_POST['rasvat'] : 'e');
        $uusiraakaaine->setHinta(is_numeric($_POST['hinta']) ? (int) $_POST['hinta'] : 'e');

        if ($uusiraakaaine->onkoKelvollinen()) {
            $uusiraakaaine->paivitaKantaan();
            header('Location: raakaaineet.php');
            $_SESSION['ilmoitus'] = "Raaka-aineen tiedot päivitetty onnistuneesti.";
        } else {
            $virheet = $uusiraakaaine->getVirheet();
            naytaNakyma("views/raakaaine_muokkaa.php", array(
                'title' => "Raaka-aineen lisäys",
                'virhe' => "Raaka-aineen tallennus epäonnistui!",
                'raakaaine' => $uusiraakaaine,
                'virheet' => $virheet
            ));
        }
        
    } elseif (isset($_GET['poista']) && onkoAdmin()){
        //!!!tähän tarvitaan joku varmistus poistamisesta, nyt liian helppoa.
        //pelkästään kirjoittamalla ?poista=x, raakaaine x poistuu kannasta
        //lisäksi epäonnistuneen poiston jälkeen pitää ohjata takaisin raaka-aineen tietoihin?
        $id = (int)$_GET['poista'];
        $poistuiko = Raakaaine::poistaKannasta(array($id));
        if ($poistuiko){
            header('Location: raakaaineet.php');
            $_SESSION['ilmoitus'] = "Raaka-aine poistettu onnistuneesti.";
        }
    } else {
        $raakaaineet = Raakaaine::getRaakaaineet();
        $lukumaara = Raakaaine::raakaaineidenLkm();
        naytaNakyma("views/raakaaine_listaa.php", array(
            'title' => "Raaka-aineet",
            'raakaaineet' => $raakaaineet,
            'lkm' => $lukumaara
        ));
    }
}