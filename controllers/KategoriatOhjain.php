<?php

require_once 'libs/common.php';
require_once 'libs/tietokantayhteys.php';
require_once 'libs/models/Kategoria.php';

class KategoriatOhjain {

    private $kategoria;
    private $kategoriat;
    private $sivun_nimi = "kategoriat";
    
    public function __construct() {
        $this->kategoria = new Kategoria(null, null);
    }
    
    public function lista(){
        $this->haeKaikki();
        naytaNakyma("views/kategoriat.php", array(
            'sivu' => $this->sivun_nimi,
            'kategoriat' => $this->kategoriat
        ));
    }
    
    public function lisaa($nimi){
        $uusikategoria = new Kategoria(null, null);
        $uusikategoria->setNimi($nimi);

        if ($uusikategoria->onkoKelvollinen()) {
            $uusikategoria->lisaaKantaan();
            $_SESSION['ilmoitus'] = "Kategoria lisätty onnistuneesti.";
            header('Location: kategoriat.php');
        } else {
            $this->haeKaikki();
            $virheet = $uusikategoria->getVirheet();
            naytaNakyma("views/kategoriat.php", array(
                'sivu' => $this->sivun_nimi,
                'kategoriat' => $this->kategoriat,
                'virhe' => "Kategorian tallennus epäonnistui!",
                'kategoria' => $uusikategoria,
                'virheet' => $virheet
            ));
        }
    }
    
    public function poista($id){
        $poistuiko = Kategoria::poistaKannasta($id);
        if ($poistuiko){
            $_SESSION['ilmoitus'] = "Kategoria poistettu onnistuneesti.";
            header('Location: kategoriat.php');
        } else {
            naytaNakyma("views/kategoriat.php", array(
                'sivu' => $sivun_nimi,
                'virhe' => "Kategoriaa ei voi poistaa, se kuuluu johonkin reseptiin!",
            ));
        }
        
    }
    
    private function haeKaikki(){
        $this->kategoriat = Kategoria::haeKaikki();
    }
    
}
