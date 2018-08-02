<?php

class SituationPro {

    /* SITUATION PRO
    id :       int
    nom :      nom de la situation professionnelle
    ratio :    rapport de points (%)
    couleur :  hexadécimal de couleur pour affichage
    */


    // Ligne à multiplier selon le nombre d'attributs
    private $id;
    private $nom;
    private $ratio;
    private $couleur;


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

    public function get_couleur() {
        return $this->couleur;
    }

    public function set_couleur($couleur) {
        $this->couleur = $couleur;
    }
    // Fin du multiplier--------------------------------
    
    public function get_vars(){
        $object = get_object_vars($this);
        unset($object['id']);
        unset($object['ratio']);
        return $object;
    }

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
