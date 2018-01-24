<?php
/* ENIGME */

include "../Global/connect.php";
include "../Global/global.php";
require_once "../Models/Enigme.php";
require_once "../Models/CompetenceController.php";

$array = [
  "id" => 11,
  "index_unity" => 3,
  "type" => 1,
  "nom" => "Hello",
  "temps_max" => 10,
  "difficulte" => 1,
  "score_max" => 150,
  "tentatives_max" => 1,
  "competence" => $competence1
];

$enigme = create_enigme($array);

$getenigme = get_enigme($db, 1);
var_dump($getenigme);

function create_enigme($array_enigme)
{
  return new Enigme($array_enigme);
}

function add_enigme($db, Enigme $enigme)
{
  if(enigme_exists($db, $enigme))
  {
    try {
      $db_req = $db->prepare('INSERT INTO enigme
        (index_unity, type, nom, temps_max, difficulte, score_max, tentatives_max, competence_id)
        VALUES ('.$enigme->get_index_unity().','.$enigme->get_type().',"'.$enigme->get_nom().'",'.$enigme->get_temps_max().','.$enigme->get_difficulte().','.$enigme->get_score_max().','.$enigme->get_tentatives_max().','.$enigme->get_competence()->get_id().')');
      $db_req->execute();
      $enigme->set_id($db->lastInsertId());
    }
    catch(PDOException $e) { echo "Insertion failed: " . $e->getMessage(); }
    return true;
  }
  else { return false; }
}

function update_enigme($db, Enigme $enigme)
{
  if(enigme_exists($db, $enigme))
  {
    try {
      $db_req = $db->prepare('UPDATE enigme
        SET index_unity = '.$enigme->get_index_unity().', type = '.$enigme->get_type().', nom = "'.$enigme->get_nom().'", temps_max = '.$enigme->get_temps_max().', difficulte = '.$enigme->get_difficulte().', score_max = '.$enigme->get_score_max().', tentatives_max = '.$enigme->get_tentatives_max().', competence_id = '.$enigme->get_competence()->get_id().'
        WHERE enigme.id = '.$enigme->get_id()
        );
      var_dump($db_req);
      $db_req->execute();
    }
    catch(PDOException $e) { echo "Update failed: " . $e->getMessage(); }
    return true;
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
        WHERE enigme.id = '.$id
        );
      $db_req->execute();
    }
    catch(PDOException $e) { echo "Deletion failed: " . $e->getMessage(); }
    return true;
  }
  else { return false; }
}

function enigme_exists($db, $index_unity)
{
  try {
    $db_req = $db->prepare('SELECT id
      FROM enigme
      WHERE enigme.index_unity = '.$index_unity
      );
    $db_req->execute();
    $result = $db_req->fetchAll();
  }
  catch(PDOException $e) { echo "Selection failed: " . $e->getMessage(); }

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
    if ($result != NULL)
    {
      $result[0]["competence_id"] = get_comptence($db, $result[0]["competence_id"]);
      return create_enigme($result[0]);
    }
    else { return false; }

  }
  catch(PDOException $e) { echo "Selection failed: " . $e->getMessage(); }
}

function get_all_enigme()
{
  try {
    $db_req = $db->prepare('SELECT id, index_unity, type, nom, temps_max, difficulte, score_max, tentatives_max, competence_id
      FROM enigme'
      );
    $db_req->execute();
    $enigme_tab = [];
    while ($result = $db_req->fetch(PDO::FETCH_ASSOC))
    {
      $result["competence_id"] = get_comptence($db, $result["competence_id"]);
      $enigme_tab[] = create_enigme($result);
    }
    else { return false; }
  }
  catch(PDOException $e) { echo "Selection failed: " . $e->getMessage(); }
}

function get_score($db, Etudiant $etudiant, Enigme $enigme)
{
  return new Score(/*...*/);
}

 ?>
