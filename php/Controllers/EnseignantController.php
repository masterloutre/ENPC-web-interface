<?php

include "../Global/connect.php";
require_once "../Models/Enseignant.php";

/*****
TEST
*****/

$array = [
  "id" => 1,
  "nom" =>  "Cherrier",
  "prenom" => "Sylvain",
  "login" => "sylvaincherrier",
  "admin" => "0",
];

$prof_test = create_enseignant($array);

echo "id before : ".$prof_test->get_id()."<br>";

add_enseignant($db, $prof_test);

echo "id after if exist + add : ".$prof_test->get_id()."<br>";

//delete_enseignant($db, $prof_test);

$prof_test = get_enseignant($db, 1);

echo "id after get enseignant : ".$prof_test->get_id()."<br>";

if($prof_test != NULL){
    $prof_test->set_nom("Dumbledore");
    update_enseignant($db, $prof_test);
}

$tab_test = array();
$tab_test = get_all_enseignant($db);
var_dump($tab_test);


/*****
FUNCTION
*****/

//create objet enseignant
function create_enseignant($arrayEnseignant){
    return $enseignant = new Enseignant($arrayEnseignant);
}

//ajout $enseignant en bdd
//verif si exist dans la fonction
function add_enseignant($db, Enseignant $enseignant){
    
    if(enseignant_exists($db, $enseignant)){
        return 0;
    }
    
    try{
        
    $bdd_req = $db->prepare('INSERT INTO enseignant (nom, prenom, login, admin, mdp) VALUES ("'.$enseignant->get_nom().'","'.$enseignant->get_prenom().'","'.$enseignant->get_login().'",'.$enseignant->get_admin().',"test")');
    $bdd_req->execute();
        
    }catch(PDOException $e){
        echo "ADD ENSEIGNANT FUNC ERROR : ".$e->getMessage();
        return 0;
    }
    
    $enseignant->set_id($db->lastInsertId());
    return 1;
}

//delete selon l'id dans $enseignant
//verif si exist dans la fonction
function delete_enseignant($db, Enseignant $enseignant){
    
    if(!enseignant_exists($db, $enseignant)){
        return 0;
    }
    
    try{
        
    $bdd_req = $db->prepare('DELETE FROM `enseignant` WHERE `id` = '.$enseignant->get_id());
    $bdd_req->execute();
    
    }catch(PDOException $e){
        echo "DELETE ENSEIGNANT FUNC ERROR : ".$e->getMessage();
        return 0;
    }
    
    return 1;
}

//remplace tous les champs en bdd selon ceux de $enseignant
//verif si exist dans la fonction
function update_enseignant($db, Enseignant $enseignant){
    
    if(!enseignant_exists($db, $enseignant)){
        return 0;
    }
    
    try{
        
    $bdd_req = $db->prepare('UPDATE `enseignant` SET nom = "'.$enseignant->get_nom().'", prenom = "'.$enseignant->get_prenom().'", login = "'.$enseignant->get_login().'", admin = '.$enseignant->get_admin().' WHERE `id` = '.$enseignant->get_id());
    $bdd_req->execute();
    
    }catch(PDOException $e){
        echo "UPDATE ENSEIGNANT FUNC ERROR : ".$e->getMessage();
        return 0;
    }
    
    return 1;
}

//set bon id dans $enseignant avec login de l'objet en paramètre
function enseignant_exists($db, Enseignant $enseignant){
    try{
        
    $bdd_req = $db->prepare('SELECT id FROM `enseignant` WHERE login = "'.$enseignant->get_login().'"');
    $bdd_req->execute();
    $result = $bdd_req->fetchAll();
        
    }catch(PDOException $e){
        $result = NULL;
        echo "ENSEIGNANT EXISTS FUNC ERROR : ".$e->getMessage();
    }
    
    if($result == NULL){
        return 0;
    }else{
        $enseignant->set_id($result[0]['id']);
        return 1;
    }
}

//get where id = $id
//retourne un enseignant
function get_enseignant($db, $id){
    try{
        
    $bdd_req = $db->prepare('SELECT * FROM enseignant WHERE id = '.$id);
    $bdd_req->execute();
    $result = $bdd_req->fetchAll();
        
    }catch(PDOException $e){
        echo "GET ENSEIGNANT FUNC ERROR : ".$e->getMessage();
    }
    
    if($result == NULL){
        return NULL;
    }else{
        return create_enseignant($result[0]);
    }
}

//retourne un tableau d'enseignant
function get_all_enseignant($db){
    try{
        
    $bdd_req = $db->prepare('SELECT * FROM enseignant');
    $bdd_req->execute();
    $result = $bdd_req->fetchAll();
        
    }catch(PDOException $e){
        echo "GET ALL ENSEIGNANT FUNC ERROR : ".$e->getMessage();
    }
    
    if($result == NULL){
        return NULL;
    }else{
        $tab_prof = array();
        
        foreach($result as $prof){
            array_push($tab_prof, create_enseignant($prof));
        }
        
        return $tab_prof;
    }
}

 ?>
