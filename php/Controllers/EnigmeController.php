<?php
/* ENIGME */

include "../Global/connect.php";
include "../Global/global.php";
require_once "../Models/Enigme.php";

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
//add_enigme($db, $enigme);
update_enigme($db, $enigme);

function create_enigme($array_enigme)
{
  return new Enigme($array_enigme);
}

function add_enigme($db, Enigme $enigme)
{
  try {
    $db_req = $db->prepare('INSERT INTO enigme
      (index_unity, type, nom, temps_max, difficulte, score_max, tentatives_max, competence_id)
      VALUES ('.$enigme->get_index_unity().','.$enigme->get_type().',"'.$enigme->get_nom().'",'.$enigme->get_temps_max().','.$enigme->get_difficulte().','.$enigme->get_score_max().','.$enigme->get_tentatives_max().','.$enigme->get_competence()->get_id().')');
    $db_req->execute();
  }
  catch(PDOException $e) { echo "Insertion failed: " . $e->getMessage(); }
}

function update_enigme($db, Enigme $enigme)
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
