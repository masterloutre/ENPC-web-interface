<?php

include "../Global/connect.php";
require_once "../Models/Etudiant.php";

$array = [
  "id" => 1,
  "nom" =>  "Rose",
  "prenom" => "Daphné",
  "promo" => "2020",
  "num_etud" => "1231454444",
];

$etud_test = create_etudiant($array);

echo "id before : ".$etud_test->get_id()."<br>";

add_etudiant($db, $etud_test);

echo "id after : ".$etud_test->get_id();

//create objet etudiant
function create_etudiant($arrayEtudiant){
    return $etudiant = new Etudiant($arrayEtudiant);
}

//ajout objet etudiant en bdd
function add_etudiant($db, $etudiant){
    try{
        
    $bdd_req = $db->prepare('INSERT INTO etudiant(nom, prenom, num_etud, promo, mdp) VALUES ("'.$etudiant->get_nom().'","'.$etudiant->get_prenom().'",'.$etudiant->get_num_etud().','.$etudiant->get_promo().',"test")');
    $bdd_req->execute();
        
    }catch(PDOException $e){
        echo "PDO ERROR : ".$e->getMessage();
    }
    
    $etudiant->set_id($db->lastInsertId());
}

//delete where id = $id
function delete_etudiant($id){
    
}

//remplace tous les champs en bdd selon l'objet en paramètre
function update_etudiant($etudiant){
    
}

//retourne id where num_etud = $num_etud
function etudiant_exists($num_etud){
    
}

//get where id = $id
function getEtudiant($id){
    
}

//select *
function getAll(){
    
}

 ?>
