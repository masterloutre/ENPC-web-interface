<?php

class Etudiant {

    /* ETUDIANT
    id :        int
    nom :      nom de famille de l'étudiant
    prenom :    prénom de l'étudiant
    promo :     année d'utilisation du jeu
    num_etud :  identifiant de l'étudiant au sein de l'école
    */


    // Ligne à multiplier selon le nombre d'attributs
    private $id;
    private $nom;
    private $prenom;
    private $promo;
    private $num_etud;


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
    
    public function get_prenom(){
        return $this->prenom;
    }
    
    public function set_prenom($prenom){
        $this->prenom = $prenom;
    }
    
    public function get_promo(){
        return $this->promo;
    }
    
    public function set_promo($promo){
        $this->promo = $promo;
    }
    
    public function get_num_etud(){
        return $this->num_etud;
    }
    
    public function set_num_etud($num_etud){
        $this->num_etud = $num_etud;
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