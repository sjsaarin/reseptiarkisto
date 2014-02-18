<?php

require_once 'libs/common.php';
require_once 'libs/tietokantayhteys.php';
require_once 'libs/models/Resepti.php';

class OstoslistaOhjain {

    private $sivun_nimi = 'ostoslista';

    public function lisaa($listalle) {
        if (!(isset($_SESSION['ostoslista']))) {
            $_SESSION['ostoslista'] = array();
        }
        $raakaaineet = Resepti::haeRaakaaineetHinnalla($listalle);
        foreach ($raakaaineet as $rivi) {
            array_push($_SESSION['ostoslista'], $rivi);
        }
        $_SESSION['ilmoitus'] = "Reseptin raaka-aineet lisätty ostoslistalle";
        header('Location: ostoslista.php');
    }

    public function tyhjenna() {
        unset($_SESSION['ostoslista']);
        $_SESSION['ilmoitus'] = "Ostoslista tyhjennetty";
        header('Location: reseptit.php');
    }

    public function nayta() {
        naytaNakyma('views/ostoslista.php', array(
            'title' => 'Ostoslista',
            'sivu' => 'ostoslista'
        ));
    }

}
