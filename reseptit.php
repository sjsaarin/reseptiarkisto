<?php

//debuggaukseen
include "libs/naytavirheet.php";

require_once 'libs/common.php';
require_once 'libs/tietokantayhteys.php';
require_once 'libs/models/resepti.php';

session_start();
if (onkoKirjautunut()) {
    $sivun_nimi = 'reseptit';
    if (isset($_GET['nayta'])) {
        naytaNakyma("views/resepti_nayta.php", array(
            'sivu' => $sivun_nimi
        ));
    } elseif (isset($_GET['muokkaa'])){
        naytaNakyma("views/resepti_muokkaa.php", array(
            'sivu' => $sivun_nimi
        ));
    } elseif (isset($_GET['lisaa'])){
        naytaNakyma("views/resepti_lisaa.php", array());
    } else {
        $reseptit = Resepti::getReseptit();
        $lukumaara = Resepti::reseptienLkm();
        naytaNakyma("views/resepti_listaa.php", array(
            'sivu' => $sivun_nimi,
            'title' => "Reseptit",
            'reseptit' => $reseptit,
            'lkm' => $lukumaara
        ));
    }
}
