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
    
    public function __construct() {
        //$this->resepti = new Resepti(null, null, null, null, null, null, null, null);
    }
    
    /**
     * Näyttää reseptin tietonäkymän
     */
    public function nayta($id){
        
        $id = (int)$id;
        
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
     * Näyttää listauksen kaikista resepteistä
     */
    public function lista(){
        $reseptit = Resepti::haeKaikki();
        $lukumaara = Resepti::reseptienLkm();
        $reseptit_nimilla = array();
        //haetaan taulukoon reseptien id:t, nimet sekä reseptien kategorioiden ja raaka-aineiden nimet.
        foreach($reseptit as $asia){
            $kategorian_nimi = Kategoria::haeNimi($asia->getKategoria());
            $raakaaineen_nimi = Raakaaine::haeNimi($asia->getPaaraakaaine());
            $tulos = array($asia->getId(), htmlspecialchars($asia->getNimi()), htmlspecialchars($kategorian_nimi), htmlspecialchars($raakaaineen_nimi));
            array_push($reseptit_nimilla, $tulos);
        }
        naytaNakyma("views/resepti_listaa.php", array(
            'sivu' => $this->sivun_nimi,
            'title' => "Reseptit",
            'reseptit' => $reseptit_nimilla,
            'lkm' => $lukumaara
        ));
    }
    
    /**
     * Näyttää reseptien muokkausnäkymän
     */
    public function muokkaa(){
        
    }
    
    /**
     * Näyttää reseptien lisäys näkymän
     */
    public function lisaa(){
        $kategoriat = Kategoria::haeKaikki();
        $raakaaineet = Raakaaine::haeKaikki();
        $yksikot = Resepti::haeYksikot();
        naytaNakyma("views/resepti_lomake.php", array(
            'sivu' => $this->sivun_nimi,
            'kategoriat' => $kategoriat,
            'raakaaineet' => $raakaaineet,
            'yksikot' => $yksikot
        ));
    }
    /**
     * Tallentaa reseptin
     */
    public function tallenna($nimi, $kategoria, $raakaaineet, $maarat, $yksikot, $paaraakaaine, $annoksia, $ohje, $juomasuositus, $lahde){
        $paaraakaaine = $raakaaineet[$paaraakaaine];
        $omistaja = (int)$_SESSION['kayttajan_id'];
        $uusiresepti = new Resepti(null, null, $kategoria, $omistaja, $lahde, $juomasuositus, $ohje, null, $paaraakaaine);
        $uusiresepti->setNimi($nimi);
        $uusiresepti->setAnnoksia($annoksia);
        $uusiresepti->setRaakaaineet($raakaaineet, $maarat, $yksikot);
        if ($uusiresepti->onkoKelvollinen()) {
            $uusiresepti->lisaaKantaan();
            $_SESSION['ilmoitus'] = "Resepti lisätty onnistuneesti.";
            header('Location: reseptit.php');
        } else {
            $kategoriat = Kategoria::haeKaikki();
            $raakaaineet = Raakaaine::haeKaikki();
            $yksikot = Resepti::haeYksikot();
            naytaNakyma("views/resepti_lomake.php", array(
                'virhe' => 'Reseptin lisääminen epäonnistui',
                'sivu' => $this->sivun_nimi,
                'virheet' => $uusiresepti->getVirheet(),
                'resepti' => $uusiresepti,
                'kategoriat' => $kategoriat,
                'raakaaineet' => $raakaaineet,
                'yksikot' => $yksikot
            ));
        }
    }

    
    /**
     * Poistaa reseptin
     */
    public function poista($id){
        $id = (int)$id;
        $poistuiko = Resepti::poistaKannasta($id);
        if ($poistuiko){
            $_SESSION['ilmoitus'] = "Resepti poistettu onnistuneesti.";
            header('Location: reseptit.php');
        } else {
            naytaNakyma("views/reseptit.php?nayta=$id", array(
                'sivu' => $sivun_nimi,
                'virhe' => "Reseptin poisto epäonnistui!",
            ));
        }
        
    }
}

