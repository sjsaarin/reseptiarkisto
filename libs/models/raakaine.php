<?php

class Raakaaine {
    
    private $id;
    private $nimi;
    private $kalorit;
    private $hiilarit;
    private $proteiinit;
    private $rasvat;
    private $hinta;
    
    public function __construct($id, $nimi, $kalorit, $hiilarit, $proteiinit, $rasvat, $hinta){
        $this->id=$id;
        $this->nimi=$nimi;
        $this->kalorit=$kalorit;
        $this->hiilarit=$hiilarit;
        $this->proteiinit=$proteiinit;
        $this->rasvat=$rasvat;
        $this->hinta=$hinta;
    }
    
    public function lisaaKantaan(){
        $sql = "INSERT INTO raakaaineet(nimi, kalorit, hiilarit, proteiinit, rasvat, hinta) VALUES(?,?,?,?,?,?) RETURNING id";
        $kysely = getTietokantayhteys()->prepare($sql);

        $ok = $kysely->execute(array($this->getNimi(), $this->getKalorit(), $this->getHiilarit(), $this->getProteiinit, $this->getRasvat, $this->getHinta));
        if ($ok) {
            $this->id = $kysely->fetchColumn();
        }
        return $ok;
    }
    
    public static function getRaakaineet(){
        $sql = "SELECT id, etunimi, sukunimi, kayttajatunnus, salasana, rooli from kayttajat";
        $kysely = getTietokantayhteys()->prepare($sql); $kysely->execute();
    
        $tulokset = array();
            foreach($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {
                $kayttaja = new Kayttaja($tulos->id, $tulos->etunimi, $tulos->sukunimi, $tulos->kayttajatunnus, $tulos->salasana, $tulos->rooli); 
                $tulokset[] = $kayttaja;
            }
        return $tulokset;
        
    }
    
    public static function getRaakaineRaakaineella(){
        
    }
    
    public static function getRaakaineIdlla(){
        
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
    
    //setters
    
    public function setId($id){
        $this->id = $id;
    }
    
    public function setNimi($nimi){
        $this->nimi = $nimi;
    }

    public function setHiilarit($hiilarit) {
        $this->hiilarit = $hiilarit;
    }

    public function setProteiinit($proteiinit) {
        $this->proteiinit = $proteiinit;
    }

    public function setRasvat($rasvat) {
        $this->rasvat = $rasvat;
    }

    public function setHinta($hinta) {
        $this->hinta = $hinta;
    }


}

?>