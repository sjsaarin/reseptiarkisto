<?php

include "libs/naytavirheet.php";

require_once 'libs/common.php';
require_once 'libs/tietokantayhteys.php';
require_once 'libs/models/resepti.php';

session_start();
if (onkoKirjautunut()) {

    if (isset($_GET['id'])) {
        
    } else {
        $reseptit = Resepti::getReseptit();
        $lukumaara = Resepti::reseptienLkm();
        naytaNakyma("views/resepti_listaa.php", array(
            'title' => "Reseptit",
            'reseptit' => $reseptit,
            'lkm' => $lukumaara
        ));
    }
}
