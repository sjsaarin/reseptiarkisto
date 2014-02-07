<?php

include "libs/naytavirheet.php";
    
require_once 'libs/common.php';
require_once 'libs/tietokantayhteys.php';
require_once 'libs/models/raakaaine.php';

$uusiraakaaine = new Raakaaine(null, null, null, null, null, null, null);
$uusiraakaaine->setNimi($_POST['nimi']);
$uusiraakaaine->setKalorit(is_numeric($_POST['kalorit']) ? (int)$_POST['kalorit'] : 'e');
$uusiraakaaine->setHiilarit(is_numeric($_POST['hiilarit']) ? (int)$_POST['hiilarit'] : 'e');
$uusiraakaaine->setProteiinit(is_numeric($_POST['proteiinit']) ? (int)$_POST['proteiinit'] : 'e');
$uusiraakaaine->setRasvat(is_numeric($_POST['rasvat']) ? (int)$_POST['rasvat'] : 'e');
$uusiraakaaine->setHinta(is_numeric($_POST['hinta']) ? (int)$_POST['hinta'] : 'e');

if ($uusiraakaaine->onkoKelvollinen()) {
    $uusiraakaaine->lisaaKantaan();
    header('Location: raakaaineet.php');
    $_SESSION['ilmoitus'] = "Raaka-aine lisätty onnistuneesti.";
} else {
    $virheet = $uusiraakaaine->getVirheet();
    naytaNakyma("views/raakaaine_lisaa.php", array(
        'virhe' => "VIRHE!",
        'raakaaine' => $uusiraakaaine,
        'virheet' => $virheet
    ));
}