<?php

/**
 * Kayttajien ohjain
 *
 * @author Sami-Joonas Saarinen
 */

require_once 'libs/models/Kayttaja.php';

class KayttajatOhjain {
    
    private $sivun_nimi = 'kayttajat';
    private $title = 'Käyttäjät';
    
    public function lista($hakusana, $sivu){
        $kayttajat = Kayttaja::haeKayttajat($hakusana);
        naytaNakyma("views/kayttaja_listaa.php", array(
           'title' => $this->title,
           'sivun_nimi' => $this->sivun_nimi,
           'kayttajat' => $kayttajat 
        ));
    }
    
    public function nayta($id){
        $kayttaja = Kayttaja::hae($id);
        if (isset($kayttaja)){
            naytaNakyma("views/kayttaja_nayta.php", array(
                'title' => $kayttaja->getNimi(),
                'sivun_nimi' => $this->sivun_nimi,
                'kayttaja' => $kayttaja 
            ));
        } else {
            naytaNakyma("views/kayttaja_nayta.php", array(
                'title' => "Virhe",
                'virhe' => 'Käyttäjää ei löydy',
                'sivun_nimi' => $this->sivun_nimi,
                'kayttaja' => $kayttaja 
            ));
        }
    }
    
    public function lisaa(){
        
    }
    
    public function muokkaa(){
        
    }
    
    public function tallenna(){
        
    }
    
}
