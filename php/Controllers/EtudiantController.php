<?php

include "../Global/connect.php";
require_once "../Models/Etudiant.php";


function create_etudiant($arrayEtudiant){
    return $etudiant = new Etudiant($arrayEtudiant);
}

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

function update_etudiant($db, Etudiant $etudiant){
    
    $prev_id = $etudiant->get_id();
    $exists = etudiant_exists($db, $etudiant);
    
    if($exists && $prev_id != $etudiant->get_id()){
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

function get_etudiant($db, $id){
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

function get_all_etudiant($db){
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
