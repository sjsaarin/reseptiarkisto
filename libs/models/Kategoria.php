<?php

/**
 * Kategorian malli
 */
class Kategoria{
    private $id;
    private $nimi;
    private $virheet = array();
    
    function __construct($id, $nimi){
        $this->id = $id;
        $this->nimi = $nimi;
    }
    
    /**
     * Lisää kategorian kantaan
     * 
     * @return 
     */
    public function lisaaKantaan(){
        $sql = "INSERT INTO kategoriat(nimi) VALUES(?) RETURNING id";
        $kysely = getTietokantayhteys()->prepare($sql);

        $ok = $kysely->execute(array($this->getNimi()));
        if ($ok) {
            $this->id = $kysely->fetchColumn();
        }
        return $ok;
    }
    
    /**
     * Hakee kannasta kategorian tunnuksella
     * 
     * @param type $id
     * @return \Kategoria|null
     */
    public static function hae($id){
        $sql = "SELECT id, nimi from kategoriat where id=?";
        $kysely = getTietokantayhteys()->prepare($sql); $kysely->execute(array($id));
        $tulos = $kysely->fetchObject();
        if (!$tulos == null){
            return new Kategoria($tulos->id, $tulos->nimi);
        } else {
            return null;
        }
    }
    
    public static function haeNimi($id){
        $sql = "SELECT id, nimi from kategoriat where id=?";
        $kysely = getTietokantayhteys()->prepare($sql); $kysely->execute(array($id));
        $tulos = $kysely->fetchObject();
        if (!$tulos == null){
            return $tulos->nimi;
        } else {
            return null;
        }
    }
    
    /**
     * Hakee kannasta kaikki kategoriat
     * 
     * @return array(Kategoria)
     */
    public static function haeKaikki(){
        $sql = "SELECT id, nimi from kategoriat order by nimi";
        $kysely = getTietokantayhteys()->prepare($sql); $kysely->execute();
    
        $tulokset = array();
            foreach($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {
                $kategoria = new Kategoria($tulos->id, $tulos->nimi); 
                $tulokset[] = $kategoria;
            }
        return $tulokset;
        
    }
    
    /**
     * Päivittää kategorian kantaan
     * 
     * @return type
     */
    public function paivitaKantaan(){
        $sql = "UPDATE raakaaineet SET nimi=? WHERE id=? RETURNING id";
        $kysely = getTietokantayhteys()->prepare($sql);

        $ok = $kysely->execute(array($this->getNimi(), $this->getId()));
        if ($ok) {
            $this->id = $kysely->fetchColumn();
        }
        return $ok;
    }
    
        /**
     * Poistaa kategorian kannasta
     * 
     * @return boolean
     */
    public static function poistaKannasta($id){
        $sql = "DELETE from kategoriat where id=?";
        $kysely = getTietokantayhteys()->prepare($sql); 
        try { 
            $kysely->execute(array($id));
        } catch (PDOException $e) { 
            return false; 
        } 
        return true;
    }
    
     /**
     * Tarkistaa onko kategoria kelvollinen
     * 
     * @return boolean
     */
    public function onkoKelvollinen(){
        return empty($this->virheet);
    }
    
    public function getId(){
        return $this->id;
    }
    
    public function getNimi(){
        return $this->nimi;
    }
    
    public function getVirheet(){
        return $this->virheet;
    }
    
    public function setId(){
        return $this->id;
    }
    
    public function setNimi($nimi){
        $this->nimi = $nimi;
        
        if (trim($this->nimi) == ''){
            $this->virheet['nimi'] = "Nimi ei saa olla tyhjä";
        } else{
            unset($this->virheet['nimi']);
        }
    }
}



