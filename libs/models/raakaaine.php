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
    
    public function lisaaKantaan(){
        $sql = "INSERT INTO raakaaineet(nimi, kalorit, hiilarit, proteiinit, rasvat, hinta) VALUES(?,?,?,?,?,?) RETURNING id";
        $kysely = getTietokantayhteys()->prepare($sql);

        $ok = $kysely->execute(array($this->getNimi(), $this->getKalorit(), $this->getHiilarit(), $this->getProteiinit(), $this->getRasvat(), $this->getHinta()));
        if ($ok) {
            $this->id = $kysely->fetchColumn();
        }
        return $ok;
    }
    
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
            $this->virheet['nimi'] = "Nimi ei saa olla tyhjä.";
        } else{
            unset($this->virheet['nimi']);
        }
    }

    public function setHiilarit($hiilarit) {
        $this->hiilarit = $hiilarit;
        if (!is_int($this->hiilarit)){
            $this->virheet['hiilarit'] = "söytteen tulee olla kokonaisluku";
        } else{
            unset($this->virheet['hiilarit']);
        }
    }

    public function setProteiinit($proteiinit) {
        $this->proteiinit = $proteiinit;
        if (!is_int($this->proteiinit)){
            $this->virheet['proteiinit'] = "söytteen tulee olla kokonaisluku";
        } else{
            unset($this->virheet['proteiinit']);
        }
    }

    public function setRasvat($rasvat) {
        $this->rasvat = $rasvat;
        if (!is_int($this->rasvat)){
            $this->virheet['rasvat'] = "söytteen tulee olla kokonaisluku";
        } else{
            unset($this->virheet['rasvat']);
        }
    }
    
    public function setKalorit($kalorit) {
        $this->kalorit = $kalorit;
        if (!is_int($this->kalorit)){
            $this->virheet['kalorit'] = "söytteen tulee olla kokonaisluku";
        } else{
            unset($this->virheet['kalorit']);
        }
    }

    public function setHinta($hinta) {
        $this->hinta = $hinta;
        if (!is_int($this->hinta)){
            $this->virheet['hinta'] = "söytteen tulee olla kokonaisluku";
        } else{
            unset($this->virheet['hinta']);
        }
    }

}

