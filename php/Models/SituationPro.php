<?php

class SituationPro {

    /* SITUATION PRO
    id :       int
    nom :      nom de la situation professionnelle
    ratio :    rapport de points (%)
    */


    // Ligne à multiplier selon le nombre d'attributs
    private $id;
    private $nom;
    private $ratio;


    // Construction de la classe
    public function __construct(array $donnees) {
        return $this->hydrate($donnees);
    }

    // Set et get des attributs-----------------------
    // A multiplier selon le nombre d'attributs
    public function get_id() {
        return $this->id;
    }

    public function set_id($id) {
        $this->id = $id;
    }

    public function get_nom() {
        return $this->nom;
    }

    public function set_nom($nom) {
        $this->nom = $nom;
    }

    public function get_ratio() {
        return $this->ratio;
    }

    public function set_ratio($ratio) {
        $this->ratio = $ratio;
    }
    // Fin du multiplier--------------------------------

    // Hydrate
    public function hydrate(array $donnees) {
        foreach ($donnees as $key => $value) {
            // On récupère le nom du setter correspondant à l'attribut
            $method = 'set_'. ucfirst($key);

            // Si le setter correspondant existe :
            if(method_exists($this, $method)) {
                // On appelle le setter
                $this->$method($value);
            }
        }
    }
}

?>
