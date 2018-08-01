<?php

class Enseignant {

    /* Enseignant
    id :        int
    nom :       string
    prenom :    string
    login :     string identifiant de connexion
    admin :     bool
    mdp :       string mot de passe
    token :     token de sécurité
    */


    // Ligne à multiplier selon le nombre d'attributs
    private $id;
    private $nom;
    private $prenom;
    private $login;
    private $admin;
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

    public function get_prenom() {
        return $this->prenom;
    }

    public function set_prenom($prenom) {
        $this->prenom = $prenom;
    }

    public function get_login() {
        return $this->login;
    }

    public function set_login($login) {
        $this->login = $login;
    }

    public function get_admin() {
        return $this->admin;
    }

    public function set_admin($admin) {
        $this->admin = $admin;
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
