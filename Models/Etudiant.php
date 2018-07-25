<?php

class Etudiant {

    /* ETUDIANT
    id :        int
    nom :      nom de famille de l'étudiant
    prenom :    prénom de l'étudiant
    promo :     année d'utilisation du jeu
    num_etud :  identifiant de l'étudiant au sein de l'école
    mdp :       mot de passe
    token :     token de sécurité pour authentifier une session
    */


    // Ligne à multiplier selon le nombre d'attributs
    private $id;
    private $nom;
    private $prenom;
    private $promo;
    private $num_etud;
    private $mdp;
    private $token;


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

    public function get_mdp(){
        return $this->mdp;
    }

    public function set_mdp($mdp){
        $this->mdp = $mdp;
    }

    public function get_token(){
        return $this->token;
    }

    public function set_token($token){
        $this->token = $token;
    }
    // Fin du multiplier--------------------------------
    
    public function get_vars(){
        $object = get_object_vars($this);
        unset($object['id']);
        //unset($object['mdp']);
        unset($object['token']);
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
