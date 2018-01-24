<?php

include "../Global/connect.php";
include "../Global/global.php";
require_once "../Models/Score.php";

function create_score($array_score)
{
  return new Score($array_score);
}

function add_score($db, Score $score)
{
  if(score_exists($db, $score))
  {
    try {
      $db_req = $db->prepare('INSERT INTO score
        (nom)
        VALUES ('.$score->get_nom().')');
      $db_req->execute();
      $score->set_id($db->lastInsertId());
      return true;
    }
    catch(PDOException $e) { echo "Insertion failed: " . $e->getMessage(); }
  }
  else { return false; }
}

function update_score($db, Score $score)
{
  if(score_exists($db, $score))
  {
    try {
      $db_req = $db->prepare('UPDATE score
        SET nom = '.$score->get_nom().'
        WHERE score.id = '.$enigme->get_id()
        );
      $db_req->execute();
    }
    catch(PDOException $e) { echo "Update failed: " . $e->getMessage(); }
    return true;
  }
  else { return false; }
}

function delete_score($db, Score $score)
{
  if(score_exists($db, $score))
  {
    try {
      $db_req = $db->prepare('DELETE
        FROM score
        WHERE score.id = '.$id
        );
      $db_req->execute();
      return true;
    }
    catch(PDOException $e) { echo "Deletion failed: " . $e->getMessage(); }
  }
  else { return false; }
}

function score_exists($db, $id)
{
  try {
    $db_req = $db->prepare('SELECT id
      FROM score
      WHERE score.id= '.$id
      );
    $db_req->execute();
    $result = $db_req->fetchAll();
  }
  catch(PDOException $e) { echo "Selection failed: " . $e->getMessage(); }

  if ($result != NULL) { return true; }
  else { return false; }
}

function get_score($db, $id)
{
  try {
    $db_req = $db->prepare(
      'SELECT *
       FROM score
       WHERE score.id = '.$id
      );
    $db_req->execute();
    $result = $db_req->fetchAll();
    return create_score($result[0]);
  }
  catch(PDOException $e) { echo "Selection failed: " . $e->getMessage(); }
}

function get_all_score()
{
  try {
    $db_req = $db->prepare('SELECT *
      FROM score
      ORDER BY id'
      );
    $db_req->execute();
    $score_tab = [];
    $result = $db_req->fetchAll();
    if (!empty($result))
    {
      for ($i = 0; $i < count($result); ++$i)
      {
        $enigme_tab[] = create_score($result[$i]);
      }
      return $comptence_tab;
    }
    else { return false; }
  }
  catch(PDOException $e) { echo "Selection failed: " . $e->getMessage(); }
}

 ?>
