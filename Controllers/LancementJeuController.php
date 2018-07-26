<?php

require "./Global/connect.php";
require_once "./Models/LancementJeu.php";


function create_lancement_jeu($arrayLancement){
    return $lancement = new LancementJeu($arrayLancement);
}

function add_lancement_jeu($db, LancementJeu $lancement){
    
    if(lancement_jeu_exists($db, $lancement)){
        return 0;
    }

    try{

        $bdd_req = $db->prepare('INSERT INTO lancement_jeu (mdp, phase) VALUES ("'.$lancement->get_mdp().'", '.$lancement->get_phase().')');
        $bdd_req->execute();

    }catch(PDOException $e){
        echo "ADD LANCEMENT JEU FUNC ERROR : ".$e->getMessage();
        return 0;
    }

    $lancement->set_id($db->lastInsertId());
    return 1;
}

function delete_lancement_jeu($db, LancementJeu $lancement){

    if(!lancement_jeu_exists($db, $lancement)){
        return 0;
    }

    try{

        $bdd_req = $db->prepare('DELETE FROM `lancement_jeu` WHERE `id` = '.$lancement->get_id());
        $bdd_req->execute();

    }catch(PDOException $e){
        echo "DELETE LANCEMENT JEU FUNC ERROR : ".$e->getMessage();
        return 0;
    }

    return 1;
}

function update_lancement_jeu($db, LancementJeu $lancement){

    $prev_id = $lancement->get_id();
    $exists = lancement_jeu_exists($db, $lancement);

    if($exists && $prev_id != $lancement->get_id()){
        return 0;
    }

    try{

        $bdd_req = $db->prepare('UPDATE `lancement_jeu` SET mdp = "'.$lancement->get_mdp().'", phase = '.$lancement->get_phase().' WHERE `id` = '.$lancement->get_id());
        $bdd_req->execute();

    }catch(PDOException $e){
        echo "UPDATE LANCEMENT JEU FUNC ERROR : ".$e->getMessage();
        return 0;
    }

    return 1;
}

function lancement_jeu_exists($db, LancementJeu $lancement){
    try{

        $bdd_req = $db->prepare('SELECT id FROM `lancement_jeu` WHERE id = '.$lancement->get_id());
        $bdd_req->execute();
        $result = $bdd_req->fetchAll();

    }catch(PDOException $e){
        $result = NULL;
        echo "LANCEMENT JEU EXISTS FUNC ERROR : ".$e->getMessage();
    }

    if($result == NULL){
        return 0;
    }else{
        $lancement->set_id($result[0]['id']);
        return 1;
    }
}

function get_lancement_jeu($db, $id){
    try{

        $bdd_req = $db->prepare('SELECT * FROM lancement_jeu WHERE id = '.$id);
        $bdd_req->execute();
        $result = $bdd_req->fetchAll();

    }catch(PDOException $e){
        echo "GET LANCEMENT JEU FUNC ERROR : ".$e->getMessage();
    }

    if($result == NULL){
        return NULL;
    }else{
        return create_lancement_jeu($result[0]);
    }
}

function get_all_lancement_jeu($db){
    try{

        $bdd_req = $db->prepare('SELECT * FROM lancement_jeu');
        $bdd_req->execute();
        $result = $bdd_req->fetchAll();

    }catch(PDOException $e){
        echo "GET ALL LANCEMENT JEU FUNC ERROR : ".$e->getMessage();
    }

    if($result == NULL){
        return NULL;
    }else{
        $tab_phase = array();

        foreach($result as $phase){
            array_push($tab_phase, create_lancement_jeu($phase));
        }

        return $tab_phase;
    }
}

 ?>
