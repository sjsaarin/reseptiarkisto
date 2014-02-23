<?php

/**
 * Raaka-aineiden ohjain
 *
 * @author Sami-Joonas Saarinen
 */
class RaakaaineetOhjain {

    private $sivun_nimi = 'raakaaineet';
    private $title = "Raaka-aineet";

    public function nayta($id) {
        $raakaaine = Raakaaine::hae((int)$id);
        if ($raakaaine != null) {
            $_SESSION['raakaaine'] = $raakaaine;
            naytaNakyma("views/raakaaine_nayta.php", array(
                'sivu' => $this->sivun_nimi,
                'title' => $this->title,
                'raakaaine' => $raakaaine
            ));
        } else {
            $_SESSION['virhe'] = "Raaka-ainetta (id: ". $id .") ei löytynyt";
            header('Location: raakaaineet.php');   
        }
    }

    public function lisaa() {
        naytaNakyma("views/raakaaine_lomake.php", array(
            'sivu' => $this->sivun_nimi,
            'tila' => 'lisaa',
            'title' => $this->title
        ));
    }

    public function tallenna($tila, $nimi, $kalorit, $hiilarit, $proteiinit, $rasvat, $hinta, $tiheys, $kpl_paino) {
        if ($tila == 'lisaa') {
            $uusiraakaaine = new Raakaaine(null, null, null, null, null, null, null, null, null);
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
        $uusiraakaaine->setTiheys($tiheys);
        $uusiraakaaine->setKplPaino($kpl_paino);

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
            header('Location: raakaaineet.php?nayta=' . $uusiraakaaine->getId());
        } else {
            $virheet = $uusiraakaaine->getVirheet();
            naytaNakyma("views/raakaaine_lomake.php", array(
                'sivu' => $this->sivun_nimi,
                'tila' => $tila,
                'title' => $this->title,
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
                'title' => $this->title,
                'raakaaine' => $raakaaine
            ));
        } else {
            $_SESSION['virhe'] = 'Raaka-ainetta ei löytynyt';
            header('Location: raakaaineet.php');
        }
    }

    public function poista($id) {
        $raakaaine = $_SESSION['raakaaine'];
        $poistuiko = $raakaaine->poistaKannasta();
        if ($poistuiko) {
            unset($_SESSION['raakaaine']);
            $_SESSION['ilmoitus'] = "Raaka-aine poistettu onnistuneesti.";
            header('Location: raakaaineet.php');
        } else {
            naytaNakyma("views/raakaaine_nayta.php", array(
                'sivu' => $this->sivun_nimi,
                'virhe' => "Raaka-ainetta ei voi poistaa, se kuuluu johonkin reseptiin!",
                'title' => $this->title,
                'raakaaine' => $raakaaine));
        }
    }

    public function hae($sivu, $nimi) {

        $raakaaineet = Raakaaine::haeNimella($nimi, $sivu, 10);
        $lukumaara = Raakaaine::raakaaineidenLkm($nimi);
        $sivuja = ceil($lukumaara/10);
        naytaNakyma("views/raakaaine_listaa.php", array(
            'sivu' => $this->sivun_nimi,
            'title' => $this->title,
            'raakaaineet' => $raakaaineet,
            'sivuja' => $sivuja,
            'sivunro' => $sivu,
            'nimi' => $nimi
        ));
    }

}
