<?php

/**
 * Raaka-aineiden ohjain
 *
 * @author Sami-Joonas Saarinen
 */
class RaakaaineetOhjain {

    private $sivun_nimi = 'raaka-aineet';
    
    public function nayta($id) {

        $id = (int) $id;

        $raakaaine = Raakaaine::hae($id);
        if ($raakaaine != null) {
            $_SESSION['raakaaine'] = $raakaaine;
            naytaNakyma("views/raakaaine_nayta.php", array(
                'sivu' => $this->sivun_nimi,
                'title' => htmlspecialchars($raakaaine->getNimi()),
                'raakaaine' => $raakaaine
            ));
        } else {
            naytaNakyma("views/raakaaine_nayta.php", array(
                'sivu' => $this->sivun_nimi,
                'title' => "Virhe!",
                'raakaaine' => null,
                'virhe' => 'Raaka-ainetta ei löytynyt'
            ));
        }
    }
    
    public function lista($sivu){
        $raakaaineet = Raakaaine::haeSivu($sivu, 10);
        $lukumaara = Raakaaine::raakaaineidenLkm();
        naytaNakyma("views/raakaaine_listaa.php", array(
            'sivu' => $this->sivun_nimi,
            'title' => "Raaka-aineet",
            'raakaaineet' => $raakaaineet,
            'lkm' => $lukumaara
        ));
    }
    
    public function lisaa(){
        naytaNakyma("views/raakaaine_lisaa.php", array(
            'sivu' => $this->sivun_nimi,
            'title' => "Raaka-aineen lisäys",
        ));
    }
    
    public function tallenna($nimi, $kalorit, $hiilarit, $proteiinit, $rasvat, $hinta){
        $uusiraakaaine = new Raakaaine(null, null, null, null, null, null, null);
        $uusiraakaaine->setNimi($nimi);
        $uusiraakaaine->setKalorit($kalorit);
        $uusiraakaaine->setHiilarit($hiilarit);
        $uusiraakaaine->setProteiinit($proteiinit);
        $uusiraakaaine->setRasvat($rasvat);
        $uusiraakaaine->setHinta($hinta);

        if ($uusiraakaaine->onkoKelvollinen()) {
            $uusiraakaaine->lisaaKantaan();
            $_SESSION['ilmoitus'] = "Raaka-aine lisätty onnistuneesti.";
            header('Location: raakaaineet.php');
        } else {
            $virheet = $uusiraakaaine->getVirheet();
            naytaNakyma("views/raakaaine_lisaa.php", array(
                'sivu' => $this->sivun_nimi,
                'title' => "Raaka-aineen lisäys",
                'virhe' => "Raaka-aineen tallennus epäonnistui!",
                'raakaaine' => $uusiraakaaine,
                'virheet' => $virheet
            ));
        }
    }
    
    public function muokkaa($id){
        
         $id = (int)$id;

        $raakaaine = Raakaaine::hae($id);
        if ($raakaaine != null) {
            $_SESSION['raakaaine'] = $raakaaine;
            naytaNakyma("views/raakaaine_muokkaa.php", array(
                'sivu' => $this->sivun_nimi,
                'title' => htmlspecialchars($raakaaine->getNimi()),
                'raakaaine' => $raakaaine
            ));
        } else {
            naytaNakyma("views/raakaaine_nayta.php", array(
                'sivu' => $this->sivun_nimi,
                'title' => "Virhe!",
                'raakaaine' => null,
                'virhe' => 'Raaka-ainetta ei löytynyt'
            ));
        }
    }
    
    public function paivita($nimi, $kalorit, $hiilarit, $proteiinit, $rasvat, $hinta){
        
        $uusiraakaaine = $_SESSION['raakaaine'];
        $uusiraakaaine->setNimi($_POST['nimi']);
        $uusiraakaaine->setKalorit($_POST['kalorit']);
        $uusiraakaaine->setHiilarit($_POST['hiilarit']);
        $uusiraakaaine->setProteiinit($_POST['proteiinit']);
        $uusiraakaaine->setRasvat($_POST['rasvat']);
        $uusiraakaaine->setHinta($_POST['hinta']);

        if ($uusiraakaaine->onkoKelvollinen()) {
            unset($_SESSION['raakaaine']);
            $uusiraakaaine->paivitaKantaan();
            $_SESSION['ilmoitus'] = "Raaka-aineen tiedot päivitetty onnistuneesti.";
            header('Location: raakaaineet.php');
        } else {
            $virheet = $uusiraakaaine->getVirheet();
            naytaNakyma("views/raakaaine_muokkaa.php", array(
                'sivu' => $this->sivun_nimi,
                'title' => "Raaka-aineen lisäys",
                'virhe' => "Raaka-aineen tallennus epäonnistui!",
                'raakaaine' => $uusiraakaaine,
                'virheet' => $virheet
            ));
        }
    }
    
    public function poista(){
        $raakaaine = $_SESSION['raakaaine'];
        unset($_SESSION['raakaaine']);
        $poistuiko = $raakaaine->poistaKannasta();
        if ($poistuiko){
            $_SESSION['ilmoitus'] = "Raaka-aine poistettu onnistuneesti.";
            header('Location: raakaaineet.php');
        } else {
            naytaNakyma("views/raakaaine_nayta.php", array(
                'sivu' => $this->sivun_nimi,
                'virhe' => "Raaka-ainetta ei voi poistaa, se kuuluu johonkin reseptiin!",
                'title' => htmlspecialchars($raakaaine->getNimi()),
                'raakaaine' => $raakaaine    ));
        }
    }
    
    public function hae($nimi){
        
        $raakaaineet = Raakaaine::haeNimella($nimi);
        //$lukumaara = Raakaaine::raakaaineidenLkm();
        naytaNakyma("views/raakaaine_listaa.php", array(
            'sivu' => $this->sivun_nimi,
            'title' => "Raaka-aineet",
            'raakaaineet' => $raakaaineet,
            'lkm' => count($raakaaineet)
        ));
        
    }

}
