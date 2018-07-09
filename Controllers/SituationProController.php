<?php

require "./Global/connect.php";
require_once "./Models/SituationPro.php";
require_once "./Models/Enigme.php";

/*****
FUNCTION
*****/

//create objet etudiant
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

function get_situation_pro_from_enigme($db, Enigme $enigme)
{
  try {
    $db_req = $db->prepare('SELECT situation_pro.id, situation_pro.nom, rel_enigme_situation_pro.ratio
      FROM situation_pro
      INNER JOIN rel_enigme_situation_pro ON rel_enigme_situation_pro.situation_pro_id = situation_pro.id
      INNER JOIN enigme ON rel_enigme_situation_pro.enigme_id = enigme.id
      WHERE enigme.id = '.$enigme->get_id()
    );
    $db_req->execute();
    $situation_pro_tab = [];
    $result = $db_req->fetchAll();
    if (!empty($result))
    {
      for ($i = 0; $i < count($result); ++$i)
      {
        $situation_pro_tab[] = create_situation_pro($result[$i]);
      }
      return $situation_pro_tab;
    }
    else { return $situation_pro_tab; }
  }
  catch(PDOException $e) {
    echo "Selection failed: " . $e->getMessage();
    return false;
  }
}

function add_ratio_situation_pro_enigme($db, $enigme_id, $situation_id, $ratio)
{
    try{
        $db_req = $db->prepare('INSERT INTO `rel_enigme_situation_pro` (`enigme_id`, `situation_pro_id`, `ratio`) VALUES ('.$enigme_id.', '.$situation_id.', '.$ratio.')');
        $db_req->execute();
    }
    catch(PDOException $e) {
    echo "add ratio failed: " . $e->getMessage();
    return false;
  }
    return 1;
}

 ?>
