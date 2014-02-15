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
    private $paaraakaaine;
    
    private $raakaaineet;
    private $raakaaineiden_maarat;
    private $raakaaineiden_yksikot;
    
    private $raakaaineiden_lkm = 10;
    
    private $virheet = array();
    
    
    function __construct($id, $nimi, $kategoria, $omistaja, $lahde, $juomasuositus, $valmistusohje, $annoksia, $paaraakaaine) {
        $this->id = $id;
        $this->nimi = $nimi;
        $this->kategoria = $kategoria;
        $this->omistaja = $omistaja;
        $this->lahde = $lahde;
        $this->juomasuositus = $juomasuositus;
        $this->valmistusohje = $valmistusohje;
        $this->annoksia = $annoksia;
        $this->paaraakaaine = $paaraakaaine;
    }
    
    /**
     * Hakee kannasta tunnistetta vastaavan reseptin, jos reseptiä ei löydy palautaa 'null'
     */
    public static function hae($id){
        $sql = "SELECT id, nimi, kategoria, omistaja, lahde, juomasuositus, valmistusohje, annoksia, paaraakaaine from reseptit where id=?";
        $kysely = getTietokantayhteys()->prepare($sql); $kysely->execute(array($id));
        $tulos = $kysely->fetchObject();
        if (!$tulos == null){
            return new Resepti($tulos->id, $tulos->nimi, $tulos->kategoria, $tulos->omistaja, $tulos->lahde, $tulos->juomasuositus, $tulos->valmistusohje, $tulos->annoksia, $tulos->paaraakaaine);
        } else {
            return null;
        }
        
    }
    
    /**
     * Palauttaa taulukon jossa on kaikki tietokannassa olevat reseptit Resepti olioina.
     * 
     * @return taulukko
     */
    public static function haeKaikki(){
        $sql = "SELECT id, nimi, kategoria, paaraakaaine from reseptit";
        $kysely = getTietokantayhteys()->prepare($sql); $kysely->execute();
    
        $tulokset = array();
        foreach ($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {
            $resepti = new Resepti($tulos->id, $tulos->nimi, $tulos->kategoria, null, null, null, null, null, $tulos->paaraakaaine);
            $tulokset[] = $resepti;
        }
        return $tulokset;
    }
    
    /**
     * Hakee kannasta reseptiin kuuluvat raaka-aineet
     */
    public function haeRaakaaineet(){
        $sql = "SELECT nimi, maara, yksikko
                FROM raakaaineet, reseptin_raakaaineet
                WHERE reseptin_raakaaineet.reseptin_id=? AND reseptin_raakaaineet.raakaaineen_id = raakaaineet.id";
        $kysely = getTietokantayhteys()->prepare($sql); $kysely->execute(array($this->getId()));
        $tulokset = array();
        foreach ($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {
            $tulokset[] = array($tulos->nimi, $tulos->maara, $tulos->yksikko);
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
    
    
    /**
     * Tallentaa reseptin kantaan
     * 
     */
    public function lisaaKantaan(){
        $sql = "INSERT INTO reseptit(nimi, kategoria, omistaja, lahde, juomasuositus, valmistusohje, annoksia, paaraakaaine) VALUES(?,?,?,?,?,?,?,?) RETURNING id";
        $kysely = getTietokantayhteys()->prepare($sql);
        $ok = $kysely->execute(array($this->getNimi(), $this->getKategoria(), $this->getOmistaja(), $this->getLahde(), $this->getJuomasuositus(), $this->getValmistusohje(), $this->getAnnoksia(), $this->getPaaraakaaine()));
        if ($ok) {
            $this->id = $kysely->fetchColumn();
        }
        $this->lisaaRaakaaineetKantaan();
        return $ok;
    }
    
    private function lisaaRaakaaineetKantaan(){
        $sql = "INSERT INTO reseptin_raakaaineet(reseptin_id, raakaaineen_id, maara, yksikko) VALUES(?,?,?,?)";
        for ($i=0; $i<$this->raakaaineiden_lkm; $i++){
            if(!empty($this->raakaaineet[$i])){
                $kysely = getTietokantayhteys()->prepare($sql);
                $ok = $kysely->execute(array($this->getId(), $this->raakaaineet[$i], $this->raakaaineiden_maarat[$i], $this->raakaaineiden_yksikot[$i]));
                if (!$ok) {
                    return false;
                }
            }
        }
        return true; 
    }
    
    public static function haeYksikot(){
        //yksiköt kovakoodattu tähän, ehkä syytä toteuttaa omana tauluna / jotenkin muuten?
        return array('mm','tl','rkl','ml','cl','dl','l','g','kg','kpl');
    }
    
    /**
     * Tarkistaa onko Raakaaine kelvollinen
     * 
     * @return boolean
     */
    public function onkoKelvollinen(){
        return empty($this->virheet);
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
    
    public function getAnnoksia(){
        return $this->annoksia;
    }
    
    public function getPaaraakaaine() {
        return $this->paaraakaaine;
    }
    
    public function getVirheet() {
        return $this->virheet;
    }
    
    public function getRaakaaine($i){
        return $this->raakaaineet[$i];
    }
    
    public function getRaakaaineenMaara($i){
        return $this->raakaaineiden_maarat[$i];
    }
    
    public function getRaakaaineenYksikko(){
        return $this->raakaaineiden_yksikot[$i];
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setNimi($nimi) {
        $this->nimi = $nimi;
        
        if (trim($this->nimi) == ''){
            $this->virheet['nimi'] = "Nimi ei saa olla tyhjä";
        } else{
            unset($this->virheet['nimi']);
        }
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
    
    public function setAnnoksia($annoksia){
        $this->annoksia = $annoksia;
        /*
        if(!$this->onkoOkLuku($annoksia, 0, 100)){
            $this->virheet['annoksia'] = "Syötteen tulee olla luku väliltä 0 - 99";
        } else {
            unset($this->virheet['annoksia']);
        }
         */
    }
    
    public function setRaakaaineet($raakaaineet, $maarat, $yksikot){
        $this->raakaaineet = $raakaaineet;
        $this->raakaaineiden_maarat = $maarat;
        $this->raakaaineiden_yksikot = $yksikot;
        
        /*
        for ($i=0; $i<$this->raakaaineden_lkm; $i++) {
            if (!$this->onkoOkLuku($maarat[$i], 0, 10000)){
                $this->virheet['raakaaineiden_maarat'][$i] = "Syötteen tulee olla luku väliltä 0.00 - 9999.99";
            } else {
                unset($this->virheet['raakaaineiden_maarat'][$i]);
            }
        }
         */
    }
    
    //apufunktoita
    
    //tarkistaa onko luku kelvollinen (eli päteekö: pienin =< syote < suurin)
    private function onkoOkLuku($syote, $pienin, $suurin) {
        $ok = is_numeric($syote) && $syote >= $pienin && $syote < $suurin; 
        return $ok;
        //return preg_match("/^[0-9]+$/", $syote);
    }

}
