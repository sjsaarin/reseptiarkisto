<?php

require_once 'libs/common.php';
require_once 'libs/tietokantayhteys.php';
require_once 'libs/models/Menu.php';
require_once 'libs/models/Resepti.php';

class MenutOhjain{
    
    private $sivun_nimi = 'menut';
    private $title = 'Menut';
    
    public function lista(){
        $menut = Menu::haeKaikki();
        naytaNakyma('views/menu_listaa.php', array(
            'sivu' => $this->sivun_nimi,
            'title' => $this->title,
            'menut' => $menut
        ));
    }
    
    public function lisaa(){
        $menun_osat = Menu::haeOsat();
        $reseptit = Resepti::haeKaikki();
        naytaNakyma('views/menu_lomake.php', array(
            'tila' => 'lisaa',
            'sivu' => $this->sivun_nimi,
            'title' => $this->title,
            'menun_osat' => $menun_osat,
            'reseptit' => $reseptit
        ));
    }
    
    public function muokkaa($id){
        $menu = Menu::hae((int)$id);
        if (!empty($menu)){
            $_SESSION['menu'] = $menu;
            $menun_osat = Menu::haeOsat();
            $reseptit = Resepti::haeKaikki();
            $menun_reseptit = $menu->haeMenunReseptienNimet();
            naytaNakyma('views/menu_lomake.php', array(
                'tila' => 'muokkaa',
                'sivu' => $this->sivun_nimi,
                'title' => $this->title,
                'menu' => $menu,
                'menun_osat' => $menun_osat,
                'menun_reseptit' => $menun_reseptit,
                'reseptit' => $reseptit
            ));
        } else {
            $_SESSION['virhe'] = "Menuta (id: " . $id . ") ei löydy";
            header('Location: menut.php');
        }
        
    }
    
    public function tallenna($tila, $nimi, $alkuruoka, $valiruoka1, $paaruoka, $valiruoka2, $jalkiruoka, $kuvaus){
        if ($tila === 'lisaa'){
            $menu = new Menu(NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
        } 
        if ($tila == 'muokkaa') {
            $menu = $_SESSION['menu'];
            unset($_SESSION['menu']);
        }
        $menu->setNimi($nimi);
        $menu->setAlkuruoka((int)$alkuruoka);
        $menu->setValiruoka1((int)$valiruoka1);
        $menu->setPaaruoka((int)$paaruoka);
        $menu->setValiruoka2((int)$valiruoka2);
        $menu->setJalkiruoka((int)$jalkiruoka);
        $menu->setKuvaus($kuvaus);
        $virheet = $menu->getVirheet();
        
        if (!empty($virheet)){
            $menun_reseptit = $menu->haeMenunReseptienNimet();
            $menun_osat = Menu::haeOsat();
            $reseptit = Resepti::haeKaikki();
            naytaNakyma('views/menu_lomake.php', array(
                'tila' => $tila,
                'sivu' => $this->sivun_nimi,
                'title' => $this->title,
                'virhe' => "Menun tallennus epäonnistui",
                'menu' => $menu,
                'virheet' => $virheet,
                'menun_osat' => $menun_osat,
                'menun_reseptit' => $menun_reseptit,
                'reseptit' => $reseptit
            ));
        } else {
            if ($tila === 'lisaa'){
                $menu->lisaaKantaan();
            } 
            if ($tila == 'muokkaa') {
                $menu->paivitaKantaan();
            }
            $_SESSION['ilmoitus'] = "Menu tallennettu onnistuneesti";
            header('Location: menut.php?nayta=' . $menu->getId());
        }
    }
    
    public function nayta($id){
        
        $menu = Menu::hae((int)$id);
        
        if (!empty($menu)){
            $menun_reseptit = $menu->haeMenunReseptienNimet();
            naytaNakyma('views/menu_nayta.php', array(
                'sivu' => $this->sivun_nimi,
                'title' => $this->title,
               'menun_reseptit' => $menun_reseptit,
               'menu' => $menu
            ));
        } else {
            $_SESSION['virhe'] = "Menuta (id: ". $id . ") ei löydy!";
            header('Location: menut.php');
        }
        
    }
    
    public function poista($id){
        $poistuiko = Menu::poistaMenuKannasta((int)$id);
        if ($poistuiko){
            $_SESSION['ilmoitus'] = "Menu poistettu onnistuneesti";
            header('Location: menut.php');
        } else {
            $_SESSION['virhe'] = "Menun poisto epäonnistui";
            header('Location: menut.php?nayta=' . $id);
        }
        
    }
    
    public function hae($sivu, $nimi){
        $menut = Menu::haeNimella($nimi, $sivu, 10);
        $lukumaara = Menu::menuidenLkm($nimi);
        $sivuja = ceil($lukumaara/10);
        naytaNakyma("views/menu_listaa.php", array(
            'sivu' => $this->sivun_nimi,
            'title' => "Menut",
            'menut' => $menut,
            'sivuja' => $sivuja,
            'sivunro' => $sivu,
            'nimi' => $nimi
        ));
    }
    
}

