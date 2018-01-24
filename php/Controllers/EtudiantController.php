<?php

include "../Global/connect.php";
require_once "../Models/Etudiant.php";

/*****
TEST
*****/

$array = [
  "id" => 1,
  "nom" =>  "Rose",
  "prenom" => "Daphné",
  "promo" => "2020",
  "num_etud" => "1374634124",
];

$etud_test = create_etudiant($array);

echo "id before : ".$etud_test->get_id()."<br>";

add_etudiant($db, $etud_test);

echo "id after if exist + add : ".$etud_test->get_id()."<br>";

delete_etudiant($db, $etud_test);

$etud_test = getEtudiant($db, 3);

if($etud_test != NULL){
    $etud_test->set_nom("Lovegood");
    update_etudiant($db, $etud_test);
}

//getAll($db);


/*****
FUNCTION
*****/

//create objet etudiant
function create_etudiant($arrayEtudiant){
    return $etudiant = new Etudiant($arrayEtudiant);
}

//ajout $etudiant en bdd
//verif si exist dans la fonction
function add_etudiant($db, Etudiant $etudiant){
    
    if(etudiant_exists($db, $etudiant)){
        return 0;
    }
    
    try{
        
    $bdd_req = $db->prepare('INSERT INTO etudiant(nom, prenom, num_etud, promo, mdp) VALUES ("'.$etudiant->get_nom().'","'.$etudiant->get_prenom().'",'.$etudiant->get_num_etud().','.$etudiant->get_promo().',"test")');
    $bdd_req->execute();
        
    }catch(PDOException $e){
        echo "ADD ETUDIANT FUNC ERROR : ".$e->getMessage();
        return 0;
    }
    
    $etudiant->set_id($db->lastInsertId());
    return 1;
}

//delete selon l'id dans $etudiant
//verif si exist dans la fonction
function delete_etudiant($db, Etudiant $etudiant){
    
    if(!etudiant_exists($db, $etudiant)){
        return 0;
    }
    
    try{
        
    $bdd_req = $db->prepare('DELETE FROM `etudiant` WHERE `id` = '.$etudiant->get_id());
    $bdd_req->execute();
    
    }catch(PDOException $e){
        echo "DELETE ETUDIANT FUNC ERROR : ".$e->getMessage();
        return 0;
    }
    
    return 1;
}

//remplace tous les champs en bdd selon ceux de $etudiant
//verif si exist dans la fonction
function update_etudiant($db, Etudiant $etudiant){
    
    if(!etudiant_exists($db, $etudiant)){
        return 0;
    }
    
    try{
        
    $bdd_req = $db->prepare('UPDATE `etudiant` SET nom = "'.$etudiant->get_nom().'", prenom = "'.$etudiant->get_prenom().'", num_etud = '.$etudiant->get_num_etud().', promo = '.$etudiant->get_promo().' WHERE `id` = '.$etudiant->get_id());
    $bdd_req->execute();
    
    }catch(PDOException $e){
        echo "UPDATE ETUDIANT FUNC ERROR : ".$e->getMessage();
        return 0;
    }
    
    return 1;
}

//set bon id dans $etudiant where num_etud = $num_etud
function etudiant_exists($db, Etudiant $etudiant){
    try{
        
    $bdd_req = $db->prepare('SELECT id FROM `etudiant` WHERE num_etud = '.$etudiant->get_num_etud());
    $bdd_req->execute();
    $result = $bdd_req->fetchAll();
        
    }catch(PDOException $e){
        $result = NULL;
        echo "ETUDIANT EXISTS FUNC ERROR : ".$e->getMessage();
    }
    
    if($result == NULL){
        return 0;
    }else{
        $etudiant->set_id($result[0]['id']);
        return 1;
    }
}

//get where id = $id
//retourne un etudiant
function getEtudiant($db, $id){
    try{
        
    $bdd_req = $db->prepare('SELECT * FROM etudiant WHERE id = '.$id);
    $bdd_req->execute();
    $result = $bdd_req->fetchAll();
        
    }catch(PDOException $e){
        echo "GET ETUDIANT FUNC ERROR : ".$e->getMessage();
    }
    
    if($result == NULL){
        return NULL;
    }else{
        return create_etudiant($result[0]);
    }
}

//select *
//retourne un tableau d'etudiant
function getAll($db){
    try{
        
    $bdd_req = $db->prepare('SELECT * FROM etudiant');
    $bdd_req->execute();
    $result = $bdd_req->fetchAll();
        
    }catch(PDOException $e){
        echo "GET ALL ETUDIANT FUNC ERROR : ".$e->getMessage();
    }
    
    if($result == NULL){
        return NULL;
    }else{
        $tab_etud = array();
        
        foreach($result as $etud){
            array_push($tab_etud, create_etudiant($etud));
        }
        
        return $tab_etud;
    }
}

 ?>
