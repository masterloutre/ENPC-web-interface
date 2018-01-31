<?php

require "./Global/connect.php";
require_once "./Models/Enseignant.php";
require_once "./Controllers/SessionController.php";


function create_enseignant($arrayEnseignant){
    return $enseignant = new Enseignant($arrayEnseignant);
}

function add_enseignant($db, Enseignant $enseignant){

    if(enseignant_exists($db, $enseignant)){
        return 0;
    }

    try{
        $pass_hache = sha1('gz'.$enseignant->get_mdp());
        $enseignant->set_token(create_token($enseignant->get_login()));

        $bdd_req = $db->prepare('INSERT INTO enseignant (nom, prenom, login, mdp, token) VALUES ("'.$enseignant->get_nom().'", "'.$enseignant->get_prenom().'", "'.$enseignant->get_login().'", "'.$pass_hache.'", "'.$enseignant->get_token().'")');
        $bdd_req->execute();

    }catch(PDOException $e){
        echo "ADD ENSEIGNANT FUNC ERROR : ".$e->getMessage();
        return 0;
    }

    $enseignant->set_id($db->lastInsertId());
    return 1;
}

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

function update_enseignant($db, Enseignant $enseignant){

    $prev_id = $enseignant->get_id();
    $exists = enseignant_exists($db, $enseignant);

    if($exists && $prev_id != $enseignant->get_id()){
        return 0;
    }

    try{

        $bdd_req = $db->prepare('UPDATE `enseignant` SET nom = "'.$enseignant->get_nom().'", prenom = "'.$enseignant->get_prenom().'", login = "'.$enseignant->get_login().'" WHERE `id` = '.$enseignant->get_id());
        $bdd_req->execute();

    }catch(PDOException $e){
        echo "UPDATE ENSEIGNANT FUNC ERROR : ".$e->getMessage();
        return 0;
    }

    return 1;
}

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
