<?php

include "../Global/connect.php";
require_once "../Models/SituationPro.php";

/*****
TEST
*****/

// $array = [
//   "id" => 1,
//   "nom" =>  "Situation pro D"
// ];
//
// $situ_test = create_situation_pro($array);
//
// echo "id before : ".$situ_test->get_id()."<br>";
//
// add_situation_pro($db, $situ_test);
//
// echo "id after if exist + add : ".$situ_test->get_id()."<br>";
//
// //delete_situation_pro($db, $situ_test);
//
// $situ_test = get_situation_pro($db, 3);
//
// //echo "id after get : ".$situ_test->get_nom()."<br>";
//
// if($situ_test != NULL){
//     $situ_test->set_nom("Situation pro Z");
//     update_situation_pro($db, $situ_test);
// }
//
// $situarray = array();
// $situarray = get_all_situ_pro($db);
// var_dump($situarray);


/*****
FUNCTION
*****/

//create objet etudiant
function create_situation_pro($arraySituation){
    return $situation = new SituationPro($arraySituation);
}

//ajout $etudiant en bdd
//verif si exist dans la fonction
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

//delete selon l'id dans $etudiant
//verif si exist dans la fonction
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

//remplace tous les champs en bdd selon ceux de $etudiant
//verif si exist dans la fonction
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

//set bon id dans $etudiant where num_etud = $num_etud
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

//get where id = $id
//retourne un etudiant
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

//select *
//retourne un tableau d'etudiant
function get_all_situ_pro($db){
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
