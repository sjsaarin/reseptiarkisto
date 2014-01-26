<?php
class Kayttaja {
  
  private $id;
  private $etunimi;
  private $sukunimi;
  private $kayttajatunnus;
  private $salasana;

  public function __construct($id, $etunimi, $sukunimi, $kayttajatunnus, $salasana) {
    $this->id = $id;
    $this->etunimi = $etunimi;
    $this->sukunimi = $sukunimi;
    $this->kayttajatunnus = $kayttajatunnus;
    $this->salasana = $salasana;
  }

  /* Tähän gettereitä ja settereitä */
}