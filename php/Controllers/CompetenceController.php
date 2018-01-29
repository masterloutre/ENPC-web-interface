<?php

include "../Global/connect.php";
include "../Global/global.php";
require_once "../Models/Competence.php";

//var_dump(get_moyenne_score_from_competence($db, $competence2));

function create_competence($array_competence)
{
  return new Competence($array_competence);
}

function add_competence($db, Competence $competence)
{
  if(!competence_exists($db, $competence))
  {
    try {
      $db_req = $db->prepare(
        'INSERT INTO competence
         (nom)
         VALUES ("'.$competence->get_nom().'")');
      $db_req->execute();
      $competence->set_id($db->lastInsertId());
      return true;
    }
    catch(PDOException $e) {
      echo "Insertion failed: " . $e->getMessage();
      return false;
    }
  }
  else { return false; }
}

function update_competence($db, Competence $competence)
{
  if(competence_exists($db, $competence) && $competence->get_id() != NULL)
  {
    try {
      $db_req = $db->prepare(
        'UPDATE competence
         SET nom = "'.$competence->get_nom().'"
         WHERE competence.id = '.$competence->get_id()
        );
      $db_req->execute();
    }
    catch(PDOException $e) { echo "Update failed: " . $e->getMessage(); }
    return true;
  }
  else { return false; }
}

function delete_competence($db, Competence $competence)
{
  if(competence_exists($db, $competence))
  {
    try {
      $db_req = $db->prepare(
        'DELETE
         FROM competence
         WHERE competence.id = '.$competence->get_id()
        );
      $db_req->execute();
      return true;
    }
    catch(PDOException $e) { echo "Deletion failed: " . $e->getMessage(); }
  }
  else { return false; }
}

function competence_exists($db, Competence $competence)
{
  if ($competence->get_id() != NULL)
  {
    try {
      $db_req = $db->prepare(
        'SELECT id
         FROM competence
         WHERE competence.id= '.$competence->get_id()
        );
      $db_req->execute();
      $result = $db_req->fetchAll();
    }
    catch(PDOException $e) { echo "Selection failed: " . $e->getMessage(); }

    if ($result != NULL) { return true; }
    else { return false; }
  }
  else { return false; }
}

function get_competence($db, $id)
{
  try {
    $db_req = $db->prepare(
      'SELECT *
       FROM competence
       WHERE competence.id = '.$id
      );
    $db_req->execute();
    $result = $db_req->fetchAll();
    if (!empty($result))
    {
      return create_competence($result[0]);
    }
    else { return false; }
  }
  catch(PDOException $e) { echo "Selection failed: " . $e->getMessage(); }
}

function get_all_competence($db)
{
  try {
    $db_req = $db->prepare(
      'SELECT *
       FROM competence
       ORDER BY id'
      );
    $db_req->execute();
    $competence_tab = [];
    $result = $db_req->fetchAll();
    if (!empty($result))
    {
      for ($i = 0; $i < count($result); ++$i)
      {
        $competence_tab[] = create_competence($result[$i]);
      }
      return $competence_tab;
    }
    else { return false; }
  }
  catch(PDOException $e) { echo "Selection failed: " . $e->getMessage(); }
}

 ?>
