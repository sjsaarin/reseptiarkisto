<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

/**
 * Reseptin malli
 */
class Resepti {
    private $id;
    private $nimi;
    private $kategoria;
    private $omistaja;
    private $lahde;
    private $juomasuositus;
    private $valmistusohje;
    private $annoksia;
    
    function __construct($id, $nimi, $kategoria, $omistaja, $lahde, $juomasuositus, $valmistusohje, $annoksia) {
        $this->id = $id;
        $this->nimi = $nimi;
        $this->kategoria = $kategoria;
        $this->omistaja = $omistaja;
        $this->lahde = $lahde;
        $this->juomasuositus = $juomasuositus;
        $this->valmistusohje = $valmistusohje;
        $this->annoksia = $annoksia;
    }
    
    /**
     * Palauttaa taulukun jossa on kaikki tietokannassa olevat reseptit, Resepti olioina.
     * 
     * @return taulukko
     */
    public static function haeKaikki(){
        $sql = "SELECT id, nimi from reseptit";
        $kysely = getTietokantayhteys()->prepare($sql); $kysely->execute();
    
        $tulokset = array();
            foreach($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {
                $resepti = new Resepti($tulos->id, $tulos->nimi, null, null, null, null, null, null); 
                $tulokset[] = $resepti;
            }
        return $tulokset;
        
    }
    
    /**
     * Palauttaa tietokantaan tallennettujen reseptien lukumäärn
     * 
     * @return int
     */
    public static function reseptienLkm(){
        $sql = "SELECT COUNT(*) from reseptit";
        $kysely = getTietokantayhteys()->prepare($sql); $kysely->execute();
        return $kysely->fetchColumn(0);
    }
    
    /**
     * Lisää raakaineen reseptiin
     * 
     * @param type $id
     */
    public static function lisaaRaakaaine($id){
        $sql = "INSERT into reseptin_raakaaineet";
    }
    
    public static function haeYksikot(){
        //yksiköt kovakoodattu tähän, ehkä syytä toteuttaa omana tauluna / jotenkin muuten?
        return array('maustemitta','teelusikka','ruokalusikka','millilitra','senttilitra','desi','litra','gramma','kilo');
    }
    
    public function getId() {
        return $this->id;
    }

    public function getNimi() {
        return $this->nimi;
    }

    public function getKategoria() {
        return $this->kategoria;
    }

    public function getOmistaja() {
        return $this->omistaja;
    }

    public function getLahde() {
        return $this->lahde;
    }

    public function getJuomasuositus() {
        return $this->juomasuositus;
    }

    public function getValmistusohje() {
        return $this->valmistusohje;
    }
    
    public function getPaaraakaaine() {
        return null;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setNimi($nimi) {
        $this->nimi = $nimi;
    }

    public function setKategoria($kategoria) {
        $this->kategoria = $kategoria;
    }

    public function setOmistaja($omistaja) {
        $this->omistaja = $omistaja;
    }

    public function setLahde($lahde) {
        $this->lahde = $lahde;
    }

    public function setJuomasuositus($juomasuositus) {
        $this->juomasuositus = $juomasuositus;
    }

    public function setValmistusohje($valmistusohje) {
        $this->valmistusohje = $valmistusohje;
    }

}
