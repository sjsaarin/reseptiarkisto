<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');


class Kayttaja {
  
    private $id;
    private $etunimi;
    private $sukunimi;
    private $kayttajatunnus;
    private $salasana;
    private $rooli;

    
    public function __construct($id, $etunimi, $sukunimi, $kayttajatunnus, $salasana, $rooli) {
        $this->id = $id;
        $this->etunimi = $etunimi;
        $this->sukunimi = $sukunimi;
        $this->kayttajatunnus = $kayttajatunnus;
        $this->salasana = $salasana;
        $this->rooli = $rooli;
    }
    
    public function lisaaKantaan() {
        $sql = "INSERT INTO kayttajat(etunimi, sukunimi, kayttajatunnus, salasana, rooli) VALUES(?,?,?,?,?) RETURNING id";
        $kysely = getTietokantayhteys()->prepare($sql);

        $ok = $kysely->execute(array($this->getEtunimi(), $this->getSukunimi(), $this->getKayttajatunnus(), $this->getSalasana, $this->getRooli));
        if ($ok) {
            $this->id = $kysely->fetchColumn();
        }
        return $ok;
    }
    
    public static function hae($id){
        $sql = "SELECT id, etunimi, sukunimi, kayttajatunnus, salasana, rooli 
                FROM kayttajat
                WHERE id = ?";
        $kysely = getTietokantayhteys()->prepare($sql); $kysely->execute(array($id));
        $tulos = $kysely->fetchObject();
        if (!$tulos == null){
            return new Kayttaja($tulos->id, $tulos->etunimi, $tulos->sukunimi, $tulos->kayttajatunnus, $tulos->salasana, $tulos->rooli); 
        } else {
            return null;
        }
        
    }
    
    public static function haeKayttajat($hakusana) {
        $sql = "SELECT id, etunimi, sukunimi, kayttajatunnus, salasana, rooli 
                FROM kayttajat
                WHERE etunimi ILIKE ? OR sukunimi ILIKE ?";
        $kysely = getTietokantayhteys()->prepare($sql); $kysely->execute(array("$hakusana%", "$hakusana%"));
    
        $tulokset = array();
            foreach($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {
                $kayttaja = new Kayttaja($tulos->id, $tulos->etunimi, $tulos->sukunimi, $tulos->kayttajatunnus, $tulos->salasana, $tulos->rooli); 
                $tulokset[] = $kayttaja;
            }
        return $tulokset;
    }
    
    public static function haeKayttajaTunnuksilla($kayttajatunnus, $salasana) {
        
        $sql = "SELECT id, etunimi, sukunimi, kayttajatunnus, salasana, rooli from kayttajat where kayttajatunnus = ? AND salasana = ? LIMIT 1";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($kayttajatunnus, $salasana));

        $tulos = $kysely->fetchObject();
        if ($tulos == null) {
            return null;
        } else {
            $kayttaja = new Kayttaja(); 
            $kayttaja->id = $tulos->id;
            $kayttaja->etunimi = $tulos->etunimi;
            $kayttaja->sukunimi = $tulos->sukunimi;
            $kayttaja->kayttajatunnus = $tulos->kayttajatunnus;
            $kayttaja->salasana = $tulos->salasana;
            $kayttaja->rooli = $tulos->rooli;

            return $kayttaja;
        }
    }
    
    public static function poistaKannasta($id){
        
        $sql = "DELETE from kayttajat where id = ?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($id));
        
    }
    
    public function vaihdaSalasana($uusisalasana){
        $hash = $this->luoSalasanaHash($salasana);
        $sql = "UPDATE ";
    }
    
    //palauttaa koko nimen
    public function getNimi() {
        return $this->etunimi . " " . $this->sukunimi;
    }
    
    //asettaa koko nimen
    public function setNimi($etunimi, $sukunimi){
        $this->etunimi = $etunimi;
        $this->sukunimi = $sukunimi;        
    }
        
    public function getId() {
        return $this->id;
    }
    
    public function getEtunimi() {
        return $this->etunimi;
    }

    public function getSukunimi() {
        return $this->sukunimi;
    }

    public function getSalasana() {
        return $this->salasana;
    }

    public function getKayttajatunnus() {
        return $this->kayttajatunnus;
    }
    
    public function getRooli(){
        return $this->rooli;
    }
    
    public function setId($id) {
        $this->id = $id;
    }
    
    public function setEtunimi($etunimi) {
        $this->etunimi = $etunimi;
    }

    public function setSukunimi($sukunimi) {
        $this->sukunimi = $sukunimi;
    }
    
    public function setRooli($rooli){
        $this->rooli = $rooli;
    }
    
    public function setKayttajatunnus($kayttajatunnus) {
        $this->kayttajatunnus = $kayttajatunnus;
    }
    
    public function setSalasana($salasana, $vahvistus) {
        $this->salasana = $salasana;
    }
    
    private function luoSalasanaHash($salasana){
        $suola = '$2a$11$' . substr(md5(uniqid(rand(), true)), 0, 22);
        return crypt($salasana, $suola);
    }
    
}