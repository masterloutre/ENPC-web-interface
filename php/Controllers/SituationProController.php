<?php

include "../Global/connect.php";
require_once "../Models/SituationPro.php";


function create_situation_pro($arraySituation){
    return $situation = new SituationPro($arraySituation);
}

function add_situation_pro($db, SituationPro $situPro){
    
    if(situation_pro_exists($db, $situPro)){
        return 0;
    }
    
    try{

        $bdd_req = $db->prepare('INSERT INTO situation_pro (nom) VALUES ("'.$situPro->get_nom().'")');
        $bdd_req->execute();
        
    }catch(PDOException $e){
        echo "ADD SITUATION PRO FUNC ERROR : ".$e->getMessage();
        return 0;
    }
    
    $situPro->set_id($db->lastInsertId());
    return 1;
}

function delete_situation_pro($db, SituationPro $situPro){
    
    if(!situation_pro_exists($db, $situPro)){
        return 0;
    }
    
    try{
        
        $bdd_req = $db->prepare('DELETE FROM `situation_pro` WHERE `id` = '.$situPro->get_id());
        $bdd_req->execute();
    
    }catch(PDOException $e){
        echo "DELETE SITUATION PRO FUNC ERROR : ".$e->getMessage();
        return 0;
    }
    
    return 1;
}

function update_situation_pro($db, SituationPro $situPro){
    
    $prev_id = $situPro->get_id();
    $exists = situation_pro_exists($db, $situPro);
    
    if($exists && $prev_id != $situPro->get_id()){
        return 0;
    }
    
    try{
        
        $bdd_req = $db->prepare('UPDATE `situation_pro` SET nom = "'.$situPro->get_nom().'" WHERE `id` = '.$situPro->get_id());
        $bdd_req->execute();
    
    }catch(PDOException $e){
        echo "UPDATE SITUATION PRO FUNC ERROR : ".$e->getMessage();
        return 0;
    }
    
    return 1;
}

function situation_pro_exists($db, SituationPro $situPro){
    try{
        
        $bdd_req = $db->prepare('SELECT id FROM `situation_pro` WHERE nom = "'.$situPro->get_nom().'"');
        $bdd_req->execute();
        $result = $bdd_req->fetchAll();
        
    }catch(PDOException $e){
        $result = NULL;
        echo "SITUATION PRO EXISTS FUNC ERROR : ".$e->getMessage();
    }
    
    if($result == NULL){
        return 0;
    }else{
        $situPro->set_id($result[0]['id']);
        return 1;
    }
}

function get_situation_pro($db, $id){
    try{
        
        $bdd_req = $db->prepare('SELECT * FROM situation_pro WHERE id = '.$id);
        $bdd_req->execute();
        $result = $bdd_req->fetchAll();
        
    }catch(PDOException $e){
        echo "GET SITUATION PRO FUNC ERROR : ".$e->getMessage();
    }
    
    if($result == NULL){
        return NULL;
    }else{
        return create_situation_pro($result[0]);
    }
}

function get_all_situation_pro($db){
    try{
        
        $bdd_req = $db->prepare('SELECT * FROM situation_pro');
        $bdd_req->execute();
        $result = $bdd_req->fetchAll();

    }catch(PDOException $e){
        echo "GET ALL SITUATION PRO FUNC ERROR : ".$e->getMessage();
    }
    
    if($result == NULL){
        return NULL;
    }else{
        $tab_situ = array();
        
        foreach($result as $situ_pro){
            array_push($tab_situ, create_situation_pro($situ_pro));
        }
        
        return $tab_situ;
    }
}

 ?>
