<?php

require_once 'libs/common.php';
require_once 'libs/tietokantayhteys.php';
require_once 'libs/models/Resepti.php';
require_once 'libs/models/Raakaaine.php';
require_once 'libs/models/Kategoria.php';

/**
 * Reseptien ohjain
 * 
 * @author Sami-Joonas Saarinen
 * 
 */
class ReseptitOhjain {

    private $resepti;
    private $sivun_nimi = "reseptit";

    /**
     * Näyttää reseptin tietonäkymän
     */
    public function nayta($id) {

        $id = (int) $id;

        $resepti = Resepti::hae($id);
        if ($resepti != null) {
            $raakaaineet = $resepti->haeRaakaaineet();
            $_SESSION['resepti'] = $resepti;
            naytaNakyma("views/resepti_nayta.php", array(
                'sivu' => $this->sivun_nimi,
                'title' => htmlspecialchars($resepti->getNimi()),
                'resepti' => $resepti,
                'raakaaineet' => $raakaaineet
            ));
        } else {
            naytaNakyma("views/resepti_nayta.php", array(
                'sivu' => $this->sivun_nimi,
                'title' => "Virhe!",
                'raakaaine' => null,
                'virhe' => 'Reseptiä ei löytynyt'
            ));
        }
    }

    /**
     * Näyttää reseptien muokkausnäkymän
     */
    public function muokkaa($id) {

        $resepti = Resepti::hae($id);
        $_SESSION['resepti'] = $resepti;
        $kategoriat_lista = Kategoria::haeKaikki();
        $raakaaineet_lista = Raakaaine::haeKaikki();
        $yksikot_lista = Resepti::haeYksikot();
        naytaNakyma("views/resepti_lomake.php", array(
            'tila' => 'muokkaus',
            'sivu' => $this->sivun_nimi,
            'title' => htmlspecialchars($resepti->getNimi()),
            'resepti' => $resepti,
            'kategoriat' => $kategoriat_lista,
            'raakaaineet' => $raakaaineet_lista,
            'yksikot' => $yksikot_lista,
            'asetetut_raakaaineet' => $resepti->getRaakaaineet(),
            'asetetut_maarat' => $resepti->getRaakaaineidenMaarat(),
            'asetetut_yksikot' => $resepti->getRaakaaineidenYksikot()
        ));
    }

    /**
     * Tallentaa reseptin
     */
    /*
    public function tallenna($nimi, $kategoria, $raakaaineet, $maarat, $yksikot, $annoksia, $ohje, $juomasuositus, $lahde) {
        $omistaja = (int) $_SESSION['kayttajan_id'];
        $paaraakaaine = $raakaaineet[0];
        $resepti = new Resepti(null, null, (int) $kategoria, $omistaja, $lahde, $juomasuositus, $ohje, null, $paaraakaaine);
        $resepti->setNimi($nimi);
        $resepti->setAnnoksia((int) $annoksia);
        $resepti->setRaakaaineet($raakaaineet, $maarat, $yksikot);
        if ($resepti->onkoKelvollinen()) {
            $resepti->lisaaKantaan();
            $this->naytaOk($resepti);
            /*
              $uusi
              $_SESSION['ilmoitus'] = "Resepti talennettu onnistuneesti.";
              header('Location: reseptit.php?nayta' . $uusiresepti->getId());
             * 
             */
     /*   } else {
            $this->naytaEiOk('lisays', $resepti);
            /*
              $kategoriat_lista = Kategoria::haeKaikki();
              $raakaaineet_lista = Raakaaine::haeKaikki();
              $yksikot_lista = Resepti::haeYksikot();
              naytaNakyma("views/resepti_lomake.php", array(
              'tila' => 'lisays',
              'virhe' => 'Reseptin lisääminen epäonnistui',
              'sivu' => $this->sivun_nimi,
              'virheet' => $uusiresepti->getVirheet(),
              'resepti' => $uusiresepti,
              'kategoriat' => $kategoriat_lista,
              'raakaaineet' => $raakaaineet_lista,
              'yksikot' => $yksikot_lista,
              'asetetut_maarat' => $uusiresepti->getRaakaaineidenMaarat(),
              'asetetut_raakaaineet' => $uusiresepti->getRaakaaineet(),
              'asetetut_yksikot' => $uusiresepti->getRaakaaineidenYksikot()
              )); 
        }
    }*/
    
    public function tallenna($tila, $nimi, $kategoria, $raakaaineet, $maarat, $yksikot, $annoksia, $ohje, $juomasuositus, $lahde){
        if ($tila == 'lisays'){
            $resepti = new Resepti(null, null, null, null, null, null, null, null, null);
            $resepti->setOmistaja((int) $_SESSION['kayttajan_id']);
        }
        if ($tila == 'muokkaus'){
            $resepti = $_SESSION['resepti'];
            $resepti->nollaaVirheet();
        }
        $resepti->setNimi($nimi);
        $resepti->setKategoria((int) $kategoria);
        $resepti->setRaakaaineet($raakaaineet, $maarat, $yksikot);
        $resepti->setAnnoksia((int) $annoksia);
        $resepti->setValmistusohje($ohje);
        $resepti->setJuomasuositus($juomasuositus);
        $resepti->setLahde($lahde);
        $resepti->setPaaraakaaine($raakaaineet[0]);
        if ($resepti->onkoKelvollinen()) {
            if ($tila == 'lisays'){
                $resepti->lisaaKantaan();
            }
            if ($tila == 'muokkaus'){
                $resepti->paivitaKantaan();
            }
            $this->naytaOk($resepti);
        } else {
            $this->naytaEiOk($tila, $resepti);
        }

    }
    /*
    public function paivita($nimi, $kategoria, $raakaaineet, $maarat, $yksikot, $annoksia, $ohje, $juomasuositus, $lahde) {

        $resepti = $_SESSION['resepti'];
        $resepti->nollaaVirheet();
        $resepti->setNimi($nimi);
        $resepti->setKategoria((int) $kategoria);
        $resepti->setRaakaaineet($raakaaineet, $maarat, $yksikot);
        $resepti->setAnnoksia((int) $annoksia);
        $resepti->setValmistusohje($ohje);
        $resepti->setJuomasuositus($juomasuositus);
        $resepti->setLahde($lahde);
        $resepti->setPaaraakaaine($raakaaineet[0]);
        if ($resepti->onkoKelvollinen()) {
            $resepti->paivitaKantaan();
            $this->naytaOk($resepti);
            /*
              $resepti->paivitaKantaan();
              $_SESSION['ilmoitus'] = "Resepti tallennettu onnistuneesti.";
              unset($_SESSION['resepti']);
              header('Location: reseptit.php?nayta=' . $resepti->getId()); */ /*
        } else {
            $this->naytaEiOk('muokkaus', $resepti);
            /*
              $kategoriat_lista = Kategoria::haeKaikki();
              $raakaaineet_lista = Raakaaine::haeKaikki();
              $yksikot_lista = Resepti::haeYksikot();
              naytaNakyma("views/resepti_lomake.php", array(
              'tila' => 'muokkaus',
              'virhe' => 'Reseptin tallennus epäonnistui',
              'sivu' => $this->sivun_nimi,
              'virheet' => $resepti->getVirheet(),
              'resepti' => $resepti,
              'kategoriat' => $kategoriat_lista,
              'raakaaineet' => $raakaaineet_lista,
              'yksikot' => $yksikot_lista,
              'asetetut_maarat' => $resepti->getRaakaaineidenMaarat(),
              'asetetut_raakaaineet' => $resepti->getRaakaaineet(),
              'asetetut_yksikot' => $resepti->getRaakaaineidenYksikot()
              ));
             
        }
    } */

    private function naytaOk($resepti) {
        $_SESSION['ilmoitus'] = "Resepti tallennettu onnistuneesti.";
        unset($_SESSION['resepti']);
        header('Location: reseptit.php?nayta=' . $resepti->getId());
    }

    private function naytaEiOk($tila, $resepti) {
        $kategoriat_lista = Kategoria::haeKaikki();
        $raakaaineet_lista = Raakaaine::haeKaikki();
        $yksikot_lista = Resepti::haeYksikot();
        naytaNakyma("views/resepti_lomake.php", array(
            'tila' => $tila,
            'virhe' => 'Reseptin tallennus epäonnistui',
            'sivu' => $this->sivun_nimi,
            'title' => htmlspecialchars($resepti->getNimi()),
            'kategoriat' => $kategoriat_lista,
            'raakaaineet' => $raakaaineet_lista,
            'yksikot' => $yksikot_lista,
            'virheet' => $resepti->getVirheet(),
            'resepti' => $resepti,
            'asetetut_maarat' => $resepti->getRaakaaineidenMaarat(),
            'asetetut_raakaaineet' => $resepti->getRaakaaineet(),
            'asetetut_yksikot' => $resepti->getRaakaaineidenYksikot()
        ));
    }

    /**
     * Näyttää reseptien lisäys näkymän
     */
    public function lisaa() {
        $kategoriat = Kategoria::haeKaikki();
        $raakaaineet = Raakaaine::haeKaikki();
        $yksikot = Resepti::haeYksikot();
        naytaNakyma("views/resepti_lomake.php", array(
            'sivu' => $this->sivun_nimi,
            'title' => 'Reseptin lisäys',
            'tila' => 'lisays',
            'kategoriat' => $kategoriat,
            'raakaaineet' => $raakaaineet,
            'yksikot' => $yksikot
        ));
    }

    /**
     * Poistaa reseptin
     */
    public function poista($id) {
        $id = (int) $id;
        $poistuiko = Resepti::poistaKannasta($id);
        if ($poistuiko) {
            $_SESSION['ilmoitus'] = "Resepti poistettu onnistuneesti.";
            header('Location: reseptit.php');
        } else {
            naytaNakyma("views/reseptit.php?nayta=$id", array(
                'title' => 'Virhe',
                'sivu' => $this->sivun_nimi,
                'virhe' => "Reseptin poisto epäonnistui!",
            ));
        }
    }

    public function lista($nimi, $kategoria, $paaraakaaine) {

        $reseptit = Resepti::haeReseptitListaan($nimi, (int) $kategoria, (int) $paaraakaaine);
        $kategoriat = Kategoria::haeKaikki();
        $paaraakaineet = Resepti::haePaaRaakaaineet();
        naytaNakyma("views/resepti_listaa.php", array(
            'sivu' => $this->sivun_nimi,
            'title' => "Reseptit",
            'reseptit' => $reseptit,
            'kategoriat' => $kategoriat,
            'paaraakaaineet' => $paaraakaineet,
            'lkm' => count($reseptit)
        ));
    }

}
