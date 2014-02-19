<?php

/**
 *
 * @author Sami-Joonas Saarinen
 */
class KirjautuminenOhjain {
    
    private $title = "Kirjautuminen";
    
    public function kirjauduSisaan($kayttajatunnus, $salasana){
        
       if (empty($kayttajatunnus)){
            naytaNakyma("views/kirjautuminen.php", array(
                'title' => $this->title,
                'virhe' => "Kirjautuminen epäonnistui! Et antanut käyttäjätunnusta." 
                ));
            exit();
        }
        $annettu_kayttajatunnus = $kayttajatunnus;
    
        if (empty($salasana)){
            naytaNakyma("views/kirjautuminen.php", array(
                'title' => $this->title,
                'kayttaja' => $annettu_kayttajatunnus,
                'virhe' => "Kirjautuminen epäonnistui! Et antanut salasanaa."
                ));
            exit();
        }
        $annettu_salasana = $salasana;
    
        $kayttaja = Kayttaja::haeKayttajaTunnuksilla($annettu_kayttajatunnus, $annettu_salasana);
    
        if (!empty($kayttaja)){
            session_start();
            $_SESSION['kayttaja']=$kayttaja;
            $_SESSION['kayttajan_rooli']=$kayttaja->getRooli();
            $_SESSION['kayttajan_id']=$kayttaja->getId();
            header('Location: index.php');
        } else {
            naytaNakyma("views/kirjautuminen.php", array(
                'title' => $this->title,
                'kayttaja' => $kayttajatunnus,
                'virhe' => "Kirjautuminen epäonnistui! Antamasi tunnus tai salasana on väärä."
        ));
        } 
        
    }
    
    public function kirjauduUlos(){
        unset($_SESSION['kayttaja']);
        unset($_SESSION['kayttajan_rooli']);
        unset($_SESSION['kayttajan_id']);
        header('Location: kirjautuminen.php');
        
    }
    
    public function naytaKirjautuminen(){
                naytaNakyma("views/kirjautuminen.php", array(
                    'title' => $this->title
                ));
    }
    
}
