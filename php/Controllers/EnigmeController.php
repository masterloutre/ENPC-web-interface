<?php
/* ENIGME */

include "../Global/connect.php";
require_once "../Models/Enigme.php";

$array = [
  "index_unity" => 3,
  "type" => 1,
  "nom" => "Nom",
  "temps_max" => 10,
  "difficulte" => 1,
  "score_max" => 150,
  "tentatives_max" => 1
];

$enigme = create_enigme($array);
add_enigme($db, $enigme);

function create_enigme($array_enigme)
{
  return new Enigme($array_enigme);
}

function add_enigme($db, Enigme $enigme)
{
  try {
    $db_req = $db->prepare('INSERT INTO enigme
      (index_unity, type, nom, temps_max, difficulte, score_max, tentatives_max, competence_id)
      VALUES ('.$enigme->get_index_unity().','.$enigme->get_type().',"'.$enigme->get_nom().'",'.$enigme->get_temps_max().','.$enigme->get_difficulte().','.$enigme->get_score_max().','.$enigme->get_tentatives_max().', 1)');
    $db_req->execute();
  }
  catch(PDOException $e) { echo "Connection failed: " . $e->getMessage(); }
}

function update_enigme(Enigme $enigme)
{

}

function enigme_exists($unity_index)
{

}

function get_enigme($id)
{

}

function get_all_enigme()
{

}

 ?>
