<?php

/**
 * Kayttajien ohjain
 *
 * @author Sami-Joonas Saarinen
 */

require_once 'libs/models/Kayttaja.php';

class KayttajatOhjain {
    
    private $sivun_nimi = 'kayttajat';
    private $title = 'Käyttäjät';
    
    public function lista($hakusana, $sivu){
        $kayttajat = Kayttaja::haeKayttajat($hakusana);
        naytaNakyma("views/kayttaja_listaa.php", array(
           'title' => $this->title,
           'sivun' => $this->sivun_nimi,
           'kayttajat' => $kayttajat 
        ));
    }
    
    public function nayta($id){
        $kayttaja = Kayttaja::hae($id);
        if (!empty($kayttaja)){
            naytaNakyma("views/kayttaja_nayta.php", array(
                'title' => $this->title,
                'sivun' => $this->sivun_nimi,
                'kayttaja' => $kayttaja 
            ));
        } else {
            $_SESSION['virhe'] = 'Käyttäjää ei löydy';
            header('Location: index.php');
        }
    }
    
    public function vaihdaSalasana($salasana, $uusisalasana1, $uusisalasana2){

        $kayttaja = $_SESSION['kayttaja'];
        if ($kayttaja->onkoOikeaSalasana($salasana)){
            $kayttaja->setSalasana($uusisalasana1, $uusisalasana2);
        }
        $virheet = $kayttaja->getVirheet();
        if (!(empty($virheet))){
            naytaNakyma('views/kayttaja_nayta.php', array(
                'virhe' => 'Salasanan vaihto epäonnistui',
                'sivu' => $this->sivun_nimi,
                'title' => $this->title,
                'virheet' => $virheet,
                'kayttaja' => $kayttaja
            ));
        } else {
            $kayttaja->paivitaKantaan();
            $_SESSION['kayttaja'] = $kayttaja;
            $_SESSION['ilmoitus'] = "Salasana vaihdettu onnistuneesti";
            header('Location: kayttajat.php?omat_tiedot');
        }
    }
    
    public function lisaa(){
        naytaNakyma("views/kayttaja_lomake.php", array(
            'sivu' => $this->sivun_nimi,
            'tila' => 'lisaa',
            'title' => $this->title,
        ));
    }
    
    public function muokkaa($id){
        $kayttaja = Kayttaja::hae((int)$id);
        if (!empty($kayttaja)){
            naytaNakyma('views/kayttaja_lomake.php', array(
                'tila' => 'muokkaa',
                'title' => $this->title,
                'sivu' => $this->sivun_nimi,
                'kayttaja' => $kayttaja
            ));
            
        } else {
            $SESSION_['virhe'] = "Kayttajaa (id: " . $id .") ei löydy.";
            header('Location: kayttajat.php');
        }
    }
    
    public function tallenna($tila, $id, $etunimi, $sukunimi, $rooli, $kayttajatunnus, $salasana1, $salasana2){
        if ($tila === 'lisaa'){
            $kayttaja = new Kayttaja(NULL, NULL, NULL, NULL, NULL, NULL);
            $kayttaja->setSalasana($salasana1, $salasana2);
        }
        if ($tila == 'muokkaa'){
            $salasana_vaihdettu = "";
            $kayttaja = Kayttaja::hae($id);
            if (!empty($salasana1)){
                $kayttaja->setSalasana($salasana1, $salasana2);
                $salasana_vaihdettu = " ja salasana vaihdettu";
            }
        }
        $kayttaja->setNimi($etunimi, $sukunimi);
        $kayttaja->setRooli((int)$rooli);
        $kayttaja->setKayttajatunnus($kayttajatunnus);
        $virheet = $kayttaja->getVirheet();
        if (!empty($virheet)){
            naytaNakyma('views/kayttaja_lomake.php', array(
                'sivu' => $this->sivun_nimi,
                'title' => $this->title,
                'tila' => $tila,
                'virhe' => 'Käyttäjän tallennus epäonnistui',
                'kayttaja' => $kayttaja,
                'virheet' => $virheet,
            ));
        } else {
            if ($tila === 'lisaa'){
                $kayttaja->lisaaKantaan();
            }
            if ($tila === 'muokkaa'){
                $kayttaja->paivitaKantaan();
            }
            $_SESSION['ilmoitus'] = "Kayttaja tallennettu onnistuneesti" . $salasana_vaihdettu;
            header('Location: kayttajat.php?muokkaa='.$kayttaja->getId());
        }
    }
    
    public function poista($id){
        Kayttaja::poistaKannasta((int)$id, $_SESSION['kayttajan_id']);
        $_SESSION['ilmoitus'] = "Käyttäjä (id: " . $id .") poistettu.";
        header('Location: kayttajat.php');
    }
    
}
