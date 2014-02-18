<?php

/**
 * Raaka-aineiden ohjain
 *
 * @author Sami-Joonas Saarinen
 */
class RaakaaineetOhjain {

    private $sivun_nimi = 'raaka-aineet';

    public function nayta($id) {

        $id = (int) $id;

        $raakaaine = Raakaaine::hae($id);
        if ($raakaaine != null) {
            $_SESSION['raakaaine'] = $raakaaine;
            naytaNakyma("views/raakaaine_nayta.php", array(
                'sivu' => $this->sivun_nimi,
                'title' => htmlspecialchars($raakaaine->getNimi()),
                'raakaaine' => $raakaaine
            ));
        } else {
            naytaNakyma("views/raakaaine_nayta.php", array(
                'sivu' => $this->sivun_nimi,
                'title' => "Virhe!",
                'raakaaine' => null,
                'virhe' => 'Raaka-ainetta ei löytynyt'
            ));
        }
    }

    public function lista($sivu) {
        $raakaaineet = Raakaaine::haeSivu($sivu, 10);
        $lukumaara = Raakaaine::raakaaineidenLkm();
        naytaNakyma("views/raakaaine_listaa.php", array(
            'sivu' => $this->sivun_nimi,
            'title' => "Raaka-aineet",
            'raakaaineet' => $raakaaineet,
            'lkm' => $lukumaara
        ));
    }

    public function lisaa() {
        naytaNakyma("views/raakaaine_lomake.php", array(
            'sivu' => $this->sivun_nimi,
            'tila' => 'lisaa',
            'title' => "Raaka-aineen lisäys",
        ));
    }

    public function tallenna($tila, $nimi, $kalorit, $hiilarit, $proteiinit, $rasvat, $hinta) {
        if ($tila == 'lisaa') {
            $uusiraakaaine = new Raakaaine(null, null, null, null, null, null, null);
        }
        if ($tila == 'muokkaa') {
            $uusiraakaaine = $_SESSION['raakaaine'];
        }
        $uusiraakaaine->setNimi($nimi);
        $uusiraakaaine->setKalorit($kalorit);
        $uusiraakaaine->setHiilarit($hiilarit);
        $uusiraakaaine->setProteiinit($proteiinit);
        $uusiraakaaine->setRasvat($rasvat);
        $uusiraakaaine->setHinta($hinta);

        if ($uusiraakaaine->onkoKelvollinen()) {
            if ($tila == 'lisaa') {
                $uusiraakaaine->lisaaKantaan();
                $_SESSION['ilmoitus'] = "Raaka-aine lisätty onnistuneesti.";
            }
            if ($tila == 'muokkaa') {
                unset($_SESSION['raakaaine']);
                $uusiraakaaine->paivitaKantaan();
                $_SESSION['ilmoitus'] = "Raaka-aineen tiedot päivitetty onnistuneesti.";
            }
            header('Location: raakaaineet.php');
        } else {
            $virheet = $uusiraakaaine->getVirheet();
            naytaNakyma("views/raakaaine_lomake.php", array(
                'sivu' => $this->sivun_nimi,
                'tila' => $tila,
                'title' => htmlspecialchars($uusiraakaaine->getNimi()),
                'virhe' => "Raaka-aineen tallennus epäonnistui!",
                'raakaaine' => $uusiraakaaine,
                'virheet' => $virheet
            ));
        }
    }

    public function muokkaa($id) {

        $id = (int) $id;

        $raakaaine = Raakaaine::hae($id);
        if ($raakaaine != null) {
            $_SESSION['raakaaine'] = $raakaaine;
            naytaNakyma("views/raakaaine_lomake.php", array(
                'sivu' => $this->sivun_nimi,
                'tila' => 'muokkaa',
                'title' => htmlspecialchars($raakaaine->getNimi()),
                'raakaaine' => $raakaaine
            ));
        } else {
            naytaNakyma("views/raakaaine_nayta.php", array(
                'sivu' => $this->sivun_nimi,
                'title' => "Virhe!",
                'raakaaine' => null,
                'virhe' => 'Raaka-ainetta ei löytynyt'
            ));
        }
    }

    public function poista() {
        $raakaaine = $_SESSION['raakaaine'];
        unset($_SESSION['raakaaine']);
        $poistuiko = $raakaaine->poistaKannasta();
        if ($poistuiko) {
            $_SESSION['ilmoitus'] = "Raaka-aine poistettu onnistuneesti.";
            header('Location: raakaaineet.php');
        } else {
            naytaNakyma("views/raakaaine_nayta.php", array(
                'sivu' => $this->sivun_nimi,
                'virhe' => "Raaka-ainetta ei voi poistaa, se kuuluu johonkin reseptiin!",
                'title' => htmlspecialchars($raakaaine->getNimi()),
                'raakaaine' => $raakaaine));
        }
    }

    public function hae($nimi) {

        $raakaaineet = Raakaaine::haeNimella($nimi);
        naytaNakyma("views/raakaaine_listaa.php", array(
            'sivu' => $this->sivun_nimi,
            'title' => "Raaka-aineet",
            'raakaaineet' => $raakaaineet,
            'lkm' => count($raakaaineet)
        ));
    }

}
