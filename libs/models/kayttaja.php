<?php

class Kayttaja {
  
    private $id;
    private $etunimi;
    private $sukunimi;
    private $kayttajatunnus;
    private $salasana;

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
    
    public static function getId() {
        return $this->id;
    }
    
    public static function getName() {
        return $this->etunimi . " " . $this->sukunimi;
    }
    
    public static function getUsername() {
        return $this->kayttajatunnus;
    }
    
    public static function getRole(){
        $rooli = '';
        if ($this->rooli === 1 ) {
            $rooli = 'ylläpitäjä';
        } else {
            $rooli = 'käyttäjä';
        }
        return $rooli;
    }
    
    public static function toString(){
        $rooli = '';
        if ($this->rooli === 1 ) {
            $rooli = 'ylläpitäjä';
        } else {
            $rooli = 'käyttäjä';
        }
        return 'id: ' . $this->id . ', nimi: '. $this->etunimi . ' ' . $this->sukunimi . ", käyttäjätunnus: " . $this->kayttajatunnus . ", " . $rooli;
    }
}