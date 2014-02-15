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
            'sivu' => $sivun_nimi,
            'title' => "Raaka-aineen lisäys",
        ));
    }

}
