<?php

class LancementJeu {

    /* LANCEMENT JEU
    id :        int
    mdp :      mot de passe pour jouer à la phase
    phase :     numéro de la phase
    */


    // Ligne à multiplier selon le nombre d'attributs
    private $id;
    private $mdp;
    private $phase;


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

    public function get_mdp() {
        return $this->mdp;
    }

    public function set_mdp($mdp) {
        $this->mdp = $mdp;
    }
    
    public function get_phase(){
        return $this->phase;
    }
    
    public function set_phase($phase){
        $this->phase = $phase;
    }
    // Fin du multiplier--------------------------------
    
    public function get_vars(){
        $object = get_object_vars($this);
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
