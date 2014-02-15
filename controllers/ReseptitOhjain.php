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
    public function nayta(){
        naytaNakyma("views/resepti_nayta.php", array(
            'sivu' => $this->sivun_nimi
        ));
    }
    
    
    /**
     * Näyttää listauksen kaikista resepteistä
     */
    public function lista(){
        $reseptit = Resepti::haeKaikki();
        $lukumaara = Resepti::reseptienLkm();
        naytaNakyma("views/resepti_listaa.php", array(
            'sivu' => $this->sivun_nimi,
            'title' => "Reseptit",
            'reseptit' => $reseptit,
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
        naytaNakyma("views/resepti_lisaa.php", array(
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
        $omistaja = $_SESSION['kayttajan_id'];
        $uusiresepti = new Resepti(null, null, $kategoria, $omistaja, $lahde, $juomasuositus, $ohje, null, $paaraakaaine);
        $uusiresepti->setNimi($nimi);
        $uusiresepti->setAnnoksia($annoksia);
        $uusiresepti->setRaakaaineet($raakaaineet, $maarat, $yksikot);
        $uusiresepti->lisaaKantaan();
        header('Location: reseptit.php');
        //new Resepti($id, $nimi, $kategoria, $omistaja, $lahde, $juomasuositus, $valmistusohje, $annoksia, $paaraakaaine)
        /*naytaNakyma("views/resepti_testi.php", array(
            'nimi' => $nimi, 
            'kategoria' => $kategoria, 
            'raakaaine' => $raakaaine, 
            'maara' => $maara, 
            'yksikko' => $yksikko,
            'paaraakaaine' => $paaraakaaine,
            'annoksia' => $annoksia,
            'ohje' => $ohje, 
            'juomasuositus' => $juomasuositus, 
            'lahde' => $lahde
        ));*/
    }
    
    /**
     * Poistaa reseptin
     */
    public function poista(){
        
    }
}

