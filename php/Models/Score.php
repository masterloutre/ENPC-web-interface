<?php

class Score {

    /* SCORE
    id :        int
    points :      score obtenu (grâce aux autres champs)
    tentatives :    nombre de tentatives effectuées
    temps : temps pour répondre
    aide :  si aide extérieure demandée
    */


    // Ligne à multiplier selon le nombre d'attributs
    private $id;
    private $points;
    private $tentatives;
    private $temps;
    private $aide;


    // Construction de la classe
    public function __construct(array $donnees) {
        return $this->hydrate($donnees);
    }

    // Set et get des attributs-----------------------
    // A multiplier selon le nombre d'attributs
    //ID
    public function get_id() {
        return $this->id;
    }

    public function set_id($id) {
        $this->id = $id;
    }
    //POINTS
    public function get_points() {
        return $this->points;
    }

    public function set_points($points) {
        $this->points = $points;
    }
    //TENTATIVES
    public function get_tentatives(){
        return $this->tentatives;
    }

    public function set_tentatives($tentatives){
        $this->tentatives = $tentatives;
    }
    //TEMPS
    public function get_temps(){
        return $this->temps;
    }

    public function set_temps($temps){
        $this->temps = $temps;
    }
    //AIDE
    public function get_aide(){
        return $this->aide;
    }

    public function set_aide($aide){
        $this->aide = $aide;
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
