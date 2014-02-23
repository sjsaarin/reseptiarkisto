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
            $_SESSION['virhe'] = "Reseptiä (id: " .$id. "ei löytynyt";
            header('Location: reseptit.php');
        }
    }

    /**
     * Näyttää reseptien muokkausnäkymän
     */
    public function muokkaa($id, $muokkaaja) {

        $resepti = Resepti::hae((int)$id);
        if ($this->saakoMuokataTaiPoistaa($resepti, $muokkaaja)){
            $this->naytaMuokkaus($resepti);
        } else {
            $_SESSION['virhe'] = "Et voi muokata reseptiä, et ole reseptin omistaja";
            header('Location: reseptit.php?nayta=' . $id);
        }    

    }
    
    private function naytaMuokkaus($resepti){
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
    * Poistaa reseptin, vain reseptin omistaja tai admin voi poistaa reseptin
    */
    public function poista($id, $poistaja) {
        $resepti = Resepti::hae((int)$id);
        if ($this->saakoMuokataTaiPoistaa($resepti, $poistaja)){
            $resepti->poistaKannasta();
            $_SESSION['ilmoitus'] = "Resepti poistettu onnistuneesti.";
            header('Location: reseptit.php');
        } else {
            $_SESSION['virhe'] = "Reseptin poisto epäonnistui, et ehkä ole reseptin omistaja!";
            header('Location: reseptit.php?nayta=' . $id);
        }
    }
    
    private function saakoMuokataTaiPoistaa($resepti, $muokkaaja){
        $reseptin_omistaja = $resepti->getOmistaja();
        return (($reseptin_omistaja === $muokkaaja) || onkoAdmin());
    }
    
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



    public function hae($sivu, $nimi, $kategoria, $paaraakaaine) {

        $reseptit = Resepti::haeReseptitListaan($nimi, (int) $kategoria, (int) $paaraakaaine, (int)$sivu, 10);
        $lukumaara = Resepti::haeReseptienLukumaara($nimi, (int) $kategoria, (int) $paaraakaaine);
        $kategoriat = Kategoria::haeKaikki();
        $paaraakaineet = Resepti::haePaaRaakaaineet();
        $hakusanat = array($nimi, $kategoria, $paaraakaaine);
        $sivuja = ceil($lukumaara/10);
        naytaNakyma("views/resepti_listaa.php", array(
            'sivu' => $this->sivun_nimi,
            'title' => "Reseptit",
            'reseptit' => $reseptit,
            'kategoriat' => $kategoriat,
            'paaraakaaineet' => $paaraakaineet,
            'sivuja' => $sivuja,
            'sivunro' => $sivu,
            'nimi' => $nimi,
            'kategoria' => $kategoria,
            'paaraakaaine' => $paaraakaaine,
            'hakusanat' => $hakusanat
        ));
    }

}
