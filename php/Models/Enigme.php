<?php

class Enigme {

    /* ENIGME
    id :                int
    index_unity :       index de l'énigme identique à celui de Unity
    type :              QCM (1) INSERT (2) ALGO (3)
    nom :               nom de l'énigme
    temps_max :         temps conseillé pour l'énigme
    difficulte :        1 - 2 - 3
    score_max :         score maximum possible calculé
    tentatives_max :    tentatives maximum authorisées
    competence :        objet competence
    */


    // Ligne à multiplier selon le nombre d'attributs
    private $id;
    private $index_unity;
    private $type;
    private $nom;
    private $temps_max;
    private $difficulte;
    private $score_max;
    private $tentatives_max;
    private $competence;


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

    public function get_index_unity() {
        return $this->index_unity;
    }

    public function set_index_unity($index_unity) {
        $this->index_unity = $index_unity;
    }

    public function get_type() {
        return $this->type;
    }

    public function set_type($type) {
        $this->type = $type;
    }

    public function get_nom() {
        return $this->nom;
    }

    public function set_nom($nom) {
        $this->nom = $nom;
    }

    public function get_temps_max() {
        return $this->temps_max;
    }

    public function set_temps_max($temps_max) {
        $this->temps_max = $temps_max;
    }

    public function get_difficulte() {
        return $this->difficulte;
    }

    public function set_difficulte($difficulte) {
        $this->difficulte = $difficulte;
    }

    public function get_score_max() {
        return $this->score_max;
    }

    public function set_score_max($score_max) {
        $this->score_max = $score_max;
    }

    public function get_tentatives_max() {
        return $this->tentatives_max;
    }

    public function set_tentatives_max($tentatives_max) {
        $this->tentatives_max = $tentatives_max;
    }

    public function get_competence() {
        return $this->competence;
    }

    public function set_competence($competence) {
        $this->competence = $competence;
    }
    // Fin du multiplier--------------------------------

    public function get_vars(){
        $object = get_object_vars($this);
        unset($object['id']);
        if($object['competence'] != NULL){
            $object['competence'] = $object['competence']->get_nom();
        }else{
            unset($object['competence']);
        }
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
