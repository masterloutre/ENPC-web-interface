<?php
/* ENIGME */

require "../Global/connect.php";
require "../Global/global.php";
require_once "../Models/Enigme.php";
require_once "../Models/Competence.php";

function create_enigme($array_enigme)
{
  return new Enigme($array_enigme);
}

function add_enigme($db, Enigme $enigme)
{
  if(!enigme_exists($db, $enigme))
  {
    try {
      $db_req = $db->prepare('INSERT INTO enigme
        (index_unity, type, nom, temps_max, difficulte, score_max, tentatives_max, competence_id)
        VALUES ('.$enigme->get_index_unity().','.$enigme->get_type().',"'.$enigme->get_nom().'",'.$enigme->get_temps_max().','.$enigme->get_difficulte().','.$enigme->get_score_max().','.$enigme->get_tentatives_max().','.$enigme->get_competence()->get_id().')');
      $db_req->execute();
      $enigme->set_id($db->lastInsertId());
      return true;
    }
    catch(PDOException $e) {
      echo "Insertion failed: " . $e->getMessage();
      return false;
    }
  }
  else { return false; }
}

function update_enigme($db, Enigme $enigme)
{
  if(enigme_exists($db, $enigme) && $enigme->get_id() != NULL)
  {
    try {
      $db_req = $db->prepare('UPDATE enigme
        SET index_unity = '.$enigme->get_index_unity().', type = '.$enigme->get_type().', nom = "'.$enigme->get_nom().'", temps_max = '.$enigme->get_temps_max().', difficulte = '.$enigme->get_difficulte().', score_max = '.$enigme->get_score_max().', tentatives_max = '.$enigme->get_tentatives_max().', competence_id = '.$enigme->get_competence()->get_id().'
        WHERE enigme.id = '.$enigme->get_id()
        );
      $db_req->execute();
      return true;
    }
    catch(PDOException $e) {
      echo "Update failed: " . $e->getMessage();
      return false;
    }
  }
  else { return false; }
}

function delete_enigme($db, Enigme $enigme)
{
  if(enigme_exists($db, $enigme))
  {
    try {
      $db_req = $db->prepare('DELETE
        FROM enigme
        WHERE enigme.id = '.$enigme->get_id()
        );
      $db_req->execute();
      return true;
    }
    catch(PDOException $e) {
      echo "Deletion failed: " . $e->getMessage();
      return false;
    }
  }
  else { return false; }
}

function enigme_exists($db, Enigme $enigme)
{
  try {
    $db_req = $db->prepare('SELECT id
      FROM enigme
      WHERE enigme.index_unity = '.$enigme->get_index_unity()
      );
    $db_req->execute();
    $result = $db_req->fetchAll();
  }
  catch(PDOException $e) {
    echo "Selection failed: " . $e->getMessage();
    return false;
  }

  if ($result != NULL) { return true; }
  else { return false; }
}

function get_enigme($db, $id)
{
  try {
    $db_req = $db->prepare('SELECT id, index_unity, type, nom, temps_max, difficulte, score_max, tentatives_max, competence_id
      FROM enigme
      WHERE enigme.id = '.$id
      );
    $db_req->execute();
    $result = $db_req->fetchAll();
    if (!empty($result))
    {
      $result[0]["competence"] = get_competence($db, $result[0]["competence_id"]);
      return create_enigme($result[0]);
    }
    else { return false; }
  }
  catch(PDOException $e) {
    echo "Selection failed: " . $e->getMessage();
    return false;
  }
}

function get_all_enigme($db)
{
  try {
    $db_req = $db->prepare('SELECT id, index_unity, type, nom, temps_max, difficulte, score_max, tentatives_max, competence_id
      FROM enigme
      ORDER BY id'
      );
    $db_req->execute();
    $enigme_tab = [];
    $result = $db_req->fetchAll();
    if (!empty($result))
    {
      for ($i = 0; $i < count($result); ++$i)
      {
        $result[$i]["competence"] = get_competence($db, $result[$i]["competence_id"]);
        $enigme_tab[] = create_enigme($result[$i]);
      }
      return $enigme_tab;
    }
    else { return false; }
  }
  catch(PDOException $e) {
    echo "Selection failed: " . $e->getMessage();
    return false;
  }
}

 ?>
