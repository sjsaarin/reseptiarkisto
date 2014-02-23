<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

class Menu {

    private $id;
    private $nimi;
    private $alkuruoka;
    private $valiruoka1;
    private $paaruoka;
    private $valiruoka2;
    private $jalkiruoka;
    private $kuvaus;
    private $virheet = array();
    
    public function __construct($id, $nimi, $alkuruoka, $valiruoka1, $paaruoka, $valiruoka2, $jalkiruoka, $kuvaus) {
        $this->id = $id;
        $this->nimi = $nimi;
        $this->alkuruoka = $alkuruoka;
        $this->valiruoka1 = $valiruoka1;
        $this->paaruoka = $paaruoka;
        $this->valiruoka2 = $valiruoka2;
        $this->jalkiruoka = $jalkiruoka;
        $this->kuvaus = $kuvaus;
    }

    /**
     * Palauttaa taulukon jossa on avaimena menun osien taulujen nimet ja avaimen arvona selkokielinen menun osan nimi
     * 
     * @return taulukko
     */
    public static function haeOsat() {
        /* $sql= "SELECT column_name from information_schema.columns 
          WHERE table_name='menut AND column_name != 'id'"; */
        
        return array(
            array('alkuruoka', 'valiruoka1', 'paaruoka', 'valiruoka2', 'jalkiruoka'),
            array('Alkuruoka', '1. väliruoka', 'Pääruoka', '2. väliruoka', 'Jälkiruoka')
            );
      
    }
    
    public static function hae($id){
        $sql = "SELECT id, nimi, alkuruoka, valiruoka1, paaruoka, valiruoka2, jalkiruoka, kuvaus 
                FROM menut
                WHERE id = ?";
        $kysely = getTietokantayhteys()->prepare($sql); $kysely->execute(array($id));
        $tulos = $kysely->fetchObject();
        if (!empty($tulos)){
            return new Menu($tulos->id, $tulos->nimi, $tulos->alkuruoka, $tulos->valiruoka1, $tulos->paaruoka, $tulos->valiruoka2, $tulos->jalkiruoka, $tulos->kuvaus); 
        } else {
            return NULL;
        }
    }
    
    public static function haeKaikki(){
        $sql = "SELECT id, nimi, alkuruoka, valiruoka1, paaruoka, valiruoka2, jalkiruoka, kuvaus from menut order by nimi";
        $kysely = getTietokantayhteys()->prepare($sql); $kysely->execute();
    
        $tulokset = array();
            foreach($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {
                $menu = new Menu($tulos->id, $tulos->nimi, $tulos->alkuruoka, $tulos->valiruoka1, $tulos->paaruoka, $tulos->valiruoka2, $tulos->jalkiruoka, $tulos->kuvaus); 
                $tulokset[] = $menu;
            }
        return $tulokset;
        
    }
    
    
    public function lisaaKantaan(){
        $sql = "INSERT INTO menut(nimi, alkuruoka, valiruoka1, paaruoka, valiruoka2, jalkiruoka, kuvaus) VALUES(?,?,?,?,?,?,?) RETURNING id";
        $kysely = getTietokantayhteys()->prepare($sql);

        $ok = $kysely->execute(array($this->getNimi(), $this->getAlkuruoka(), $this->getValiruoka1(), $this->getPaaruoka(), $this->getValiruoka2(), $this->getJalkiruoka(), $this->getKuvaus()));
        if ($ok) {
            $this->id = $kysely->fetchColumn();
        }
        return $ok;
    }
    
    public function paivitaKantaan(){
        $sql = "UPDATE menut SET nimi, alkuruoka, valiruoka1, paaruoka, valiruoka2, jalkiruoka, kuvaus WHERE id = ?";
        $kysely = getTietokantayhteys()->prepare($sql); $kysely->execute(array($this->getId()));
    }
    
    public static function poistaMenuKannasta($id){
        $sql = "DELETE from menut where id=?";
        $kysely = getTietokantayhteys()->prepare($sql); 
        try { 
            $kysely->execute(array($id));
        } catch (PDOException $e) { 
            return false; 
        } 
        return true;
    }
    
    /**
     * palauttaa 2-ulotteisen taulukon jossa jokaisena rivinä on taulukko jossa on:   
     * menun osan nimi, reseptin id, reseptin nimi
     * 
     * @return taulukko
     */
    public function haeMenunReseptienNimet(){
        $menun_reseptit = array(
            array('Alkuruoka', $this->getAlkuruoka(), Resepti::haeNimi($this->getAlkuruoka())),
            array('1. Valiruoka', $this->getValiruoka1(), Resepti::haeNimi($this->getValiruoka1())),
            array('Pääruoka',  $this->getPaaruoka(), Resepti::haeNimi($this->getPaaruoka())),
            array('2. Valiruoka', $this->getValiruoka2(), Resepti::haeNimi($this->getValiruoka2())),
            array('Jalkiruoka', $this->getJalkiruoka(), Resepti::haeNimi($this->getJalkiruoka())),
        );
        return $menun_reseptit;
    }
    
    public function getId(){
        return $this->id;
    }
    
    public function getNimi(){
        return $this->nimi;
    }
    
    public function getAlkuruoka(){
        return $this->alkuruoka;
    }
    
    public function getValiruoka1(){
        return $this->valiruoka1;
    }
    
    public function getPaaruoka(){
        return $this->paaruoka;
    }
    
    public function getValiruoka2(){
        return $this->valiruoka2;
    }
    
    public function getJalkiruoka(){
        return $this->jalkiruoka;
    }
    
    public function getKuvaus(){
        return $this->kuvaus;
    }
    
    public function getVirheet() {
        return $this->virheet;
    }
    
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
    
    public function setAlkuruoka($alkuruoka){
        if ($alkuruoka != -1){
            $this->alkuruoka = $alkuruoka;
        }
    }
    
    public function setValiruoka1($valiruoka1){
        if ($valiruoka1 != -1){
            $this->valiruoka1 = $valiruoka1;
        }
    }
    
    public function setPaaruoka($paaruoka){
        if ($paaruoka != -1){
            $this->paaruoka = $paaruoka;
        }
    }
    
    public function setValiruoka2($valiruoka2){
        if ($valiruoka2 != -1){
            $this->valiruoka2 = $valiruoka2;
        }
    }
    
    public function setJalkiruoka($jalkiruoka){
        if ($jalkiruoka != -1){
            $this->jalkiruoka = $jalkiruoka;
        }
    }
    
    public function setKuvaus($kuvaus){
        $this->kuvaus = $kuvaus;
    }

}
