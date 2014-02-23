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
    
    //reseptin raaka-aineiden lukumäärän maksimi
    private $raakaaineiden_lkm = 10;
    //yksiköt kovakoodattu tähän
    private static $yksikot = array('mm' => 0.01,'tl' => 0.05, 'rkl' => 0.15 , 'ml' => 0.01, 'cl' => 0.1 ,'dl' => 1 , 'l' => 10, 'g' => 1, 'kg' => 1000, 'kpl' => 1);
    
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
        if (!($tulos === NULL)){
            return new Resepti($tulos->id, $tulos->nimi, $tulos->kategoria, $tulos->omistaja, $tulos->lahde, $tulos->juomasuositus, $tulos->valmistusohje, $tulos->annoksia, $tulos->paaraakaaine);
        } else {
            return NULL;
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
     * Hakee parametrinä annettua nimeä vastaavat reseptit kannasta
     * 
     * @param type $nimi
     * @return \Rresepti
     */
    /*
    public static function haeNimella($nimi){
        $sql = "SELECT * from reseptit WHERE nimi ILIKE ? ORDER by nimi";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array("$nimi%"));
        $tulokset = array();
            foreach($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {
                $resepti = new Resepti($tulos->id, $tulos->nimi, $tulos->kategoria, $tulos->omistaja, $tulos->lahde, $tulos->juomasuositus, $tulos->valmistusohje, $tulos->annoksia, $tulos->paaraakaaine); 
                $tulokset[] = $resepti;
            }
        return $tulokset;
    }
    */
    
    /**
     * Hakee id:tä vastaavan reseptin nimen. Jos reseptiä ei ole palauttaa NULL
     * 
     * @param type $id
     */
    public static function haeNimi($id){
        $sql = "SELECT nimi from reseptit WHERE id = ?";
        $kysely = getTietokantayhteys()->prepare($sql); $kysely->execute(array($id));
        $tulos = $kysely->fetchObject();
        if (!empty($tulos)){
            return $tulos->nimi;
        } else {
            return NULL;
        }
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
     * Paluttaa taulukon jossa on reseptin raakaaineet hintatiedolla varustettuna
     * 
     * @param type $id
     * @return type
     */
    public static function haeRaakaaineetHinnalla($id){
        $sql = "SELECT nimi, maara, yksikko, hinta
                FROM raakaaineet, reseptin_raakaaineet
                WHERE reseptin_raakaaineet.reseptin_id=? AND reseptin_raakaaineet.raakaaineen_id = raakaaineet.id";
        $kysely = getTietokantayhteys()->prepare($sql); $kysely->execute(array($id));
        $tulokset = array();
        foreach ($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {
            $tulokset[] = array($tulos->nimi, $tulos->maara, $tulos->yksikko, $tulos->hinta);
        }
        return $tulokset;
    }
    
    public function haeRaakaaineetReseptiin(){
        $sql = "SELECT raakaaineen_id, maara, yksikko
                FROM raakaaineet, reseptin_raakaaineet
                WHERE reseptin_raakaaineet.reseptin_id=? AND reseptin_raakaaineet.raakaaineen_id = raakaaineet.id";
        $kysely = getTietokantayhteys()->prepare($sql); $kysely->execute(array($this->getId()));
        $this->raakaaineet = array();
        $this->raakaaineiden_maarat = array();
        $this->raakaaineiden_yksikot = array();
        foreach ($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {
            $this->raakaaineet[] = $tulos->raakaaineen_id;
            $this->raakaaineiden_maarat[] = $tulos->maara;
            $this->raakaaineiden_yksikot[] = $tulos->yksikko; 
        }
    }
    
    public static function haeReseptitListaan($nimi, $kategoria, $paaraakaaine, $sivu, $montako){
        $sql = "SELECT reseptit.id, reseptit.nimi AS renimi, kategoriat.nimi AS kanimi, raakaaineet.nimi AS ranimi
                FROM reseptit, kategoriat, raakaaineet
                WHERE reseptit.nimi ILIKE ? AND ";
        //todo: seuraavat olis ehkä mahdollista siirtää erilliseen funktioon (samat kuin haeResptienLukumaarassa).
        $parametrit = array("$nimi%");
        if (!($kategoria == -1)){
            $sql .= "reseptit.kategoria = ? AND ";
            array_push($parametrit, $kategoria);
        }
        if (!($paaraakaaine == -1)){
            $sql .= "reseptit.paaraakaaine = ? AND ";
            array_push($parametrit, $paaraakaaine);
        }
        //------------------------------------------------
        $kohta = $montako*$sivu;
        array_push($parametrit, $montako);
        array_push($parametrit, $kohta);
        $sql .= "reseptit.kategoria = kategoriat.id AND reseptit.paaraakaaine = raakaaineet.id order by renimi LIMIT ? OFFSET ?";
        $kysely = getTietokantayhteys()->prepare($sql); $kysely->execute($parametrit);
        $tulokset = array();
        foreach ($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {
            $tulokset[] = array($tulos->id, $tulos->renimi, $tulos->kanimi, $tulos->ranimi);
        }
        return $tulokset;
    }
    
    public static function haeReseptienLukumaara($nimi, $kategoria, $paaraakaaine){
        $sql = "SELECT count(reseptit.id)
                FROM reseptit, kategoriat, raakaaineet
                WHERE reseptit.nimi ILIKE ? AND ";
        //todo: seuraavat olis ehkä mahdollista siirtää erilliseen funktioon (samat kuin haeResptitListaan funktiossa)
        $parametrit = array("$nimi%");
        if (!($kategoria == -1)){
            $sql .= "reseptit.kategoria = ? AND ";
            array_push($parametrit, $kategoria);
        }
        if (!($paaraakaaine == -1)){
            $sql .= "reseptit.paaraakaaine = ? AND ";
            array_push($parametrit, $paaraakaaine);
        }
        //---------------------------------------------------------
        $sql .= "reseptit.kategoria = kategoriat.id AND reseptit.paaraakaaine = raakaaineet.id";
        $kysely = getTietokantayhteys()->prepare($sql); $kysely->execute($parametrit);
        return $kysely->fetchColumn(0);
    }
    
    /*
     * ei toimi!
     * 
    private static function koostaKyselyJaParametritHakuun($sql, $nimi, $kategoria, $paaraakaaine){
        $tulos = array("$nimi%");
        if (!($kategoria == -1)){
            $sql .= "reseptit.kategoria = ? AND ";
            array_push($tulos, $kategoria);
        }
        if (!($paaraakaaine == -1)){
            $sql .= "reseptit.paaraakaaine = ? AND ";
            array_push($tulos, $paaraakaaine);
        }
        return $tulos;
    }*/
    
    /**
     * Hakee kaikki reseptien paaraaka-aineet
     */
    public static function haePaaRaakaaineet(){
        $sql = "SELECT DISTINCT paaraakaaine, raakaaineet.nimi
                FROM reseptit, raakaaineet
                WHERE paaraakaaine = raakaaineet.id
                ORDER by raakaaineet.nimi";
        $kysely = getTietokantayhteys()->prepare($sql); $kysely->execute();
        $tulokset = array();
        foreach ($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {
            $tulokset[] = array($tulos->paaraakaaine, $tulos->nimi);
        }
        return $tulokset;
    }
    
    /**
     * Palauttaa tietokantaan tallennettujen reseptien lukumäärn
     * 
     * @return int

    public static function reseptienLkm(){
        $sql = "SELECT COUNT(*) from reseptit";
        $kysely = getTietokantayhteys()->prepare($sql); $kysely->execute();
        return $kysely->fetchColumn(0);
    }*/
    
    public function paivitaKantaan(){
        $sql = "UPDATE reseptit SET nimi=?, kategoria=?, lahde=?, juomasuositus=?, valmistusohje=?, annoksia=?, paaraakaaine=? WHERE id=? RETURNING id";
        $kysely = getTietokantayhteys()->prepare($sql);

        $ok = $kysely->execute(array($this->getNimi(), $this->getKategoria(), $this->getLahde(), $this->getJuomasuositus(), $this->getValmistusohje(), $this->getAnnoksia(), $this->getPaaraakaaine(), $this->getId()));
        //poistetaan vanhat raaka-aineet kannasta ja lisätään uudet, uusien lisäys tehdään vasta sen jälkeen kun vanhat poistuneet muuten operaatiot saattavat olla päällekkäiset
        if ($this->poistaRaakaaineetKannasta()){
            $this->lisaaRaakaaineetKantaan();
        }
        if ($ok) {
            $this->id = $kysely->fetchColumn();
        }
        return $ok;
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
    
    /**
     * Lisää reseptin raaka-aineet kantaan
     * 
     * @return boolean
     * 
     */
    private function lisaaRaakaaineetKantaan(){
        $sql = "INSERT INTO reseptin_raakaaineet(reseptin_id, raakaaineen_id, maara, yksikko) VALUES(?,?,?,?)";
        for ($i=0; $i<$this->raakaaineiden_lkm; $i++){
            //tallennetaan raaka-aine reseptin_raakaaineisiiin jos raaka-aine asetettu
            if(!($this->raakaaineet[$i] == -1)){
                $kysely = getTietokantayhteys()->prepare($sql);
                $ok = $kysely->execute(array($this->getId(), $this->raakaaineet[$i], $this->raakaaineiden_maarat[$i], $this->raakaaineiden_yksikot[$i]));
                if (!$ok) {
                    return false;
                }
            }
        }
        return true; 
    }
    
    public function poistaKannasta(){
        
        $sql = "DELETE from reseptit where id=?";
        $kysely = getTietokantayhteys()->prepare($sql); 
        try { 
            $kysely->execute(array($this->getId()));
        } catch (PDOException $e) { 
            return false; 
        } 
        return true;
    }
    
    public static function poistaReseptiKannasta($id){
        
        $sql = "DELETE from reseptit where id=?";
        $kysely = getTietokantayhteys()->prepare($sql); 
        try { 
            $kysely->execute(array($id));
        } catch (PDOException $e) { 
            return false; 
        } 
        return true;
    }
    
    //poistaa kaikki reseptiin liittyvät raaka-aineet kannasta
    public function poistaRaakaaineetKannasta(){
        $sql = "DELETE from reseptin_raakaaineet where reseptin_id=?";
        $kysely = getTietokantayhteys()->prepare($sql); 
        try { 
            $kysely->execute(array($this->getId()));
        } catch (PDOException $e) { 
            return false; 
        } 
        return true;
    }
    
    /**
     * vaihtaa reseptin omistajan 
     * 
     * @param type $omistaja
     * @param type $uusi_omistaja
     */
    public static function vaihdaOmistaja($omistaja, $uusi_omistaja){
        $sql = "UPDATE reseptit SET omistaja=? WHERE omistaja=?";
        $kysely = getTietokantayhteys()->prepare($sql); $kysely->execute(array($uusi_omistaja, $omistaja));
    }
    
    public static function haeYksikot(){
        return self::$yksikot;
    }
    
    /**
     * Tarkistaa onko Raaka-aine kelvollinen
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
    
    public function getRaakaaineenYksikko($i){
        return $this->raakaaineiden_yksikot[$i];
    }
    
    public function getRaakaaineet(){
        if (!isset($this->raakaaineet)){
            $this->haeRaakaaineetReseptiin();
        }
        return $this->raakaaineet;
    }
    
    public function getRaakaaineidenMaarat(){
        return $this->raakaaineiden_maarat;
    }
    
    public function getRaakaaineidenYksikot(){
        return $this->raakaaineiden_yksikot;
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
    
    public function setPaaraakaaine($paaraakaaine) {
        $this->paaraakaaine = $paaraakaaine;
    }
    
    public function setAnnoksia($annoksia){
        $this->annoksia = $annoksia;
        if(!$this->onkoOkLuku($annoksia, 0, 100)){
            $this->virheet['annoksia'] = "annosmäärän tulee olla luku väliltä 0 - 99";
        } else {
            unset($this->virheet['annoksia']);
        }
    }
    
    /**
     * Asettaa raaka-aineet reseptiin ja tarkastaa samalla että annetut raaka-aineet ovat kevollisia
     * 
     * @param type $raakaaineet
     * @param type $maarat
     * @param type $yksikot
     */
    public function setRaakaaineet($raakaaineet, $maarat, $yksikot){
        $this->raakaaineet = $raakaaineet;
        $this->raakaaineiden_maarat = $maarat;
        $this->raakaaineiden_yksikot = $yksikot;
        
        $this->tarkastaRaakaaineidenVirheet();
    }
    
    /**
     * Nollaa reseptin virheilmoitukset
     */
    public function nollaaVirheet(){
        unset($this->virheet);
    }
    
    //apufunktoita
    
    //tarkistaa onko luku kelvollinen (eli päteekö: pienin =< syote < suurin)
    private function onkoOkLuku($syote, $pienin, $suurin) {
        $ok = is_numeric($syote) && $syote >= $pienin && $syote < $suurin; 
        return $ok;
        //return preg_match("/^[0-9]+$/", $syote);
    }

    private function tarkastaRaakaaineidenVirheet(){
        for ($i=0; $i<$this->raakaaineiden_lkm; $i++){
            if($this->onkoPaaraakaaineAsetettu($i) && (!$this->onkoRaakaaineDuplikaatti($this->raakaaineet[$i], $i)) && $this->onkoRaakaineenMaaraOk($i)){
                unset($this->virheet['raakaaineet'][$i]);
            }
        }
    }
    
    private function asetaRaakaineenVirheViesti($viesti, $i){
        if (isset($this->virheet['raakaaineet'][$i])){
            $this->virheet['raakaaineet'][$i] .= $viesti;
        } else {
            $this->virheet['raakaaineet'][$i] = $viesti;
        }
        
    }
    
    //tarkastaa onko paaraaka-aine asetettu
    private function onkoPaaraakaaineAsetettu($i){
        if (($i == 0) && ($this->raakaaineet[0] == -1)){
            $this->asetaRaakaineenVirheViesti("reseptissä taytyy olla pääraaka-aine", 0);
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    //tarkastaa onko raaka-aine jo kertaalleen raaka-aineet taulokossa
    private function onkoRaakaaineDuplikaatti($raakaaine, $i) {
        $esiintymat = count(array_keys($this->raakaaineet, $raakaaine));
        if (($esiintymat > 1) && !($raakaaine == -1)){
            $viesti = "raaka-aine voi olla reseptissä vain kertaalleen.";
            $this->asetaRaakaineenVirheViesti($viesti, $i);
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    //tarkastaa onko raaka-aineelle annettu määrä kelvollinen
    private function onkoRaakaineenMaaraOk($i){
        if ((!($this->raakaaineet[$i] == -1)) && (!($this->onkoOkLuku($this->raakaaineiden_maarat[$i], 0, 10000)))) {
            $viesti = "raaka-aineen määrä voi olla väliltä 0.00-9999.99";
            $this->asetaRaakaineenVirheViesti($viesti, $i);
            return FALSE;
        } else {
            RETURN TRUE;
        }
    }
            
}
