<?php

include "../Global/connect.php";
include "../Global/global.php";
require_once "../Models/Competence.php";

function create_competence($array_competence)
{
  return new Competence($array_competence);
}

function add_competence($db, Competence $competence)
{

}

function update_competence($db, Competence $competence)
{

}

function delete_competence($db, Competence $competence)
{

}

function competence_exists($db, $index_unity)
{

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
    return create_competence($result[0]);
  }
  catch(PDOException $e) { echo "Selection failed: " . $e->getMessage(); }
}

function get_all_competence()
{

}

 ?>
