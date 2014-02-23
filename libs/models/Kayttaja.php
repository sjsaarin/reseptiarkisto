<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once 'libs/models/Resepti.php';

class Kayttaja {
  
    private $id;
    private $etunimi;
    private $sukunimi;
    private $kayttajatunnus;
    private $salasana;
    private $rooli;
    private $virheet = array();

    
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

        $ok = $kysely->execute(array($this->getEtunimi(), $this->getSukunimi(), $this->getKayttajatunnus(), $this->getSalasana(), $this->getRooli()));
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
        if (!empty($tulos)){
            return new Kayttaja($tulos->id, $tulos->etunimi, $tulos->sukunimi, $tulos->kayttajatunnus, $tulos->salasana, $tulos->rooli); 
        } else {
            return NULL;
        }
        
    }
    
    public static function haeKayttajat($hakusana) {
        $sql = "SELECT id, etunimi, sukunimi, kayttajatunnus, salasana, rooli 
                FROM kayttajat
                WHERE etunimi ILIKE ? OR sukunimi ILIKE ? 
                ORDER BY etunimi";
        $kysely = getTietokantayhteys()->prepare($sql); $kysely->execute(array("$hakusana%", "$hakusana%"));
    
        $tulokset = array();
            foreach($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {
                $kayttaja = new Kayttaja($tulos->id, $tulos->etunimi, $tulos->sukunimi, $tulos->kayttajatunnus, $tulos->salasana, $tulos->rooli); 
                $tulokset[] = $kayttaja;
            }
        return $tulokset;
    }
    
    /**
     * Hakee kannasta kayttajatunnusta ja salasanaa vastaavan käyttäjän.
     *   
     * @param type $kayttajatunnus
     * @param type $salasana
     * @return Kayttaja / NULL
     */
    public static function haeKayttajaTunnuksilla($kayttajatunnus, $salasana) {
        
        $kayttaja = self::haeKayttajaKayttajatunnuksella($kayttajatunnus);
        if ((!empty($kayttaja)) && $kayttaja->onkoOikeaSalasana($salasana)){
            return $kayttaja;
        } else {
            return NULL;
        }
    }
    /*
    //hakee kayttajatunnusta ja salasanaa (hash) vastaavan kayttajan kannasta
    private static function haeKayttajaTunnuksellaJaSalasanalla($kayttajatunnus, $salasana){
        $sql = "SELECT id, etunimi, sukunimi, kayttajatunnus, salasana, rooli from kayttajat where kayttajatunnus = ? AND salasana = ? LIMIT 1";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($kayttajatunnus, $salasana));
        $tulos = $kysely->fetchObject();
        if (empty($tulos)) {
            return NULL;
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
    } */
    
    //hakee kayttajatunnusta vastaavan kayttajan kannasta
    private static function haeKayttajaKayttajatunnuksella($kayttajatunnus) {
        $sql = "SELECT id, etunimi, sukunimi, kayttajatunnus, salasana, rooli from kayttajat where kayttajatunnus = ? LIMIT 1";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($kayttajatunnus));
        $tulos = $kysely->fetchObject();
        if (empty($tulos)) {
            return NULL;
        } else {
            $kayttaja = new Kayttaja($tulos->id, $tulos->etunimi, $tulos->sukunimi, $tulos->kayttajatunnus, $tulos->salasana, $tulos->rooli);
            return $kayttaja;
        }
    }
        /*
        $sql = "SELECT salasana from kayttajat where kayttajatunnus = ?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($kayttajatunnus));
        $tulos = $kysely->fetchObject();
        if (empty($tulos)) {
            return NULL;
        } else {
            return $tulos->salasana;
        }*/
    
    /**
     * Poistaa kayttajan kannasta, samalla asettaa reseptien jotka poistettava omisti omistajaksi poistajan
     * 
     * @param type $poistettava
     * @param type $poistaja
     */
    public static function poistaKannasta($poistettava, $poistaja){
        
        Resepti::vaihdaOmistaja($poistettava, $poistaja);
        
        $sql = "DELETE from kayttajat where id = ?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($poistettava));
        
    }
    
    public function vaihdaSalasana($uusisalasana){
        $this->setSalasana($uusisalasana);
        //$hash = $this->luoSalasanaHash($salasana);
        $sql = "UPDATE kayttajat
                SET salasana = ?
                WHERE id = ?";
        $kysely = getTietokantayhteys()->prepare($sql);
        return $kysely->execute(array($this->salasana, $this->id));
    }
    
    public function paivitaKantaan(){
        $sql = "UPDATE kayttajat SET etunimi=?, sukunimi=?, kayttajatunnus=?, salasana=?, rooli=? WHERE id=?";
        $kysely = getTietokantayhteys()->prepare($sql);

        $ok = $kysely->execute(array($this->getEtunimi(), $this->getSukunimi(), $this->getKayttajatunnus(), $this->getSalasana(), $this->getRooli(), $this->getId()));
        return $ok;
        
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

    //salasanaa ei ole tarvetta saada muuta kuin kayttajasta itsestään
    private function getSalasana() {
        return $this->salasana;
    }

    public function getKayttajatunnus() {
        return $this->kayttajatunnus;
    }
    
    public function getVirheet(){
        $virheet = $this->virheet;
        unset($this->virheet);
        return $virheet;
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
        if (!($this->kayttajatunnus === $kayttajatunnus)){
            $this->kayttajatunnus = $kayttajatunnus;
            if (empty($this->kayttajatunnus)){
                $this->virheet['kayttajatunnus'] = "Käyttäjätunnus ei voi olla tyhjä";
            } elseif (strlen($kayttajatunnus)>8){
                $this->virheet['kayttajatunnus'] = "Käyttäjätunnus saa olla enintään kahdeksan merkkiä pitkä";
            } elseif (self::haeKayttajaKayttajatunnuksella($kayttajatunnus)){
                $this->virheet['kayttajatunnus'] = "Käyttäjätunnus on jo olemassa";
            }
        }
    }
    
    public function setSalasana($salasana, $vahvistus) {
        if (!$this->onkoOkSalasana($salasana)){
            $this->virheet['salasana_uusi'] = 'Salasanan tulee olla vähintään kymmenen merkkiä pitkä, sisältää vähintään yksi iso ja yksi pieni kirjain sekä yksi numero.';
        } elseif (!($salasana === $vahvistus)){
            $viesti = "Salasanat eivät täsmää"; 
            $this->virheet['salasana_uusi'] = $viesti;
            $this->virheet['salasana_vahvistus'] = $viesti;
        } else {
            unset($this->virheet['salasana_uusi']);
            unset($this->virheet['salasana_vahvistus']);
            $this->salasana = $this->luoSalasanaHash($salasana);
        }
    }
    
     public function onkoOikeaSalasana($salasana) {
        if  (!(crypt($salasana, $this->salasana) === $this->salasana)){
            $this->virheet['salasana'] = "Väärä salasana!";
            return FALSE;
        } else {
            unset($this->virheet['salasana']);
            return TRUE;
        }
    }
    
    private function luoSalasanaHash($salasana){
        $suola = '$2a$11$' . substr(md5(uniqid(rand(), true)), 0, 22);
        //$suola = '$5$rounds=5000' . substr(md5(uniqid(rand(), true)), 0, 22);
        //$suola = openssl_random_pseudo_bytes(22);
        //$suola = '$2a$11$' . strtr($salt, array('_' => '.', '~' => '/'));
        return crypt($salasana, $suola);
    }
    
    private function onkoOkSalasana($salasana){
        $r1='/[A-Z]/';  //isot kirjaimet
        $r2='/[a-z]/';  //pienet kirjaimet
        $r3='/[0-9]/';  //numerot

        //onko isoja kirjaimia vähintään 2
        if (preg_match_all($r1, $salasana, $o) < 1) {
            return FALSE;
        }
        //onko pieniä kirjaimia vähintään 2
        if (preg_match_all($r2, $salasana, $o) < 1) {
            return FALSE;
        }
        //onko numeoita vähintään 2
        if (preg_match_all($r3, $salasana, $o) < 1) {
            return FALSE;
        }
        //onko pituus vähintään 10
        if (strlen($salasana) < 10) {
            return FALSE;
        }

        return TRUE;
        
    }
    
}