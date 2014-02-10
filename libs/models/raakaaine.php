<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

class Raakaaine {
    
    private $id;
    private $nimi;
    private $kalorit;
    private $hiilarit;
    private $proteiinit;
    private $rasvat;
    private $hinta;
    private $virheet = array();
    
    public function __construct($id, $nimi, $kalorit, $hiilarit, $proteiinit, $rasvat, $hinta){
        $this->id = $id;
        $this->nimi = $nimi;
        $this->kalorit = $kalorit;
        $this->hiilarit = $hiilarit;
        $this->proteiinit = $proteiinit;
        $this->rasvat = $rasvat;
        $this->hinta = $hinta;
    }
    
    //CREATE
    public function lisaaKantaan(){
        $sql = "INSERT INTO raakaaineet(nimi, kalorit, hiilarit, proteiinit, rasvat, hinta) VALUES(?,?,?,?,?,?) RETURNING id";
        $kysely = getTietokantayhteys()->prepare($sql);

        $ok = $kysely->execute(array($this->getNimi(), $this->getKalorit(), $this->getHiilarit(), $this->getProteiinit(), $this->getRasvat(), $this->getHinta()));
        if ($ok) {
            $this->id = $kysely->fetchColumn();
        }
        return $ok;
    }
    
    //READ
    public static function getRaakaaineet(){
        $sql = "SELECT id, nimi, kalorit, hiilarit, proteiinit, rasvat, hinta from raakaaineet order by nimi";
        $kysely = getTietokantayhteys()->prepare($sql); $kysely->execute();
    
        $tulokset = array();
            foreach($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {
                $raakaaine = new Raakaaine($tulos->id, $tulos->nimi, $tulos->kalorit, $tulos->hiilarit, $tulos->proteiinit, $tulos->rasvat, $tulos->hinta); 
                $tulokset[] = $raakaaine;
            }
        return $tulokset;
        
    }
    
    public static function hae($id){
        $sql = "SELECT id, nimi, kalorit, hiilarit, proteiinit, rasvat, hinta from raakaaineet where id=?";
        $kysely = getTietokantayhteys()->prepare($sql); $kysely->execute(array($id));
        $tulos = $kysely->fetchObject();
        if (!$tulos == null){
            return new Raakaaine($tulos->id, $tulos->nimi, $tulos->kalorit, $tulos->hiilarit, $tulos->proteiinit, $tulos->rasvat, $tulos->hinta);
        } else {
            return null;
        }
    }
    
    public static function haeSivu($sivu, $montako){
        $sql = "SELECT * from raakaaineet ORDER by nimi LIMIT ? OFFSET ?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kohta = $montako*$sivu;
        $kysely->execute(array($montako, $kohta));
        //$kysely->execute();
        $tulokset = array();
            foreach($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {
                $raakaaine = new Raakaaine($tulos->id, $tulos->nimi, $tulos->kalorit, $tulos->hiilarit, $tulos->proteiinit, $tulos->rasvat, $tulos->hinta); 
                $tulokset[] = $raakaaine;
            }
        return $tulokset;
        
    }
    
    public static function haeNimella($nimi){
        $sql = "SELECT * from raakaaineet WHERE nimi ILIKE ? ORDER by nimi";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array("$nimi%"));
        $tulokset = array();
            foreach($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {
                $raakaaine = new Raakaaine($tulos->id, $tulos->nimi, $tulos->kalorit, $tulos->hiilarit, $tulos->proteiinit, $tulos->rasvat, $tulos->hinta); 
                $tulokset[] = $raakaaine;
            }
        return $tulokset;
    }
    
    //UPDATE
    public function paivitaKantaan(){
        $sql = "UPDATE raakaaineet SET nimi=?, kalorit=?, hiilarit=?, proteiinit=?, rasvat=?, hinta=? WHERE id=? RETURNING id";
        $kysely = getTietokantayhteys()->prepare($sql);

        $ok = $kysely->execute(array($this->getNimi(), $this->getKalorit(), $this->getHiilarit(), $this->getProteiinit(), $this->getRasvat(), $this->getHinta(), $this->getId()));
        if ($ok) {
            $this->id = $kysely->fetchColumn();
        }
        return $ok;
    }
    
    //DELETE
    public function poistaKannasta(){
        $sql = "DELETE from raakaaineet where id=?";
        $kysely = getTietokantayhteys()->prepare($sql); 
        try { 
            $kysely->execute(array($this->getId()));
        } catch (PDOException $e) { 
            return false; 
        } 
        return true;
    }
    
    
    public static function poistaMontaKannasta($poistettavat){
        $sql = "DELETE from raakaaineet where id=?";
        $kysely = getTietokantayhteys()->prepare($sql); 
        return $kysely->execute($poistettavat);
        //tähän joku tarkistus että poisto(t) todella onnistuivat, nyt palauttaa aina true
       
    }
    
    public static function raakaaineidenLkm(){
        $sql = "SELECT COUNT(*) from raakaaineet";
        $kysely = getTietokantayhteys()->prepare($sql); $kysely->execute();
        return $kysely->fetchColumn(0);
    }
    
    public function onkoKelvollinen(){
        return empty($this->virheet);
    }
    
    //getters
    
    public function getId(){
        return $this->id;
    }
    
    public function getNimi(){
        return $this->nimi;
    }
    
    public function getKalorit(){
        return $this->kalorit;
    }

    public function getHiilarit() {
        return $this->hiilarit;
    }

    public function getProteiinit() {
        return $this->proteiinit;
    }

    public function getRasvat() {
        return $this->rasvat;
    }

    public function getHinta() {
        return $this->hinta;
    }
    
    public function getVirheet(){
        return $this->virheet;
    }
    
    //setters
    public function setId($id){
        $this->id = $id;
    }
    
    public function setNimi($nimi){
        $this->nimi = $nimi;
        
        if (trim($this->nimi) == ''){
            $this->virheet['nimi'] = "Nimi ei saa olla tyhjä";
        } else{
            unset($this->virheet['nimi']);
        }
    }

    public function setHiilarit($hiilarit) {
        if (!onkoOkLuku($hiilarit)){
            $this->hiilarit = $hiilarit;
            $this->virheet['hiilarit'] = "Syötteen tulee luku väliltä 0.00 - 9999.99";
        } else{  
            $this->hiilarit = $hiilarit;
            unset($this->virheet['hiilarit']);
        }
    }

    public function setProteiinit($proteiinit) {
        if (!onkoOkLuku($proteiinit)){
            $this->proteiinit = $proteiinit;
            $this->virheet['proteiinit'] = "Syötteen tulee olla numero";
        } else{
            $this->proteiinit = $proteiinit;
            unset($this->virheet['proteiinit']);
        }
    }

    public function setRasvat($rasvat) {
        if (!onkoOkLuku($rasvat)){
            $this->rasvat = $rasvat;
            $this->virheet['rasvat'] = "Syötteen tulee olla numero";
        } else{
            $this->rasvat = $rasvat;
            unset($this->virheet['rasvat']);
        }
    }
    
    public function setKalorit($kalorit) {
        if (!onkoOkLuku($kalorit)){
            $this->kalorit = $kalorit;
            $this->virheet['kalorit'] = "Syötteen tulee olla numero";
        } else{
            $this->kalorit = $kalorit;
            unset($this->virheet['kalorit']);
        }
    }

    public function setHinta($hinta){
        if (!onkoOkLuku($hinta)){
            $this->hinta = $hinta;
            $this->virheet['hinta'] = "Syötteen tulee olla numero";
        } else{
            $this->hinta = $hinta;
            unset($this->virheet['hinta']);
        }
    }
    

}

