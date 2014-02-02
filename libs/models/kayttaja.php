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
    
  public static function getKayttajat() {
        $sql = "SELECT id, etunimi, sukunimi, kayttajatunnus, salasana, rooli from kayttajat";
        $kysely = getTietokantayhteys()->prepare($sql); $kysely->execute();
    
        $tulokset = array();
            foreach($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {
                $kayttaja = new Kayttaja($tulos->id, $tulos->etunimi, $tulos->sukunimi, $tulos->kayttajatunnus, $tulos->salasana, $tulos->rooli); 
                $tulokset[] = $kayttaja;
            }
        return $tulokset;
    }
    
    public static function getKayttajaTunnuksilla($kayttajatunnus, $salasana) {
        
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
    
    public static function tuhoaKayttaja($id){
        
        $sql = "DELETE from kayttajat where id = ?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute();
        
    }
    
    
    public function getId() {
        return $this->id;
    }
    
    public function setId($id) {
        $this->id = $id;
    }
    
    public function getNimi() {
        return $this->etunimi . " " . $this->sukunimi;
    }
    
    public function setNimi($etunimi, $sukunimi){
        $this->etunimi = $etunimi;
        $this->sukunimi = $sukunimi;        
    }
    
    public function getKayttajatunnus() {
        return $this->kayttajatunnus;
    }
    
    public function setKayttajatunnus($kayttajatunnus) {
        $this->kayttajatunnus = $kayttajatunnus;
    }
    
    public function getRooli(){
        return $this->rooli;
    }
    
    public function setRooli($rooli){
        $this->rooli = $rooli;
    }
    
    public function toString(){
        $rooli = '';
        if ($this->rooli === 1 ) {
            $rooli = 'ylläpitäjä';
        } else {
            $rooli = 'käyttäjä';
        }
        return 'id: ' . $this->id . ', nimi: '. $this->etunimi . ' ' . $this->sukunimi . ", käyttäjätunnus: " . $this->kayttajatunnus . ", " . $rooli;
    }
}