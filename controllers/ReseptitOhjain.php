<?php

require_once 'libs/common.php';
require_once 'libs/tietokantayhteys.php';
require_once 'libs/models/resepti.php';

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
        $this->resepti = new Resepti(null, null, null, null, null, null, null, null);
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
        $reseptit = Resepti::getReseptit();
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
     * Tallentaa reseptin
     */
    public function tallenna(){
        
    }
    
    /**
     * Poistaa reseptin
     */
    public function poista(){
        
    }
}

